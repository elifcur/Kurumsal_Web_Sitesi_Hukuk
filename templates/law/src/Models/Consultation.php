<?php

namespace Templates\Law\Models;

use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Templates\Law\Database\Factories\ConsultationFactory;

/**
 * Ön görüşme talebi: siteden gelen randevu/danışma isteği ve admin takibi.
 */
#[UseFactory(ConsultationFactory::class)]
#[Fillable(['name', 'email', 'phone', 'service_id', 'team_member_id', 'subject', 'message', 'preferred_contact', 'preferred_date', 'status', 'notes', 'ip'])]
class Consultation extends Model
{
    use HasFactory;

    public const STATUSES = ['new' => 'Yeni', 'contacted' => 'İletişime Geçildi', 'scheduled' => 'Randevu Verildi', 'closed' => 'Kapatıldı'];

    public const CONTACT_METHODS = ['phone' => 'Telefon', 'email' => 'E-posta', 'office' => 'Ofiste görüşme'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    #[Scope]
    protected function status(Builder $query, string $status): void
    {
        $query->where('status', $status);
    }

    #[Scope]
    protected function newest(Builder $query): void
    {
        $query->orderByDesc('id');
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function contactMethodLabel(): string
    {
        return self::CONTACT_METHODS[$this->preferred_contact] ?? $this->preferred_contact;
    }

    /** Admin tablo/badge rengi (admin.css sınıf adı). */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'new' => 'badge-blue',
            'contacted' => 'badge-yellow',
            'scheduled' => 'badge-green',
            default => 'badge-gray',
        };
    }
}
