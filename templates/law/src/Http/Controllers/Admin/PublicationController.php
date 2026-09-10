<?php

namespace Templates\Law\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Templates\Law\Http\Requests\PublicationRequest;
use Templates\Law\Models\Publication;

class PublicationController extends Controller
{
    public function index(Request $request): View
    {
        $publications = Publication::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q')->limit(100).'%'))
            ->when($request->filled('type') && array_key_exists($request->input('type'), Publication::TYPES), fn ($q) => $q->ofType($request->input('type')))
            ->when($request->input('status') === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->input('status') === 'inactive', fn ($q) => $q->where('is_active', false))
            ->ordered()
            ->paginate(config('cms.pagination.admin'))
            ->withQueryString();

        return view('template::admin.publications.index', ['publications' => $publications]);
    }

    public function create(): View
    {
        return view('template::admin.publications.form', [
            'publication' => new Publication(['is_active' => true, 'type' => 'guide', 'published_at' => now()]),
        ]);
    }

    public function store(PublicationRequest $request): RedirectResponse
    {
        $publication = Publication::query()->create($request->payload());

        return redirect()->route('admin.publications.edit', $publication)->with('success', 'Kaynak oluşturuldu.');
    }

    public function edit(Publication $publication): View
    {
        return view('template::admin.publications.form', ['publication' => $publication]);
    }

    public function update(PublicationRequest $request, Publication $publication): RedirectResponse
    {
        $publication->update($request->payload());

        return redirect()->route('admin.publications.edit', $publication)->with('success', 'Kaynak güncellendi.');
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();

        return redirect()->route('admin.publications.index')->with('success', 'Kaynak silindi.');
    }
}
