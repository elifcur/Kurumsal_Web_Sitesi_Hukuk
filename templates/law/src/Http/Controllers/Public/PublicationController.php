<?php

namespace Templates\Law\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Templates\Law\Models\Publication;

class PublicationController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'tur' => ['nullable', Rule::in(array_keys(Publication::TYPES))],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $publications = Publication::query()->active()
            ->when($filters['tur'] ?? null, fn ($q, $v) => $q->ofType($v))
            ->when($filters['q'] ?? null, fn ($q, $v) => $q->where(fn ($w) => $w->where('title', 'like', "%{$v}%")->orWhere('summary', 'like', "%{$v}%")))
            ->ordered()
            ->paginate(config('cms.pagination.public'))
            ->withQueryString();

        return view('template::publications.index', [
            'publications' => $publications,
            'filters' => $filters,
            'typeCounts' => Publication::query()->active()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type'),
        ]);
    }
}
