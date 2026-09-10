@php($siteName = setting('site_name', config('app.name')))
<footer class="mt-auto bg-ink text-slate-300">
    <div class="container-x grid gap-10 py-16 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white">
                @if(setting('logo'))
                    <img src="{{ upload_url(setting('logo')) }}" alt="{{ $siteName }}" class="h-10 w-auto brightness-0 invert">
                @else
                    <span class="text-gold"><x-icon name="scale" class="h-8 w-8" /></span>
                    <span class="font-display text-xl font-semibold">{{ $siteName }}</span>
                @endif
            </a>
            <p class="mt-4 text-sm leading-6 text-slate-400">{{ setting('site_tagline') }}</p>
            @if(setting('bar_registration'))<p class="mt-4 text-xs tracking-[0.15em] text-gold/80 uppercase">{{ setting('bar_registration') }}</p>@endif
            <div class="mt-5 flex items-center gap-3">
                @foreach(['linkedin', 'twitter', 'instagram', 'facebook', 'youtube'] as $social)
                    @if(setting($social))<a href="{{ setting($social) }}" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-slate-300 transition hover:border-gold hover:text-gold" aria-label="{{ ucfirst($social) }}"><x-icon :name="$social" class="h-4 w-4" /></a>@endif
                @endforeach
            </div>
        </div>
        <div>
            <h3 class="text-xs font-semibold tracking-[0.25em] text-gold uppercase">Menü</h3>
            <ul class="mt-5 space-y-2.5 text-sm">
                @foreach($siteNav as $item)<li><a href="{{ $item['url'] }}" class="transition hover:text-white">{{ $item['label'] }}</a></li>@endforeach
                <li><a href="{{ route('consultations.create') }}" class="transition hover:text-white">{{ setting('consultation_label', 'Ön Görüşme') }}</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-xs font-semibold tracking-[0.25em] text-gold uppercase">{{ setting('services_label', 'Çalışma Alanları') }}</h3>
            <ul class="mt-5 space-y-2.5 text-sm">
                @forelse($footerServices as $service)
                    <li><a href="{{ route('services.show', $service['slug']) }}" class="transition hover:text-white">{{ $service['title'] }}</a></li>
                @empty
                    <li><a href="{{ route('services.index') }}" class="transition hover:text-white">Tüm çalışma alanları</a></li>
                @endforelse
            </ul>
        </div>
        <div>
            <h3 class="text-xs font-semibold tracking-[0.25em] text-gold uppercase">İletişim</h3>
            <ul class="mt-5 space-y-3 text-sm">
                @if(setting('address'))<li class="flex gap-3"><x-icon name="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-gold" /><span>{{ setting('address') }}</span></li>@endif
                @if(setting('phone'))<li class="flex gap-3"><x-icon name="phone" class="mt-0.5 h-4 w-4 shrink-0 text-gold" /><a href="{{ phone_href(setting('phone')) }}" class="hover:text-white">{{ setting('phone') }}</a></li>@endif
                @if(setting('email'))<li class="flex gap-3"><x-icon name="mail" class="mt-0.5 h-4 w-4 shrink-0 text-gold" /><a href="mailto:{{ setting('email') }}" class="hover:text-white">{{ setting('email') }}</a></li>@endif
                @if(setting('working_hours'))<li class="flex gap-3"><x-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-gold" /><span>{{ setting('working_hours') }}@if(setting('office_hours_note'))<span class="block text-xs text-slate-500">{{ setting('office_hours_note') }}</span>@endif</span></li>@endif
            </ul>
        </div>
    </div>
    @if(setting('disclaimer_text'))
        <div class="border-t border-white/10">
            <div class="container-x py-6">
                <p class="text-xs leading-relaxed text-slate-500"><span class="font-semibold tracking-wide text-slate-400 uppercase">Yasal Uyarı:</span> {{ setting('disclaimer_text') }}</p>
            </div>
        </div>
    @endif
    <div class="border-t border-white/10">
        <div class="container-x flex flex-col items-center justify-between gap-3 py-5 text-xs text-slate-500 md:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ setting('footer_text') }}</p>
            <ul class="flex flex-wrap items-center gap-4">
                @foreach($footerPages as $page)<li><a href="{{ route('page.show', $page['slug']) }}" class="hover:text-white">{{ $page['title'] }}</a></li>@endforeach
            </ul>
        </div>
    </div>
</footer>
