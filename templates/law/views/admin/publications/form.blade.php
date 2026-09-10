@extends('layouts.admin')
@section('title', $publication->exists ? 'Kaynak Düzenle' : 'Yeni Kaynak')
@section('content')
    <x-admin.page-header :title="$publication->exists ? 'Kaynak Düzenle' : 'Yeni Kaynak'" :subtitle="$publication->exists ? $publication->title : null" />
    <form method="post" action="{{ $publication->exists ? route('admin.publications.update', $publication) : route('admin.publications.store') }}" x-data="slugField(@js(old('slug', $publication->slug ?? '')), {{ $publication->exists ? 'true' : 'false' }})">
        @csrf
        @if($publication->exists)@method('PUT')@endif
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="card"><div class="card-body space-y-4">
                    <x-admin.input name="title" label="Başlık" :value="$publication->title" required x-on:input="update($event.target.value)" />
                    <x-admin.slug :value="$publication->slug" :prefix="url('/kaynaklar').'#'" />
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.select name="type" label="Tür" :options="\Templates\Law\Models\Publication::TYPES" :value="$publication->type" required />
                        <x-admin.input name="published_at" label="Yayın Tarihi" type="date" :value="$publication->published_at?->toDateString()" />
                    </div>
                    <x-admin.textarea name="summary" label="Özet" :value="$publication->summary" rows="3" maxlength="1000" help="Kartlarda görünen kısa açıklama." />
                </div></div>
                <div class="card">
                    <div class="card-header"><h2 class="font-semibold text-slate-900">Dosya veya Bağlantı</h2></div>
                    <div class="card-body space-y-4">
                        @php($currentFile = old('file', $publication->file))
                        <x-admin.field-wrapper name="file" label="PDF Dosyası" help="Medya kütüphanesinden PDF seçin. Dosya seçilirse dış bağlantı yok sayılır.">
                            <div x-data="{ path: @js($currentFile ?? ''), pick() { window.dispatchEvent(new CustomEvent('open-media-picker', { detail: { onSelect: (media) => { this.path = media.path; } } })); } }" class="flex flex-wrap items-center gap-3">
                                <input type="hidden" name="file" id="file" :value="path">
                                <span class="inline-flex min-h-10 min-w-48 items-center gap-2 rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600"><x-icon name="document" class="h-4 w-4 text-slate-400" /><span x-text="path || 'Dosya seçilmedi'"></span></span>
                                <button type="button" class="btn-secondary btn-sm" @click="pick()"><x-icon name="upload" class="h-4 w-4" /> Dosya Seç</button>
                                <button type="button" class="btn-ghost btn-sm text-red-600" x-show="path" x-cloak @click="path = ''"><x-icon name="x" class="h-4 w-4" /> Kaldır</button>
                            </div>
                        </x-admin.field-wrapper>
                        <x-admin.input name="external_url" label="Dış Bağlantı" type="url" :value="$publication->external_url" placeholder="https://..." help="PDF yerine bir web adresine yönlendirmek için." />
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="card"><div class="card-body space-y-4">
                    <x-admin.checkbox name="is_active" label="Aktif (sitede görünür)" :checked="$publication->is_active" />
                    <x-admin.input name="sort_order" label="Sıra" type="number" min="0" :value="$publication->sort_order" help="Küçük sayı önce gösterilir." />
                </div></div>
                <x-admin.form-actions :back="route('admin.publications.index')" />
            </div>
        </div>
    </form>
@endsection
