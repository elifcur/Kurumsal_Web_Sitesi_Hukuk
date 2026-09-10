@extends('template::layouts.app')
@section('content')
    @php($heading = $currentCategory?->name ?? ($currentTag ? '#'.$currentTag->name : $title))
    @section('seo')<x-seo :title="$heading" :description="$currentCategory?->description ?: setting('blog_intro')" :robots="request()->hasAny(['q', 'page', 'etiket']) ? 'noindex, follow' : 'index, follow'" />@endsection
    <x-page-header eyebrow="Yayınlar" :title="$heading" :subtitle="setting('blog_intro', 'Güncel mevzuat, içtihat ve uygulamaya dair bilgilendirici yazılar.')" :breadcrumbs="array_values(array_filter([['label' => $title, 'url' => route('blog.index')], $currentCategory ? ['label' => $currentCategory->name] : null, $currentTag ? ['label' => $currentTag->name] : null]))" />
    <section class="section">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                @if($posts->isEmpty())
                    <x-empty-state icon="newspaper" title="Yazı bulunamadı" />
                @else
                    <div class="border-t border-slate-200">@foreach($posts as $post)<x-post-card :post="$post" />@endforeach</div>
                    <div class="mt-10">{{ $posts->links() }}</div>
                @endif
            </div>
            <aside class="space-y-8 lg:col-span-4">
                <form method="get" action="{{ route('blog.index') }}" class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Makalelerde ara..." class="form-input !pr-10">
                    <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-slate-400 hover:text-primary" aria-label="Ara"><x-icon name="search" /></button>
                </form>
                @if($categories->isNotEmpty())
                    <div>
                        <h3 class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Kategoriler</h3>
                        <ul class="mt-4 divide-y divide-slate-200 border-y border-slate-200 text-sm">
                            @foreach($categories as $category)
                                <li><a href="{{ route('blog.index', ['kategori' => $category->slug]) }}" @class(['flex justify-between py-3', 'text-primary font-semibold' => $currentCategory?->id === $category->id, 'text-slate-700 hover:text-primary' => $currentCategory?->id !== $category->id])><span>{{ $category->name }}</span><span class="text-xs text-slate-400">{{ $category->posts_count }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="rounded-lg border border-gold/40 bg-gold-light p-6">
                    <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Not</p>
                    <p class="mt-2 text-sm leading-6 text-slate-700">Makaleler genel bilgilendirme amaçlıdır; somut olayınız için <a href="{{ route('consultations.create') }}" class="font-medium text-primary underline">ön görüşme</a> talep edebilirsiniz.</p>
                </div>
            </aside>
        </div>
    </section>
@endsection
