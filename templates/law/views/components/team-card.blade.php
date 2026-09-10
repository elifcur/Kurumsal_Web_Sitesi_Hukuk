@props(['member'])
<a href="{{ $member->url() }}" class="card group overflow-hidden">
    <div class="aspect-[4/5] overflow-hidden bg-parchment">
        @if($member->image)<img src="{{ upload_url($member->image) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy">@else<div class="flex h-full items-center justify-center text-primary/20"><x-icon name="user" class="h-20 w-20" /></div>@endif
    </div>
    <div class="p-6">
        <h3 class="font-display text-2xl font-semibold text-ink group-hover:text-primary">{{ $member->name }}</h3>
        @if($member->title)<p class="mt-1 text-xs font-semibold tracking-[0.15em] text-gold uppercase">{{ $member->title }}</p>@endif
        <dl class="mt-4 space-y-1.5 border-t border-slate-100 pt-4 text-sm">
            @if($member->attribute('Uzmanlık'))<div class="flex gap-2"><dt class="w-20 shrink-0 text-slate-400">Uzmanlık</dt><dd class="text-slate-700">{{ $member->attribute('Uzmanlık') }}</dd></div>@endif
            @if($member->attribute('Baro'))<div class="flex gap-2"><dt class="w-20 shrink-0 text-slate-400">Baro</dt><dd class="text-slate-700">{{ $member->attribute('Baro') }}</dd></div>@endif
        </dl>
    </div>
</a>
