@extends('template::layouts.app')
@section('seo')<x-seo :title="setting('team_home_title', 'Ekibimiz')" description="Avukat kadromuzla tanışın: uzmanlık alanları, baro kayıtları ve eğitim bilgileri." />@endsection
@section('content')
    <x-page-header eyebrow="Avukatlarımız" :title="setting('team_home_title', 'Ekibimiz')" subtitle="Her dosyada sorumlu bir avukat; ihtiyaç halinde ilgili alandaki ortağımızın desteğiyle." :breadcrumbs="[['label' => setting('team_home_title', 'Ekibimiz')]]" />
    <section class="section">
        <div class="container-x">
            @if($members->isEmpty())
                <x-empty-state icon="users" title="Henüz ekip üyesi eklenmedi" />
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">@foreach($members as $member)<x-team-card :member="$member" />@endforeach</div>
            @endif
        </div>
    </section>
    <x-cta-band />
@endsection
