@props(['services', 'lawyers'])
<form method="post" action="{{ route('consultations.store') }}" class="space-y-6">
    @csrf
    <div class="hidden" aria-hidden="true"><label>Web sitesi <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

    <fieldset class="space-y-5">
        <legend class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">İletişim bilgileri</legend>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label for="name" class="form-label">Ad Soyad *</label><input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="120" class="form-input" autocomplete="name">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label for="phone" class="form-label">Telefon *</label><input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required maxlength="40" class="form-input" autocomplete="tel">@error('phone')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label for="email" class="form-label">E-posta *</label><input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="190" class="form-input" autocomplete="email">@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
        </div>
    </fieldset>

    <fieldset class="space-y-5">
        <legend class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Meseleniz</legend>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label for="service_id" class="form-label">Çalışma alanı</label>
                <select id="service_id" name="service_id" class="form-input">
                    <option value="">Emin değilim</option>
                    @foreach($services as $service)<option value="{{ $service->id }}" @selected((string) old('service_id', request('alan')) === (string) $service->id)>{{ $service->title }}</option>@endforeach
                </select>@error('service_id')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label for="team_member_id" class="form-label">Tercih ettiğiniz avukat</label>
                <select id="team_member_id" name="team_member_id" class="form-input">
                    <option value="">Fark etmez</option>
                    @foreach($lawyers as $lawyer)<option value="{{ $lawyer->id }}" @selected((string) old('team_member_id', request('avukat')) === (string) $lawyer->id)>{{ $lawyer->name }}</option>@endforeach
                </select>@error('team_member_id')<p class="form-error">{{ $message }}</p>@enderror</div>
        </div>
        <div><label for="subject" class="form-label">Konu başlığı</label><input id="subject" name="subject" type="text" value="{{ old('subject') }}" maxlength="255" class="form-input" placeholder="Örn. Kira sözleşmesinin feshi">@error('subject')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label for="message" class="form-label">Meselenizi kısaca özetleyin *</label><textarea id="message" name="message" rows="6" required minlength="20" maxlength="5000" class="form-input" placeholder="Olayın özeti, tarafları ve beklentiniz. Lütfen gizli belge ya da ayrıntılı kişisel veri paylaşmayınız.">{{ old('message') }}</textarea>@error('message')<p class="form-error">{{ $message }}</p>@enderror</div>
    </fieldset>

    <fieldset class="space-y-5">
        <legend class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Görüşme tercihi</legend>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <span class="form-label">Size nasıl ulaşalım? *</span>
                <div class="grid gap-2">
                    @foreach(\Templates\Law\Models\Consultation::CONTACT_METHODS as $key => $label)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 has-checked:border-primary has-checked:bg-primary-light">
                            <input type="radio" name="preferred_contact" value="{{ $key }}" class="h-4 w-4 border-slate-300 text-primary focus:ring-primary" @checked(old('preferred_contact', 'phone') === $key)> {{ $label }}
                        </label>
                    @endforeach
                </div>
                @error('preferred_contact')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div><label for="preferred_date" class="form-label">Tercih ettiğiniz tarih</label><input id="preferred_date" name="preferred_date" type="date" value="{{ old('preferred_date') }}" min="{{ now()->toDateString() }}" class="form-input">@error('preferred_date')<p class="form-error">{{ $message }}</p>@enderror
                @if(setting('office_hours_note'))<p class="mt-2 text-xs text-slate-500">{{ setting('office_hours_note') }}</p>@endif</div>
        </div>
    </fieldset>

    <div>
        <label class="flex items-start gap-3 text-sm text-slate-600">
            <input type="checkbox" name="kvkk" value="1" class="mt-1 h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" @checked(old('kvkk'))>
            <span><a href="{{ route('page.show', 'kvkk') }}" target="_blank" class="font-medium text-primary underline">KVKK Aydınlatma Metni</a>'ni okudum ve kişisel verilerimin ön görüşme amacıyla işlenmesini kabul ediyorum.</span>
        </label>
        @error('kvkk')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <button type="submit" class="btn-primary w-full sm:w-auto">Talebi Gönder <x-icon name="arrow-right" class="h-4 w-4" /></button>
</form>
