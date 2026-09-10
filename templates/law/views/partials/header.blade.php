@php
    $siteName = setting('site_name', config('app.name'));
    $logo = upload_url(setting('logo'));
    $appointmentLabel = setting('appointment_button_text', 'Randevu Al');
@endphp
<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur transition-shadow" :class="scrolled && 'shadow-md'">
    <div class="container-x flex h-16 items-center justify-between gap-4 md:h-[76px] lg:gap-6">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="{{ $siteName }}">
            @if($logo)
                <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-9 w-auto md:h-11">
            @else
                <span class="flex h-10 w-10 items-center justify-center text-ink"><x-icon name="scale" class="h-8 w-8" /></span>
                <span class="leading-tight"><span class="block font-display text-xl font-bold tracking-tight text-ink md:text-2xl">{{ $siteName }}</span>@if(setting('site_tagline'))<span class="block text-[10px] tracking-[0.3em] text-slate-500 uppercase">{{ setting('site_tagline') }}</span>@endif</span>
            @endif
        </a>

        <nav class="hidden items-center gap-0.5 lg:flex xl:gap-1" aria-label="Ana menü">
            @foreach($siteNav as $item)
                <a href="{{ $item['url'] }}" @class(['nav-link', 'nav-link-active' => $item['active']])>{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-2 md:gap-3 xl:gap-4">
            <a href="{{ route('publications.index') }}" class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-md text-slate-700 transition hover:bg-slate-100 hover:text-ink xl:flex" aria-label="Kaynaklarda ara"><x-icon name="search" class="h-5 w-5" /></a>
            <a href="{{ route('consultations.create') }}" class="btn-brand hidden shrink-0 !py-2.5 whitespace-nowrap lg:inline-flex"><x-icon name="calendar" class="h-4 w-4 text-gold" /> {{ $appointmentLabel }}</a>
            <button type="button" class="rounded-md p-2 text-slate-700 hover:bg-slate-100 lg:hidden" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Menüyü aç/kapat">
                <span x-show="!mobileOpen"><x-icon name="menu" class="h-6 w-6" /></span>
                <span x-show="mobileOpen" x-cloak><x-icon name="x" class="h-6 w-6" /></span>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition.opacity class="fixed inset-0 top-16 z-40 bg-ink/40 lg:hidden" @click="mobileOpen = false"></div>
    <nav x-show="mobileOpen" x-cloak x-transition class="absolute inset-x-0 top-full z-50 max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-slate-200 bg-white shadow-xl lg:hidden" aria-label="Mobil menü">
        <div class="container-x flex flex-col py-3">
            @foreach($siteNav as $item)
                <a href="{{ $item['url'] }}" @class(['flex items-center justify-between rounded-md px-3 py-3 text-base font-medium', 'text-ink bg-cream' => $item['active'], 'text-slate-800 hover:bg-slate-50' => !$item['active']])>
                    {{ $item['label'] }} <x-icon name="chevron-right" class="h-4 w-4 text-slate-400" />
                </a>
            @endforeach
            <a href="{{ route('consultations.create') }}" class="btn-brand mt-3"><x-icon name="calendar" class="h-4 w-4 text-gold" /> {{ $appointmentLabel }}</a>
            <div class="mt-3 flex flex-col gap-2 border-t border-slate-200 pt-4 text-sm text-slate-600">
                @if(setting('phone'))<a href="{{ phone_href(setting('phone')) }}" class="flex items-center gap-2 px-3"><x-icon name="phone" class="h-4 w-4 text-gold" /> {{ setting('phone') }}</a>@endif
                @if(setting('email'))<a href="mailto:{{ setting('email') }}" class="flex items-center gap-2 px-3"><x-icon name="mail" class="h-4 w-4 text-gold" /> {{ setting('email') }}</a>@endif
                @if(setting('bar_registration'))<span class="px-3 text-xs tracking-wide text-slate-500">{{ setting('bar_registration') }}</span>@endif
            </div>
        </div>
    </nav>
</header>
