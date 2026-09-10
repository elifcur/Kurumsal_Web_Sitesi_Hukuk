<?php

namespace Templates\Law\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Templates\Law\Models\Consultation;

/**
 * Admin tarafında ön görüşme talebinin durum, avukat ve not güncellemesi.
 */
class ConsultationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-sector') ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_keys(Consultation::STATUSES))],
            'team_member_id' => ['nullable', 'integer', Rule::exists('team_members', 'id')],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        $data = $this->validated();
        $data['team_member_id'] = ($data['team_member_id'] ?? null) ?: null;
        $data['notes'] = ($data['notes'] ?? null) ?: null;

        return $data;
    }
}
