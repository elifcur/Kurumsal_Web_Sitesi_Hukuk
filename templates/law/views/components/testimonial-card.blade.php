@props(['testimonial'])
<figure class="card flex h-full flex-col p-7">
    <span class="font-display text-5xl leading-none text-gold">&ldquo;</span>
    <blockquote class="mt-2 flex-1 font-display text-xl leading-relaxed text-ink italic">{{ $testimonial->content }}</blockquote>
    <figcaption class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-primary/10 text-sm font-bold text-primary">@if($testimonial->image)<img src="{{ upload_url($testimonial->image) }}" alt="" class="h-full w-full object-cover">@else{{ mb_substr($testimonial->name, 0, 1) }}@endif</span>
        <span><span class="block text-sm font-semibold text-ink">{{ $testimonial->name }}</span>@if($testimonial->title)<span class="block text-xs text-slate-500">{{ $testimonial->title }}</span>@endif</span>
        @if($testimonial->rating)<span class="ml-auto flex text-gold" aria-label="{{ $testimonial->rating }} yıldız">@for($i = 0; $i < $testimonial->rating; $i++)<x-icon name="star" class="h-3.5 w-3.5 fill-current" />@endfor</span>@endif
    </figcaption>
</figure>
