@extends('template::layouts.app')
@section('seo')<x-seo :title="setting('services_label', 'Çalışma Alanları')" :description="setting('services_intro')" />@endsection
@section('content')
    <x-page-header eyebrow="Uzmanlık Alanlarımız" :title="setting('services_label', 'Çalışma Alanları')" :subtitle="setting('services_intro')" :breadcrumbs="[['label' => setting('services_label', 'Çalışma Alanları')]]" />
    <section class="section">
        <div class="container-x">
            @if($services->isEmpty())
                <x-empty-state icon="briefcase" title="Henüz çalışma alanı eklenmedi" />
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@foreach($services as $service)<x-service-card :service="$service" />@endforeach</div>
                <div class="mt-10">{{ $services->links() }}</div>
            @endif
        </div>
    </section>
    <x-cta-band />
@endsection
