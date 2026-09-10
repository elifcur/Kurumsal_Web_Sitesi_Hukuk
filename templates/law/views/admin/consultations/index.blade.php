@extends('layouts.admin')
@section('title', 'Ön Görüşme Talepleri')
@section('content')
    <x-admin.page-header title="Ön Görüşme Talepleri" subtitle="Siteden gelen ön görüşme (randevu) talepleri ve takip durumları." />

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.consultations.index') }}" @class(['rounded-lg border px-3 py-1.5 text-sm font-medium', 'border-primary bg-primary text-white' => !request('status'), 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' => request('status')])>Tümü <span class="opacity-70">{{ $counts->sum() }}</span></a>
        @foreach(\Templates\Law\Models\Consultation::STATUSES as $key => $label)
            <a href="{{ route('admin.consultations.index', ['status' => $key]) }}" @class(['rounded-lg border px-3 py-1.5 text-sm font-medium', 'border-primary bg-primary text-white' => request('status') === $key, 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' => request('status') !== $key])>{{ $label }} <span class="opacity-70">{{ $counts[$key] ?? 0 }}</span></a>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">
            <x-admin.search placeholder="Ad, e-posta veya konu...">
                <select name="status" class="form-input !w-44"><option value="">Tüm durumlar</option>@foreach(\Templates\Law\Models\Consultation::STATUSES as $key => $label)<option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>@endforeach</select>
            </x-admin.search>
        </div>
        @if($consultations->isEmpty())
            <x-admin.empty title="Talep bulunamadı" icon="calendar" />
        @else
            <div class="overflow-x-auto"><table class="table">
                <thead><tr><th>Talep Eden</th><th>Konu</th><th>Çalışma Alanı</th><th>Avukat</th><th>Tercih</th><th>Durum</th><th>Tarih</th><th class="text-right">İşlem</th></tr></thead>
                <tbody>
                @foreach($consultations as $consultation)
                    <tr @class(['font-semibold' => $consultation->status === 'new'])>
                        <td><a href="{{ route('admin.consultations.show', $consultation) }}" class="text-slate-900 hover:text-primary">{{ $consultation->name }}</a><span class="block text-xs font-normal text-slate-500">{{ $consultation->email }} · {{ $consultation->phone }}</span></td>
                        <td class="max-w-xs truncate">{{ $consultation->subject ?: \Illuminate\Support\Str::limit($consultation->message, 60) }}</td>
                        <td class="text-slate-600">{{ $consultation->service?->title ?? '—' }}</td>
                        <td class="text-slate-600">{{ $consultation->teamMember?->name ?? '—' }}</td>
                        <td class="text-xs font-normal text-slate-500">{{ $consultation->contactMethodLabel() }}@if($consultation->preferred_date)<span class="block">{{ $consultation->preferred_date->format('d.m.Y') }}</span>@endif</td>
                        <td><span class="{{ $consultation->statusBadgeClass() }}">{{ $consultation->statusLabel() }}</span></td>
                        <td class="whitespace-nowrap text-xs font-normal text-slate-500">{{ $consultation->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-right whitespace-nowrap">
                            <a href="{{ route('admin.consultations.show', $consultation) }}" class="btn-ghost btn-sm"><x-icon name="eye" class="h-4 w-4" /></a>
                            <x-admin.delete-button :action="route('admin.consultations.destroy', $consultation)" />
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
            <div class="px-5 py-4">{{ $consultations->links() }}</div>
        @endif
    </div>
@endsection
