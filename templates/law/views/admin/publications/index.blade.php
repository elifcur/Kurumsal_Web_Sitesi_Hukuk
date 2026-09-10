@extends('layouts.admin')
@section('title', 'Kaynaklar')
@section('content')
    <x-admin.page-header title="Kaynaklar" subtitle="Rehber, form, makale ve bültenler: PDF dosyası ya da dış bağlantı.">
        <x-slot:actions><a href="{{ route('admin.publications.create') }}" class="btn-primary"><x-icon name="plus" class="h-4 w-4" /> Yeni Kaynak</a></x-slot:actions>
    </x-admin.page-header>
    <div class="card">
        <div class="card-header">
            <x-admin.search placeholder="Kaynak ara...">
                <select name="type" class="form-input !w-36"><option value="">Tüm türler</option>@foreach(\Templates\Law\Models\Publication::TYPES as $k => $l)<option value="{{ $k }}" @selected(request('type') === $k)>{{ $l }}</option>@endforeach</select>
                <select name="status" class="form-input !w-36"><option value="">Tüm durumlar</option><option value="active" @selected(request('status') === 'active')>Aktif</option><option value="inactive" @selected(request('status') === 'inactive')>Pasif</option></select>
            </x-admin.search>
        </div>
        @if($publications->isEmpty())
            <x-admin.empty title="Kaynak bulunamadı" icon="document" />
        @else
            <div class="overflow-x-auto"><table class="table">
                <thead><tr><th>Kaynak</th><th>Tür</th><th>Dosya / Bağlantı</th><th>Yayın Tarihi</th><th>Sıra</th><th>Durum</th><th class="text-right">İşlem</th></tr></thead>
                <tbody>
                @foreach($publications as $publication)
                    <tr>
                        <td><a href="{{ route('admin.publications.edit', $publication) }}" class="font-medium text-slate-900 hover:text-primary">{{ $publication->title }}</a>@if($publication->summary)<span class="block max-w-md truncate text-xs text-slate-500">{{ $publication->summary }}</span>@endif</td>
                        <td><span class="badge-blue">{{ $publication->typeLabel() }}</span></td>
                        <td class="text-xs text-slate-600">@if($publication->file)<span class="inline-flex items-center gap-1"><x-icon name="document" class="h-3.5 w-3.5" /> {{ basename($publication->file) }}</span>@elseif($publication->external_url)<span class="inline-flex items-center gap-1"><x-icon name="external" class="h-3.5 w-3.5" /> {{ \Illuminate\Support\Str::limit($publication->external_url, 40) }}</span>@else—@endif</td>
                        <td class="whitespace-nowrap text-slate-600">{{ $publication->published_at?->format('d.m.Y') ?? '—' }}</td>
                        <td class="text-slate-600">{{ $publication->sort_order }}</td>
                        <td><x-admin.status-badge :active="$publication->is_active" /></td>
                        <td class="text-right whitespace-nowrap">
                            @if($publication->url())<a href="{{ $publication->url() }}" target="_blank" class="btn-ghost btn-sm"><x-icon name="external" class="h-4 w-4" /></a>@endif
                            <a href="{{ route('admin.publications.edit', $publication) }}" class="btn-ghost btn-sm"><x-icon name="pencil" class="h-4 w-4" /></a>
                            <x-admin.delete-button :action="route('admin.publications.destroy', $publication)" />
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
            <div class="px-5 py-4">{{ $publications->links() }}</div>
        @endif
    </div>
@endsection
