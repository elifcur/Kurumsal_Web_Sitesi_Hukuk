<?php

namespace Templates\Law\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Templates\Law\Http\Requests\ConsultationUpdateRequest;
use Templates\Law\Models\Consultation;

class ConsultationController extends Controller
{
    public function index(Request $request): View
    {
        $consultations = Consultation::query()
            ->with(['service', 'teamMember'])
            ->when($request->filled('q'), function ($q) use ($request): void {
                $term = $request->string('q')->limit(100);
                $q->where(fn ($w) => $w->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%")->orWhere('subject', 'like', "%{$term}%"));
            })
            ->when($request->filled('status') && array_key_exists($request->input('status'), Consultation::STATUSES), fn ($q) => $q->status($request->input('status')))
            ->newest()
            ->paginate(config('cms.pagination.admin'))
            ->withQueryString();

        return view('template::admin.consultations.index', [
            'consultations' => $consultations,
            'counts' => Consultation::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function show(Consultation $consultation): View
    {
        return view('template::admin.consultations.show', [
            'consultation' => $consultation->load(['service', 'teamMember']),
            'lawyers' => TeamMember::query()->active()->ordered()->pluck('name', 'id')->all(),
        ]);
    }

    public function update(ConsultationUpdateRequest $request, Consultation $consultation): RedirectResponse
    {
        $consultation->update($request->payload());

        return redirect()->route('admin.consultations.show', $consultation)->with('success', 'Talep güncellendi.');
    }

    public function destroy(Consultation $consultation): RedirectResponse
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')->with('success', 'Talep silindi.');
    }
}
