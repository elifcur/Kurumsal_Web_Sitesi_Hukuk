@extends('template::layouts.app')
@section('seo')<x-seo :title="$service->meta_title ?: $service->title" :description="$service->meta_description ?: $service->excerpt" :image="$service->image" />@endsection
@section('content')
    <x-page-header :eyebrow="setting('services_label', 'Çalışma Alanları')" :title="$service->title" :subtitle="$service->excerpt" :image="$service->image" :breadcrumbs="[['label' => setting('services_label', 'Çalışma Alanları'), 'url' => route('services.index')], ['label' => $service->title]]" />
    <section class="section">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                @if($service->image)<img src="{{ upload_url($service->image) }}" alt="{{ $service->title }}" class="mb-10 w-full rounded-lg object-cover">@endif
                <div class="prose-cms">{!! $service->content !!}</div>
            </div>
            <aside class="space-y-8 lg:col-span-4">
                <div class="rounded-lg bg-primary p-7 text-primary-contrast">
                    <span class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Bu alanda destek</span>
                    <h3 class="mt-2 font-display text-2xl font-semibold">Ön görüşme talep edin</h3>
                    <p class="mt-2 text-sm text-primary-contrast/75">Meselenizi kısaca anlatın; bu alandaki avukatımız sizinle iletişime geçsin.</p>
                    <a href="{{ route('consultations.create', ['alan' => $service->id]) }}" class="btn-light mt-5 w-full">Ön Görüşme Talep Edin</a>
                    @if(setting('phone'))<a href="{{ phone_href(setting('phone')) }}" class="mt-3 flex items-center justify-center gap-2 text-sm font-semibold"><x-icon name="phone" class="h-4 w-4 text-gold" /> {{ setting('phone') }}</a>@endif
                </div>
                @if($others->isNotEmpty())
                    <div>
                        <h3 class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Diğer {{ setting('services_label', 'Çalışma Alanları') }}</h3>
                        <ul class="mt-4 divide-y divide-slate-200 border-y border-slate-200">@foreach($others as $other)<li><a href="{{ $other->url() }}" class="group flex items-center justify-between gap-3 py-3 text-sm font-medium text-slate-700 hover:text-primary">{{ $other->title }} <x-icon name="arrow-right" class="h-4 w-4 text-gold transition group-hover:translate-x-1" /></a></li>@endforeach</ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection
