<?php

namespace Templates\Law\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\ContactController;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Templates\Law\Models\Consultation;

class ConsultationController extends Controller
{
    public function create(): View
    {
        return view('template::consultations.create', [
            'services' => Service::query()->active()->ordered()->get(['id', 'title']),
            'lawyers' => TeamMember::query()->active()->ordered()->get(['id', 'name', 'title']),
        ]);
    }

    /**
     * Ana sayfadaki hızlı randevu formu ("quick") mesaj alanı taşımaz; tam ön görüşme formu ise zorunlu tutar.
     */
    public function store(Request $request): RedirectResponse
    {
        $isQuick = $request->boolean('quick');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'team_member_id' => ['nullable', 'integer', Rule::exists('team_members', 'id')->where('is_active', true)],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => [Rule::requiredIf(! $isQuick), 'nullable', 'string', 'min:20', 'max:5000'],
            'preferred_contact' => ['required', Rule::in(array_keys(Consultation::CONTACT_METHODS))],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'kvkk' => ['accepted'],
            'website' => ['prohibited'],
            'quick' => ['nullable', 'boolean'],
        ], [
            'kvkk.accepted' => 'Devam etmek için KVKK aydınlatma metnini onaylamalısınız.',
            'website.prohibited' => 'Form doğrulaması başarısız oldu.',
            'message.min' => 'Lütfen meselenizi en az birkaç cümleyle özetleyin.',
            'preferred_date.after_or_equal' => 'Tercih edilen tarih bugünden önce olamaz.',
        ]);

        $consultation = Consultation::query()->create([
            ...Arr::only($data, ['name', 'email', 'phone', 'subject', 'preferred_contact']),
            'message' => ($data['message'] ?? null) ?: 'Ana sayfadaki hızlı randevu formundan gönderildi; ayrıntılar ilk aramada alınacaktır.',
            'service_id' => ($data['service_id'] ?? null) ?: null,
            'team_member_id' => ($data['team_member_id'] ?? null) ?: null,
            'preferred_date' => ($data['preferred_date'] ?? null) ?: null,
            'status' => 'new',
            'ip' => $request->ip(),
        ]);

        $consultation->load(['service', 'teamMember']);

        $message = ContactMessage::query()->create([
            'type' => 'consultation',
            'name' => $consultation->name,
            'email' => $consultation->email,
            'phone' => $consultation->phone,
            'subject' => 'Ön Görüşme Talebi: '.($consultation->subject ?: $consultation->name),
            'message' => $consultation->message,
            'meta' => array_filter([
                'Çalışma Alanı' => $consultation->service?->title,
                'Tercih Edilen Avukat' => $consultation->teamMember?->name,
                'İletişim Tercihi' => $consultation->contactMethodLabel(),
                'Tercih Edilen Tarih' => $consultation->preferred_date?->format('d.m.Y'),
                'Talep No' => '#'.$consultation->id,
            ]),
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        ContactController::notify($message);

        $success = setting('consultation_success', 'Ön görüşme talebiniz alındı. Avukatımız en kısa sürede sizinle iletişime geçecektir.');

        if ($isQuick) {
            return redirect()->to(route('home').'#randevu')->with(['success' => $success, 'quick' => true]);
        }

        return redirect()->route('consultations.create')->with('success', $success);
    }
}
