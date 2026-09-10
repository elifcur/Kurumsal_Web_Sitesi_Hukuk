@props(['title' => null, 'text' => null, 'buttonText' => null, 'buttonUrl' => null])
@php
    $title = $title ?? setting('cta_title');
    $text = $text ?? setting('cta_text');
    $buttonText = $buttonText ?? setting('cta_button_text');
    $buttonUrl = $buttonUrl ?? setting('cta_button_url', route('consultations.create'));
@endphp
@if($title)
<section class="relative overflow-hidden bg-ink text-white">
    @if(setting('hero_image'))<img src="{{ upload_url(setting('hero_image')) }}" alt="" class="absolute inset-0 h-full w-full object-cover object-[right_center] opacity-30" aria-hidden="true" loading="lazy">@endif
    <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/90 to-ink/40"></div>
    <div class="container-x relative flex flex-col items-start justify-between gap-8 py-16 md:flex-row md:items-center">
        <div class="max-w-2xl">
            <span class="eyebrow">Hemen başlayın</span>
            <h2 class="font-display text-3xl leading-tight md:text-4xl">{!! emphasize($title) !!}</h2>
            @if($text)<p class="mt-3 text-lg text-white/75">{{ $text }}</p>@endif
        </div>
        @if($buttonText)<a href="{{ $buttonUrl }}" class="btn-primary shrink-0 !px-7 !py-3.5">{{ $buttonText }} <x-icon name="arrow-right" class="h-4 w-4" /></a>@endif
    </div>
</section>
@endif
