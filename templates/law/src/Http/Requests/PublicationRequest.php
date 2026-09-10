<?php

namespace Templates\Law\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Templates\Law\Models\Publication;

class PublicationRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:180', 'regex:/^[a-z0-9\-]+$/', Rule::unique('publications', 'slug')->ignore($this->route('publication'))],
            'type' => ['required', Rule::in(array_keys(Publication::TYPES))],
            'summary' => ['nullable', 'string', 'max:1000'],
            'file' => ['nullable', 'string', 'max:255', 'required_without:external_url'],
            'external_url' => ['nullable', 'url:http,https', 'max:500', 'required_without:file'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required_without' => 'Bir PDF dosyası seçin ya da dış bağlantı girin.',
            'external_url.required_without' => 'Bir PDF dosyası seçin ya da dış bağlantı girin.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        $data = $this->validated();
        $data['slug'] = ($data['slug'] ?? null) ?: null;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['file'] = ($data['file'] ?? null) ?: null;
        $data['external_url'] = ($data['external_url'] ?? null) ?: null;
        $data['published_at'] = ($data['published_at'] ?? null) ?: null;

        return $data;
    }
}
