@extends('template::layouts.app')
@section('seo')<x-seo :title="$member->name" :description="$member->excerpt ?: $member->title" :image="$member->image" type="profile" />@endsection
@section('content')
    <x-page-header :eyebrow="$member->title" :title="$member->name" :subtitle="$member->excerpt" :breadcrumbs="[['label' => setting('team_home_title', 'Ekibimiz'), 'url' => route('team.index')], ['label' => $member->name]]" />
    <section class="section">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <aside class="lg:col-span-4">
                <div class="overflow-hidden rounded-lg border border-slate-200">
                    <div class="aspect-[4/5] bg-parchment">@if($member->image)<img src="{{ upload_url($member->image) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">@else<div class="flex h-full items-center justify-center text-primary/20"><x-icon name="user" class="h-24 w-24" /></div>@endif</div>
                    <dl class="divide-y divide-slate-100 p-6 text-sm">
                        @foreach($member->attributes_list() as $attribute)<div class="py-3 first:pt-0"><dt class="text-xs font-semibold tracking-[0.15em] text-slate-500 uppercase">{{ $attribute['label'] }}</dt><dd class="mt-1 text-slate-800">{{ $attribute['value'] }}</dd></div>@endforeach
                        @if($member->phone)<div class="py-3"><dt class="text-xs font-semibold tracking-[0.15em] text-slate-500 uppercase">Telefon</dt><dd class="mt-1"><a href="{{ phone_href($member->phone) }}" class="text-slate-800 hover:text-primary">{{ $member->phone }}</a></dd></div>@endif
                        @if($member->email)<div class="py-3"><dt class="text-xs font-semibold tracking-[0.15em] text-slate-500 uppercase">E-posta</dt><dd class="mt-1"><a href="mailto:{{ $member->email }}" class="text-slate-800 hover:text-primary">{{ $member->email }}</a></dd></div>@endif
                    </dl>
                    @if(collect(['linkedin', 'twitter', 'instagram'])->contains(fn ($n) => $member->social($n)))
                        <div class="flex gap-2 border-t border-slate-100 px-6 py-4">@foreach(['linkedin', 'twitter', 'instagram'] as $network)@if($member->social($network))<a href="{{ $member->social($network) }}" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 hover:border-primary hover:text-primary" aria-label="{{ $network }}"><x-icon :name="$network" class="h-4 w-4" /></a>@endif @endforeach</div>
                    @endif
                </div>
            </aside>
            <div class="lg:col-span-8">
                <div class="prose-cms">{!! $member->bio !!}</div>
                <div class="mt-10 flex flex-wrap gap-3">
                    <a href="{{ route('consultations.create', ['avukat' => $member->id]) }}" class="btn-primary">Ön Görüşme Talep Edin <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    <a href="{{ route('contact.show') }}" class="btn-outline">İletişim</a>
                </div>
            </div>
        </div>
    </section>
    @if($others->isNotEmpty())
        <section class="section border-t border-slate-200 bg-parchment !pt-16"><div class="container-x"><h2 class="section-title mb-8 !text-3xl">Diğer Avukatlarımız</h2><div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">@foreach($others as $other)<x-team-card :member="$other" />@endforeach</div></div></section>
    @endif
@endsection
