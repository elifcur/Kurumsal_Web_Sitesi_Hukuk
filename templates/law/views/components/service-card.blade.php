@props(['service'])
<article class="card group flex flex-col overflow-hidden">
    <a href="{{ $service->url() }}" class="relative block" tabindex="-1" aria-hidden="true">
        <div class="aspect-[16/10] overflow-hidden bg-cream">
            @if($service->image)
                <img src="{{ upload_url($service->image) }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]" loading="lazy">
            @else
                <div class="flex h-full w-full items-center justify-center text-gold/40"><x-icon :name="$service->icon ?: 'scale'" class="h-14 w-14" /></div>
            @endif
        </div>
        <span class="icon-badge"><x-icon :name="$service->icon ?: 'scale'" class="h-5 w-5" /></span>
    </a>
    <div class="flex flex-1 flex-col px-4 pt-9 pb-5">
        <h3 class="font-sans text-lg font-semibold text-ink group-hover:text-gold-dark"><a href="{{ $service->url() }}">{{ $service->title }}</a></h3>
        @if($service->excerpt)<p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">{{ $service->excerpt }}</p>@endif
        <a href="{{ $service->url() }}" class="link-more mt-4">Detaylı Bilgi <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1" /></a>
    </div>
</article>
