@extends('template::layouts.app')
@section('seo')<x-seo :title="setting('publications_label', 'Kaynaklar')" description="Rehberler, formlar, makaleler ve mevzuat bültenleri: müvekkillerimiz ve ziyaretçilerimiz için indirilebilir kaynaklar." :robots="request()->query() ? 'noindex, follow' : 'index, follow'" />@endsection
@section('content')
    <x-page-header eyebrow="Kütüphane" :title="setting('publications_label', 'Kaynaklar')" subtitle="Uygulama rehberleri, örnek formlar, makaleler ve aylık mevzuat bültenleri." :breadcrumbs="[['label' => setting('publications_label', 'Kaynaklar')]]" />
    <section class="section !pt-12">
        <div class="container-x">
            <form method="get" x-data="publicationFilters" class="mb-10 flex flex-col gap-4 border-b border-slate-200 pb-8 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap gap-2" role="group" aria-label="Tür filtresi">
                    <a href="{{ route('publications.index', array_filter(['q' => $filters['q'] ?? null])) }}" @class(['chip !px-4 !py-2', '!border-primary !bg-primary !text-white' => empty($filters['tur'])])>Tümü</a>
                    @foreach(\Templates\Law\Models\Publication::TYPES as $key => $label)
                        <a href="{{ route('publications.index', array_filter(['tur' => $key, 'q' => $filters['q'] ?? null])) }}" @class(['chip !px-4 !py-2', '!border-primary !bg-primary !text-white' => ($filters['tur'] ?? '') === $key])>{{ $label }} <span class="opacity-60">{{ $typeCounts[$key] ?? 0 }}</span></a>
                    @endforeach
                </div>
                <div class="relative md:w-72">
                    @if(!empty($filters['tur']))<input type="hidden" name="tur" value="{{ $filters['tur'] }}">@endif
                    <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Kaynaklarda ara..." class="form-input !pr-10">
                    <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-slate-400 hover:text-primary" aria-label="Ara"><x-icon name="search" /></button>
                </div>
            </form>
            @if($publications->isEmpty())
                <x-empty-state icon="document" title="Kaynak bulunamadı" text="Filtreyi değiştirerek tekrar deneyin." />
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@foreach($publications as $publication)<x-publication-card :publication="$publication" />@endforeach</div>
                <div class="mt-10">{{ $publications->links() }}</div>
            @endif
        </div>
    </section>
    <x-cta-band />
@endsection
