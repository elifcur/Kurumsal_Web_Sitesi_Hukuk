@extends('template::layouts.app')

@section('content')
    {{-- Hero: siyah zemin üstünde adalet heykeli fotoğrafı, soldan sağa koyu gradient --}}
    <section class="relative flex min-h-[560px] items-center overflow-hidden bg-ink text-white md:min-h-[600px]">
        @if(setting('hero_image'))
            <img src="{{ upload_url(setting('hero_image')) }}" alt="" class="absolute inset-0 h-full w-full object-cover object-[right_center]" fetchpriority="high">
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-[#1c1c1c] via-[#1c1c1c]/70 to-[#1c1c1c]/10"></div>
        <div class="container-x relative py-20 md:py-24">
            <div class="max-w-2xl">
                @if(setting('hero_eyebrow'))<p class="mb-5 flex items-center gap-3 text-xs font-semibold tracking-[0.25em] text-gold uppercase"><span class="h-px w-8 bg-gold"></span>{{ setting('hero_eyebrow') }}</p>@endif
                <h1 class="text-5xl leading-[1.05] text-white md:text-6xl lg:text-7xl">{!! emphasize(setting('hero_title', 'Hukuki Gücünüz, *Güvenilir Ortağınız*')) !!}</h1>
                @if(setting('hero_subtitle'))<p class="mt-7 max-w-xl text-lg leading-8 text-white/85">{{ setting('hero_subtitle') }}</p>@endif
                <div class="mt-9 flex flex-wrap gap-3">
                    @if(setting('hero_button_text'))<a href="{{ setting('hero_button_url', route('contact.show')) }}" class="btn-primary !px-7 !py-3.5 !text-base">{{ setting('hero_button_text') }} <x-icon name="arrow-right" class="h-4 w-4" /></a>@endif
                    @if(setting('hero_button2_text'))<a href="{{ setting('hero_button2_url', route('services.index')) }}" class="btn-outline-light !px-7 !py-3.5 !text-base">{{ setting('hero_button2_text') }} <x-icon name="arrow-right" class="h-4 w-4" /></a>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- Koyu özellik bandı --}}
    <section class="bg-[#1c1c1c] text-white">
        <div class="container-x grid grid-cols-2 divide-white/10 lg:grid-cols-5 lg:divide-x">
            @foreach([
                ['users', 'Bireysel ve Kurumsal', 'Danışmanlık'],
                ['shield', 'Güvenilir', 'Hukuki Destek'],
                ['document', 'Deneyimli', 'Avukat Kadrosu'],
                ['scale', 'Sonuç Odaklı', 'Çözümler'],
            ] as [$icon, $line1, $line2])
                <div class="flex items-center gap-4 py-6 pr-4 lg:px-6 lg:first:pl-0">
                    <span class="shrink-0 text-white"><x-icon :name="$icon" class="h-9 w-9" /></span>
                    <span class="text-sm leading-5 text-white/90"><span class="block">{{ $line1 }}</span><span class="block">{{ $line2 }}</span></span>
                </div>
            @endforeach
            @if(setting('phone'))
                <a href="{{ phone_href(setting('phone')) }}" class="col-span-2 flex items-center gap-4 border-t border-white/10 py-6 lg:col-span-1 lg:justify-end lg:border-t-0 lg:pl-6">
                    <span class="shrink-0 text-white"><x-icon name="phone" class="h-8 w-8" /></span>
                    <span class="leading-tight"><span class="block text-sm text-white/70">Sorularınız mı var?</span><span class="block text-lg font-semibold tracking-wide text-white">{{ setting('phone') }}</span></span>
                </a>
            @endif
        </div>
    </section>

    {{-- Çalışma alanları + randevu paneli --}}
    <section class="overflow-hidden bg-white" id="randevu">
        <div class="container-x grid gap-0 lg:grid-cols-12">
            <div class="py-14 lg:col-span-8 lg:pr-10 xl:col-span-9">
                <x-section-heading eyebrow="Uzmanlık Alanlarımız" title="Hukuki Çözümlerimiz" :actionUrl="route('services.index')" actionLabel="Tüm Alanları Gör" />
                @if($services->isNotEmpty())
                    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($services->take(4) as $service)<x-service-card :service="$service" />@endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500">{{ setting('services_intro') }}</p>
                @endif
            </div>
            <aside class="relative bg-cream py-12 lg:col-span-4 xl:col-span-3">
                <div class="pointer-events-none absolute inset-y-0 left-full hidden w-[50vw] bg-cream lg:block" aria-hidden="true"></div>
                <div class="relative px-0 lg:pl-8">
                    <span class="eyebrow">Randevu Talebi</span>
                    <h2 class="font-display text-3xl font-bold text-ink md:text-[2rem]">Hemen Randevu Alın</h2>
                    <p class="mt-3 mb-6 text-sm leading-6 text-slate-600">Hukuki süreciniz için bizimle iletişime geçin. Sizi en kısa sürede arayalım.</p>
                    <x-appointment-form :services="$services" />
                </div>
            </aside>
        </div>
    </section>

    {{-- İstatistik şeridi + altın tırnaklı alıntı --}}
    @if($stats->isNotEmpty())
        <section class="border-y border-slate-200 bg-white">
            <div class="container-x grid gap-8 py-10 lg:grid-cols-12 lg:items-center">
                <div class="grid grid-cols-2 gap-6 divide-slate-200 sm:grid-cols-4 sm:divide-x lg:col-span-8">
                    @foreach($stats as $i => $stat)
                        <div class="flex items-center gap-4 sm:px-6 sm:first:pl-0">
                            <span class="shrink-0 text-ink"><x-icon :name="['users', 'user', 'document', 'building'][$i % 4]" class="h-9 w-9" /></span>
                            <span><span class="block text-2xl font-bold text-ink md:text-3xl">{{ $stat['value'] }}</span><span class="block text-sm text-slate-500">{{ $stat['label'] }}</span></span>
                        </div>
                    @endforeach
                </div>
                <figure class="flex gap-4 lg:col-span-4 lg:border-l lg:border-slate-200 lg:pl-8">
                    <span class="font-display text-6xl leading-none text-gold" aria-hidden="true">&ldquo;</span>
                    <div>
                        <blockquote class="text-base leading-7 text-ink italic">{{ setting('site_tagline', 'Hukukun üstün olduğu bir toplum, her zaman daha güçlüdür.') }}&rdquo;</blockquote>
                        <figcaption class="mt-2 text-sm text-slate-600 italic">{{ setting('site_name') }}</figcaption>
                    </div>
                </figure>
            </div>
        </section>
    @endif

    {{-- Hakkımızda --}}
    @if(setting('about_text'))
        <section class="section bg-parchment">
            <div class="container-x grid items-center gap-14 lg:grid-cols-12">
                <div class="lg:col-span-6">
                    <span class="eyebrow">Büromuz</span>
                    <h2 class="section-title">{!! emphasize(setting('about_title', 'Hakkımızda')) !!}</h2>
                    <span class="rule-accent mb-6"></span>
                    <div class="space-y-5 text-base leading-8 text-slate-600 md:text-lg">
                        @foreach(preg_split('/\r\n|\r|\n/', setting('about_text')) as $paragraph)@if(trim($paragraph) !== '')<p>{{ $paragraph }}</p>@endif @endforeach
                    </div>
                    <a href="{{ route('page.show', 'hakkimizda') }}" class="btn-brand mt-8">Büromuzu Tanıyın <x-icon name="arrow-right" class="h-4 w-4 text-gold" /></a>
                </div>
                <div class="lg:col-span-6">
                    @if(setting('about_image'))
                        <img src="{{ upload_url(setting('about_image')) }}" alt="{{ setting('about_title', 'Hakkımızda') }}" class="aspect-[4/3] w-full rounded-lg object-cover shadow-xl" loading="lazy">
                    @else
                        <div class="rounded-lg bg-ink p-8 text-white md:p-10">
                            <span class="eyebrow">Neden biz</span>
                            <ul class="mt-4 space-y-6">
                                @foreach([
                                    ['Sorumlu avukat ilkesi', 'Her dosyayı, sizinle doğrudan iletişim kuran bir avukat baştan sona takip eder.', 'user'],
                                    ['Öngörülebilir süreç', 'Olası yollar, süreler ve maliyetler ilk görüşmede yazılı olarak paylaşılır.', 'document'],
                                    ['Uyuşmazlık öncesi koruma', 'Sözleşme ve uyum danışmanlığıyla dava gerektirmeyen çözümleri önceleriz.', 'shield'],
                                ] as [$title, $text, $icon])
                                    <li class="flex gap-4">
                                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gold/50 text-gold"><x-icon :name="$icon" class="h-5 w-5" /></span>
                                        <span><span class="block font-display text-2xl font-semibold leading-tight">{{ $title }}</span><span class="mt-1.5 block text-sm leading-6 text-white/70">{{ $text }}</span></span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Avukatlarımız --}}
    @if($team->isNotEmpty())
        <section class="section">
            <div class="container-x">
                <x-section-heading eyebrow="Avukatlarımız" :title="setting('team_home_title', 'Ekibimiz')" :actionUrl="route('team.index')" actionLabel="Tüm Ekibi Gör" />
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($team as $member)<x-team-card :member="$member" />@endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Süreç adımları --}}
    <section class="section bg-cream">
        <div class="container-x">
            <x-section-heading eyebrow="Nasıl çalışıyoruz" title="Dört adımda *süreç*" subtitle="İlk temastan dosyanın kapanışına kadar izlediğimiz, sizi her aşamada bilgilendiren çalışma düzeni." />
            <ol class="grid gap-6 md:grid-cols-4">
                @foreach([
                    ['İletişim', 'Formu doldurun ya da arayın; talebiniz uygun çalışma alanına yönlendirilir.', 'phone'],
                    ['Ön görüşme', 'Meselenizi dinler, olası yolları ve maliyet çerçevesini paylaşırız.', 'calendar'],
                    ['Strateji', 'Vekalet sonrası yazılı yol haritası, süre planı ve görev dağılımı belirlenir.', 'layers'],
                    ['Takip', 'Her gelişme size iletilir; dosyanız sorumlu avukatınızca kapanışa kadar izlenir.', 'check-circle'],
                ] as $i => [$title, $text, $icon])
                    <li class="card p-6">
                        <div class="flex items-center justify-between">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-ink text-gold"><x-icon :name="$icon" class="h-5 w-5" /></span>
                            <span class="font-display text-3xl font-semibold text-gold/60">0{{ $i + 1 }}</span>
                        </div>
                        <h3 class="mt-5 font-sans text-lg font-semibold text-ink">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Müvekkil yorumları --}}
    @if($testimonials->isNotEmpty())
        <section class="section">
            <div class="container-x">
                <x-section-heading eyebrow="Müvekkillerimiz" title="Müvekkil *görüşleri*" subtitle="Gizlilik ilkemiz gereği müvekkil adları kısaltılarak yayımlanmıştır." />
                <div class="grid gap-6 md:grid-cols-3">@foreach($testimonials as $testimonial)<x-testimonial-card :testimonial="$testimonial" />@endforeach</div>
            </div>
        </section>
    @endif

    {{-- Makaleler --}}
    @if($posts->isNotEmpty())
        <section class="section bg-parchment">
            <div class="container-x">
                <x-section-heading eyebrow="Yayınlar" :title="setting('blog_label', 'Makaleler')" :subtitle="setting('blog_intro')" :actionUrl="route('blog.index')" actionLabel="Tüm Makaleleri Gör" />
                <div class="border-t border-slate-200">@foreach($posts as $post)<x-post-card :post="$post" />@endforeach</div>
            </div>
        </section>
    @endif

    {{-- Kaynaklar + SSS --}}
    @if($publications->isNotEmpty() || $faqs->isNotEmpty())
        <section class="section">
            <div class="container-x grid gap-16 lg:grid-cols-12">
                @if($faqs->isNotEmpty())
                    <div class="lg:col-span-7">
                        <span class="eyebrow">Merak edilenler</span>
                        <h2 class="section-title !text-4xl">{!! emphasize('Sık Sorulan *Sorular*') !!}</h2>
                        <span class="rule-accent"></span>
                        <div class="mt-8"><x-faq-list :faqs="$faqs" /></div>
                    </div>
                @endif
                @if($publications->isNotEmpty())
                    <div class="lg:col-span-5">
                        <span class="eyebrow">Kütüphane</span>
                        <h2 class="section-title !text-4xl">{!! emphasize(setting('publications_label', 'Kaynaklar')) !!}</h2>
                        <span class="rule-accent"></span>
                        <div class="mt-8 grid gap-4">@foreach($publications as $publication)<x-publication-card :publication="$publication" />@endforeach</div>
                        <a href="{{ route('publications.index') }}" class="link-all mt-8">Tüm Kaynakları Gör <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Üyelik / kurum logoları --}}
    @if($partners->isNotEmpty())
        <section class="border-t border-slate-200 bg-white py-14">
            <div class="container-x">
                <p class="mb-8 text-center text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">Üye olduğumuz baro, kurum ve meslek birlikleri</p>
                <x-partner-strip :partners="$partners" />
            </div>
        </section>
    @endif

    <x-cta-band />
@endsection
