<?php

namespace Templates\Law\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Templates\Law\Database\Factories\PublicationFactory;

/**
 * Kaynak: indirilebilir rehber, form, makale ya da bülten (PDF veya dış bağlantı).
 */
#[UseFactory(PublicationFactory::class)]
#[Fillable(['title', 'slug', 'type', 'summary', 'file', 'external_url', 'published_at', 'is_active', 'sort_order'])]
class Publication extends Model
{
    use HasFactory, HasSlug;

    public const TYPES = ['guide' => 'Rehber', 'form' => 'Form', 'article' => 'Makale', 'bulletin' => 'Bülten'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderByDesc('published_at')->orderByDesc('id');
    }

    #[Scope]
    protected function ofType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /** Dosya varsa dosya adresi, yoksa dış bağlantı (ikisi de yoksa null). */
    public function url(): ?string
    {
        if ($this->file) {
            return upload_url($this->file);
        }

        return $this->external_url ?: null;
    }

    public function isExternal(): bool
    {
        return ! $this->file && (bool) $this->external_url;
    }
}
