@props(['post', 'layout' => 'row'])
@if($layout === 'row')
    {{-- Liste satırı: tarih | başlık | özet --}}
    <article class="group grid gap-3 border-b border-slate-200 py-7 md:grid-cols-12 md:gap-8">
        <div class="text-xs tracking-wide text-slate-500 uppercase md:col-span-2">
            @if($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>@endif
            @if($post->category)<span class="mt-1 block text-gold">{{ $post->category->name }}</span>@endif
        </div>
        <div class="md:col-span-10">
            <h3 class="font-display text-2xl font-semibold text-ink"><a href="{{ $post->url() }}" class="transition hover:text-primary">{{ $post->title }}</a></h3>
            @if($post->excerpt)<p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>@endif
            <a href="{{ $post->url() }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold tracking-[0.15em] text-primary uppercase">Devamını oku <x-icon name="arrow-right" class="h-3.5 w-3.5 transition group-hover:translate-x-1" /></a>
        </div>
    </article>
@else
    <article class="card group flex flex-col overflow-hidden">
        <a href="{{ $post->url() }}" class="block aspect-[16/10] w-full overflow-hidden bg-parchment">
            @if($post->image)<img src="{{ upload_url($post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">@else<div class="flex h-full w-full items-center justify-center text-primary/20"><x-icon name="newspaper" class="h-12 w-12" /></div>@endif
        </a>
        <div class="flex flex-1 flex-col p-6">
            <div class="flex items-center gap-3 text-xs tracking-wide text-slate-500 uppercase">
                @if($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>@endif
                @if($post->category)<span class="text-gold">{{ $post->category->name }}</span>@endif
            </div>
            <h3 class="mt-3 font-display text-xl font-semibold text-ink"><a href="{{ $post->url() }}" class="hover:text-primary">{{ $post->title }}</a></h3>
            @if($post->excerpt)<p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>@endif
        </div>
    </article>
@endif
