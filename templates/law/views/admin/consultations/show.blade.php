@extends('layouts.admin')
@section('title', 'Ön Görüşme Talebi')
@section('content')
    <x-admin.page-header :title="$consultation->subject ?: 'Talep #'.$consultation->id" :subtitle="$consultation->name.' · '.$consultation->created_at->format('d.m.Y H:i')">
        <x-slot:actions>
            <a href="{{ route('admin.consultations.index') }}" class="btn-ghost"><x-icon name="arrow-left" class="h-4 w-4" /> Listeye Dön</a>
            <x-admin.delete-button :action="route('admin.consultations.destroy', $consultation)" label="Sil" class="btn-danger" />
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="card">
                <div class="card-header"><h2 class="font-semibold text-slate-900">Mesele</h2><span class="{{ $consultation->statusBadgeClass() }}">{{ $consultation->statusLabel() }}</span></div>
                <div class="card-body">
                    <div class="prose-sm whitespace-pre-line text-slate-800">{{ $consultation->message }}</div>
                    <dl class="mt-6 divide-y divide-slate-100 rounded-lg border border-slate-200 text-sm">
                        @foreach([['Çalışma Alanı', $consultation->service?->title], ['Tercih Edilen Avukat', $consultation->teamMember?->name], ['İletişim Tercihi', $consultation->contactMethodLabel()], ['Tercih Edilen Tarih', $consultation->preferred_date?->format('d.m.Y')]] as [$label, $value])
                            <div class="flex gap-4 px-4 py-2"><dt class="w-44 shrink-0 text-slate-500">{{ $label }}</dt><dd class="text-slate-900">{{ $value ?: '—' }}</dd></div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <form method="post" action="{{ route('admin.consultations.update', $consultation) }}" class="card">
                @csrf @method('PUT')
                <div class="card-header"><h2 class="font-semibold text-slate-900">Takip</h2></div>
                <div class="card-body space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.select name="status" label="Durum" :options="\Templates\Law\Models\Consultation::STATUSES" :value="$consultation->status" required />
                        <x-admin.select name="team_member_id" label="Sorumlu Avukat" :options="$lawyers" :value="$consultation->team_member_id" placeholder="Atanmadı" />
                    </div>
                    <x-admin.textarea name="notes" label="Dahili Notlar" :value="$consultation->notes" rows="4" help="Yalnızca yönetim panelinde görünür (randevu saati, görüşme özeti...)." />
                </div>
                <div class="flex justify-end border-t border-slate-100 px-5 py-4"><button type="submit" class="btn-primary"><x-icon name="check" class="h-4 w-4" /> Kaydet</button></div>
            </form>
        </div>
        <div class="card self-start">
            <div class="card-header"><h2 class="font-semibold text-slate-900">Talep Eden</h2></div>
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="px-5 py-3"><dt class="text-xs text-slate-500">Ad</dt><dd class="font-medium text-slate-900">{{ $consultation->name }}</dd></div>
                <div class="px-5 py-3"><dt class="text-xs text-slate-500">E-posta</dt><dd><a href="mailto:{{ $consultation->email }}?subject={{ rawurlencode('Re: Ön görüşme talebiniz') }}" class="font-medium text-primary hover:underline">{{ $consultation->email }}</a></dd></div>
                <div class="px-5 py-3"><dt class="text-xs text-slate-500">Telefon</dt><dd><a href="{{ phone_href($consultation->phone) }}" class="font-medium text-primary hover:underline">{{ $consultation->phone }}</a></dd></div>
                <div class="px-5 py-3"><dt class="text-xs text-slate-500">IP</dt><dd class="text-slate-700">{{ $consultation->ip ?? '—' }}</dd></div>
                <div class="px-5 py-3"><dt class="text-xs text-slate-500">Son Güncelleme</dt><dd class="text-slate-700">{{ $consultation->updated_at->format('d.m.Y H:i') }}</dd></div>
            </dl>
            <div class="space-y-2 border-t border-slate-100 p-5">
                <a href="mailto:{{ $consultation->email }}?subject={{ rawurlencode('Re: Ön görüşme talebiniz') }}" class="btn-primary w-full"><x-icon name="mail" class="h-4 w-4" /> E-posta ile Yanıtla</a>
                <a href="{{ phone_href($consultation->phone) }}" class="btn-secondary w-full"><x-icon name="phone" class="h-4 w-4" /> Ara</a>
            </div>
        </div>
    </div>
@endsection
