@props(['services'])
{{-- Ana sayfa hızlı randevu formu: ön görüşme POST rotasına gider; mesaj alanı yerine "quick" işareti taşır --}}
<form method="post" action="{{ route('consultations.store') }}" class="space-y-3">
    @csrf
    <input type="hidden" name="quick" value="1">
    <input type="hidden" name="preferred_contact" value="phone">
    <div class="hidden" aria-hidden="true"><label>Web sitesi <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

    @if(session('success') && session('quick'))<x-alert type="success">{{ session('success') }}</x-alert>@endif
    @if($errors->any() && old('quick'))<x-alert type="error">Lütfen formdaki alanları kontrol edin.</x-alert>@endif

    <div class="relative">
        <label for="quick-name" class="sr-only">Ad Soyad</label>
        <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-slate-400"><x-icon name="user" class="h-4 w-4" /></span>
        <input id="quick-name" name="name" type="text" value="{{ old('quick') ? old('name') : '' }}" required maxlength="120" placeholder="Ad Soyad" class="form-input !pl-10" autocomplete="name">
        @if(old('quick'))@error('name')<p class="form-error">{{ $message }}</p>@enderror @endif
    </div>
    <div class="relative">
        <label for="quick-phone" class="sr-only">Telefon</label>
        <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-slate-400"><x-icon name="phone" class="h-4 w-4" /></span>
        <input id="quick-phone" name="phone" type="tel" value="{{ old('quick') ? old('phone') : '' }}" required maxlength="40" placeholder="Telefon" class="form-input !pl-10" autocomplete="tel">
        @if(old('quick'))@error('phone')<p class="form-error">{{ $message }}</p>@enderror @endif
    </div>
    <div class="relative">
        <label for="quick-email" class="sr-only">E-posta</label>
        <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-slate-400"><x-icon name="mail" class="h-4 w-4" /></span>
        <input id="quick-email" name="email" type="email" value="{{ old('quick') ? old('email') : '' }}" required maxlength="190" placeholder="E-posta" class="form-input !pl-10" autocomplete="email">
        @if(old('quick'))@error('email')<p class="form-error">{{ $message }}</p>@enderror @endif
    </div>
    <div class="relative">
        <label for="quick-service" class="sr-only">Hizmet Türü</label>
        <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-slate-400"><x-icon name="briefcase" class="h-4 w-4" /></span>
        <select id="quick-service" name="service_id" class="form-input !pl-10 text-slate-700">
            <option value="">Hizmet Türü Seçin</option>
            @foreach($services as $service)<option value="{{ $service->id }}" @selected(old('quick') && (string) old('service_id') === (string) $service->id)>{{ $service->title }}</option>@endforeach
        </select>
        @if(old('quick'))@error('service_id')<p class="form-error">{{ $message }}</p>@enderror @endif
    </div>
    <div>
        <label class="flex items-start gap-2.5 text-xs leading-5 text-slate-600">
            <input type="checkbox" name="kvkk" value="1" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-gold focus:ring-gold" @checked(old('quick') && old('kvkk'))>
            <span><a href="{{ route('page.show', 'kvkk') }}" target="_blank" class="font-medium text-ink underline">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin randevu amacıyla işlenmesini kabul ediyorum.</span>
        </label>
        @if(old('quick'))@error('kvkk')<p class="form-error">{{ $message }}</p>@enderror @endif
    </div>
    <button type="submit" class="btn-primary w-full !py-3.5">Randevu Talebi Gönder <x-icon name="arrow-right" class="h-4 w-4" /></button>
</form>
