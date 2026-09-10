# Hukuk Şablonu (`law`)

Hukuk büroları ve danışmanlık firmaları için hazır kurumsal site. Bu proje hazır bir CMS (Statamic, October vb.) kurmaz: Laravel + MySQL/MariaDB + kendi admin panelimiz + bu şablon.

## Tasarım kimliği
Mockup'a (images/Hukuk.png) sadık: siyah (`#1c1c1c`) zemin üstünde adalet heykeli fotoğraflı hero (soldan sağa koyu gradient), altın (`#b8965a`) uppercase eyebrow + serif başlık (vurgu kelimesi altın, italik değil), altın dolgulu + beyaz çerçeveli butonlar. Hero altında koyu özellik bandı (4 madde + telefon). Ana içerik iki sütun: fotoğraflı çalışma alanı kartları (sol alta binen beyaz yuvarlak ikon rozeti, "Detaylı Bilgi →") + krem (`#f6f1e8`) "Hemen Randevu Alın" hızlı formu (ön görüşme POST rotasına `quick=1` ile gider; mesaj alanı yoktur). İkonlu istatistik şeridi + altın tırnaklı italik alıntı. Serif başlıklar (Cormorant Garamond) + Source Sans 3 gövde, `rounded-lg` kartlar. Demo görseller `public/images/templates/law/`.

## Sektör içeriği
- **Ön Görüşme Talepleri** (`consultations`): ad, iletişim, çalışma alanı (services FK), tercih edilen avukat (team_members FK), konu, mesaj, iletişim tercihi (telefon/e-posta/ofis), tercih edilen tarih, durum (yeni / iletişime geçildi / randevu verildi / kapatıldı), dahili notlar.
  - Public: `/on-gorusme` (GET form, POST). Her talep ayrıca Mesajlar'a **"Ön Görüşme Talebi"** tipiyle düşer ve bildirim e-postası gönderilir.
  - Admin: **Hukuk > Ön Görüşme Talepleri** (durum filtresi, durum/avukat/not güncelleme).
- **Kaynaklar** (`publications`): rehber / form / makale / bülten; PDF dosyası (medya kütüphanesi) ya da dış bağlantı.
  - Public: `/kaynaklar` (tür filtresi, arama, indirme/dış link).
  - Admin: **Hukuk > Kaynaklar** (CRUD).

## Kullanılan çekirdek özellikler
Hizmetler = **Çalışma Alanları**, Blog = **Makaleler**, Ekip = Avukatlar, Müşteri Yorumları, SSS, Partnerler (**Üyelikler & Kurumlar** logo şeridi). Ürünler kapalı.

## Şablon ayarları (Site Ayarları > Hukuk Ayarları)
`hero_eyebrow`, `appointment_button_text`, `consultation_label`, `consultation_intro`, `consultation_success`, `publications_label`, `team_home_title`, `disclaimer_text` (footer'da TBB Reklam Yasağı'na uygun yasal uyarı), `bar_registration` (baro sicil bilgisi; üst şerit, hero ve footer), `office_hours_note`.

## Ekip üyesi özellikleri
Avukat kartlarında ve profilde `Baro`, `Uzmanlık`, `Diller`, `Eğitim` etiketli özellikler gösterilir (Admin > Ekip > Özellikler).

## Demo içerik
`DemoSeeder`: logo + hero görseli ayarları, 6 çalışma alanı (Ceza, Aile, Ticaret, Gayrimenkul, İş, Sözleşmeler — fotoğraflı), 5 avukat, 3 müvekkil yorumu (kısaltılmış isim), 6 SSS, 4 üyelik/kurum, "Makaleler" kategorisi + 5 yazı, 5 kaynak, 5 ön görüşme talebi (farklı durumlarda).
