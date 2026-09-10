@extends('template::layouts.app')
@section('seo')<x-seo title="İletişim" :description="'Bize ulaşın: '.setting('phone').' - '.setting('email')" />@endsection
@section('content')
    <x-page-header eyebrow="Bize ulaşın" title="İletişim" subtitle="Genel sorularınız için formu kullanabilirsiniz. Hukuki değerlendirme talepleri için ön görüşme formunu tercih edin." :breadcrumbs="[['label' => 'İletişim']]" />
    <section class="section">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="space-y-6 lg:col-span-5">
                <dl class="divide-y divide-slate-200 border-y border-slate-200">
                    @foreach([['map-pin', 'Adres', setting('address'), null], ['phone', 'Telefon', setting('phone'), phone_href(setting('phone'))], ['mail', 'E-posta', setting('email'), 'mailto:'.setting('email')], ['clock', 'Çalışma Saatleri', setting('working_hours'), null]] as [$icon, $label, $value, $href])
                        @if($value)
                            <div class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"><x-icon :name="$icon" class="h-4 w-4" /></span><div><dt class="text-xs font-semibold tracking-[0.15em] text-slate-500 uppercase">{{ $label }}</dt>@if($href)<dd><a href="{{ $href }}" class="mt-1 block text-slate-800 hover:text-primary">{{ $value }}</a></dd>@else<dd class="mt-1 text-slate-800">{{ $value }}</dd>@endif @if($label === 'Çalışma Saatleri' && setting('office_hours_note'))<dd class="mt-1 text-xs text-slate-500">{{ setting('office_hours_note') }}</dd>@endif</div></div>
                        @endif
                    @endforeach
                </dl>
                <div class="rounded-lg bg-primary p-7 text-primary-contrast">
                    <span class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Hukuki değerlendirme</span>
                    <h2 class="mt-2 font-display text-2xl font-semibold">{{ setting('consultation_label', 'Ön Görüşme') }} talep edin</h2>
                    <p class="mt-2 text-sm text-primary-contrast/75">Meselenizi kısaca anlatın; uygun avukatımız sizinle iletişime geçsin.</p>
                    <a href="{{ route('consultations.create') }}" class="btn-light mt-5">Forma Git <x-icon name="arrow-right" class="h-4 w-4" /></a>
                </div>
            </div>
            <div class="lg:col-span-7">
                <div class="rounded-lg border border-slate-200 p-6 shadow-sm md:p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Bize Yazın</h2>
                    <p class="mt-1 mb-6 text-sm text-slate-500">Mesajınız ilgili birime iletilir; en kısa sürede dönüş yapılır.</p>
                    @if(session('success'))<x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>@endif
                    <x-contact-form />
                </div>
            </div>
        </div>
    </section>
    @if(setting('map_embed'))<section class="h-96 w-full border-t border-slate-200"><iframe src="{{ setting('map_embed') }}" class="h-full w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="Harita"></iframe></section>@endif
@endsection
