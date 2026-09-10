@extends('template::layouts.app')
@section('seo')<x-seo :title="$post->meta_title ?: $post->title" :description="$post->meta_description ?: $post->excerpt" :image="$post->image" type="article" />@endsection
@section('content')
    <x-page-header :eyebrow="$post->category?->name" :title="$post->title" :subtitle="$post->excerpt" :breadcrumbs="[['label' => setting('blog_label', 'Makaleler'), 'url' => route('blog.index')], ['label' => \Illuminate\Support\Str::limit($post->title, 50)]]" />
    <section class="section">
        <div class="container-x max-w-3xl">
            <div class="mb-10 flex flex-wrap items-center gap-4 border-b border-slate-200 pb-6 text-xs tracking-wide text-slate-500 uppercase">
                @if($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>@endif
                @if($post->author)<span>{{ $post->author->name }}</span>@endif
                @if($post->category)<a href="{{ route('blog.index', ['kategori' => $post->category->slug]) }}" class="text-gold hover:underline">{{ $post->category->name }}</a>@endif
            </div>
            @if($post->image)<img src="{{ upload_url($post->image) }}" alt="{{ $post->title }}" class="mb-10 w-full rounded-lg object-cover">@endif
            <div class="prose-cms">{!! $post->content !!}</div>
            @if($post->tags->isNotEmpty())
                <div class="mt-10 flex flex-wrap gap-2">@foreach($post->tags as $tag)<a href="{{ route('blog.index', ['etiket' => $tag->slug]) }}" class="chip hover:border-primary hover:text-primary">#{{ $tag->name }}</a>@endforeach</div>
            @endif
            <p class="mt-12 border-l-2 border-gold pl-5 text-xs leading-6 text-slate-500">Bu makale genel bilgilendirme amaçlıdır; hukuki tavsiye niteliği taşımaz. Somut olayınız için bir avukata danışınız.</p>
        </div>
    </section>
    @if($related->isNotEmpty())
        <section class="section border-t border-slate-200 bg-parchment !pt-16"><div class="container-x"><h2 class="section-title mb-8 !text-3xl">İlgili Makaleler</h2><div class="grid gap-6 md:grid-cols-3">@foreach($related as $item)<x-post-card :post="$item" layout="card" />@endforeach</div></div></section>
    @endif
@endsection
