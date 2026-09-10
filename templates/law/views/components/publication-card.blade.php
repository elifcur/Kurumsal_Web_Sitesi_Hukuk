@props(['publication'])
@php($url = $publication->url())
<article class="card flex h-full flex-col p-7">
    <div class="flex items-center justify-between gap-3">
        <span class="chip">{{ $publication->typeLabel() }}</span>
        @if($publication->published_at)<time datetime="{{ $publication->published_at->toDateString() }}" class="text-xs tracking-wide text-slate-500 uppercase">{{ $publication->published_at->translatedFormat('F Y') }}</time>@endif
    </div>
    <h3 class="mt-5 font-display text-2xl font-semibold text-ink">{{ $publication->title }}</h3>
    @if($publication->summary)<p class="mt-2 flex-1 text-sm leading-6 text-slate-600">{{ $publication->summary }}</p>@endif
    @if($url)
        <a href="{{ $url }}" @if($publication->isExternal()) target="_blank" rel="noopener" @else download @endif class="mt-6 inline-flex items-center gap-1.5 text-xs font-semibold tracking-[0.15em] text-primary uppercase">
            @if($publication->isExternal())Bağlantıya git <x-icon name="external" class="h-3.5 w-3.5" />@else PDF indir <x-icon name="document" class="h-3.5 w-3.5" />@endif
        </a>
    @endif
</article>
