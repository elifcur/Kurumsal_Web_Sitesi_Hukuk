@extends('template::layouts.app')
@section('seo')<x-seo :title="setting('consultation_label', 'Ön Görüşme').' Talebi'" :description="setting('consultation_intro')" />@endsection
@section('content')
    <x-page-header eyebrow="Randevu" :title="setting('consultation_label', 'Ön Görüşme').' Talebi'" :subtitle="setting('consultation_intro')" :breadcrumbs="[['label' => setting('consultation_label', 'Ön Görüşme')]]" />
    <section class="section">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm md:p-10">
                    @if(session('success'))
                        <x-alert type="success" class="mb-8">{{ session('success') }}</x-alert>
                    @endif
                    <x-consultation-form :services="$services" :lawyers="$lawyers" />
                </div>
            </div>
            <aside class="space-y-8 lg:col-span-4">
                <div>
                    <h2 class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Sonraki adımlar</h2>
                    <ol class="mt-5 space-y-5">
                        @foreach([['Talebiniz incelenir', 'Meseleniz uygun çalışma alanına ve avukata yönlendirilir.'], ['Sizinle iletişime geçilir', 'Tercih ettiğiniz yöntemle 1 iş günü içinde dönüş yapılır.'], ['Ön görüşme yapılır', 'Ofiste ya da çevrim içi; olası yollar ve maliyet çerçevesi paylaşılır.']] as $i => [$title, $text])
                            <li class="flex gap-4"><span class="numeral !text-2xl">{{ ['I', 'II', 'III'][$i] }}</span><span><span class="block font-display text-xl font-semibold text-ink">{{ $title }}</span><span class="mt-1 block text-sm leading-6 text-slate-600">{{ $text }}</span></span></li>
                        @endforeach
                    </ol>
                </div>
                <div class="rounded-lg bg-cream p-6">
                    <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Bilgilendirme</p>
                    <p class="mt-2 text-sm leading-6 text-slate-700">Ön görüşme talebi göndermek vekalet ilişkisi kurmaz. Acil durumlarda lütfen doğrudan arayın.</p>
                    @if(setting('phone'))<a href="{{ phone_href(setting('phone')) }}" class="mt-4 flex items-center gap-2 text-sm font-semibold text-ink"><x-icon name="phone" class="h-4 w-4 text-gold" /> {{ setting('phone') }}</a>@endif
                    @if(setting('office_hours_note'))<p class="mt-2 text-xs text-slate-500">{{ setting('office_hours_note') }}</p>@endif
                </div>
            </aside>
        </div>
    </section>
@endsection
