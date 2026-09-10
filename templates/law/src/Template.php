<?php

namespace Templates\Law;

use App\Models\Faq;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Templates\Template as BaseTemplate;
use Templates\Law\Models\Consultation;
use Templates\Law\Models\Publication;

/**
 * Hukuk / danışmanlık şablonu. Laravel + kendi admin panelimiz + bu şablon;
 * hazır bir CMS (Statamic, October...) kurulmaz.
 */
class Template extends BaseTemplate
{
    public function key(): string
    {
        return 'law';
    }

    public function name(): string
    {
        return 'Hukuk';
    }

    public function description(): string
    {
        return 'Hukuk büroları ve danışmanlık firmaları için: çalışma alanları, avukat kadrosu, ön görüşme talebi, kaynak (rehber/form/bülten) kütüphanesi, makaleler.';
    }

    public function features(): array
    {
        return [
            'services' => true,
            'products' => false,
            'blog' => true,
            'team' => true,
            'testimonials' => true,
            'faqs' => true,
            'partners' => true,
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'general' => [
                'site_name' => 'Yılmaz & Partnerler Hukuk Bürosu',
                'site_tagline' => 'Hukukun üstün olduğu bir toplum, her zaman daha güçlüdür.',
                'primary_color' => '#1c1c1c',
                'services_label' => 'Çalışma Alanları',
                'blog_label' => 'Makaleler',
                'footer_text' => 'Tüm hakları saklıdır.',
            ],
            'seo' => [
                'meta_title' => 'Yılmaz & Partnerler Hukuk Bürosu | Hukuki Danışmanlık ve Dava Takibi',
                'meta_description' => 'Ticaret, iş, gayrimenkul, aile ve ceza hukuku alanlarında bireysel ve kurumsal müvekkillere hukuki danışmanlık, sözleşme yönetimi ve dava takibi.',
            ],
            'home' => [
                'hero_title' => 'Hukuki Gücünüz, *Güvenilir Ortağınız*',
                'hero_subtitle' => 'Yılmaz & Partnerler Hukuk Bürosu olarak, bireysel ve kurumsal müvekkillerimize çözüm odaklı, güvenilir ve etik hukuki danışmanlık hizmetleri sunuyoruz.',
                'hero_button_text' => 'Bizimle İletişime Geç',
                'hero_button_url' => '/iletisim',
                'hero_button2_text' => 'Hizmetlerimizi İncele',
                'hero_button2_url' => '/hizmetler',
                'about_title' => 'Hukuku, müvekkilin gerçek ihtiyacı üzerinden okuruz',
                'about_text' => "2009 yılından bu yana İstanbul merkezli olarak faaliyet gösteren büromuz, her dosyayı sorumlu bir avukatın doğrudan takip ettiği butik bir çalışma düzenine sahiptir.\nAmacımız yalnızca dava kazanmak değil; müvekkilimizi uyuşmazlığa girmeden koruyan, öngörülebilir ve şeffaf bir hukuki süreç yürütmektir.",
                'services_intro' => 'Bireysel ve kurumsal müvekkillerimize danışmanlık, sözleşme ve dava takibi hizmeti verdiğimiz başlıca alanlar.',
                'blog_intro' => 'Güncel mevzuat, içtihat ve uygulamaya dair bilgilendirici yazılar.',
                'cta_title' => 'Ön görüşme *talep edin*',
                'cta_text' => 'Meselenizi kısaca anlatın; uygun avukatımız en kısa sürede sizinle iletişime geçsin.',
                'cta_button_text' => 'Ön Görüşme Talep Edin',
                'cta_button_url' => '/on-gorusme',
                'stats' => '10+|Yıllık Deneyim;500+|Mutlu Müvekkil;1000+|Tamamlanan Dava;20+|Kurumsal İş Ortağı',
            ],
            'template' => [
                'hero_eyebrow' => 'Adalet, Daima Yanınızda',
                'appointment_button_text' => 'Randevu Al',
                'consultation_label' => 'Ön Görüşme',
                'consultation_intro' => 'Formu doldurun; uygun avukatımız talebinizi inceleyip sizinle iletişime geçsin. Ön görüşme, vekalet ilişkisi kurulduğu anlamına gelmez.',
                'publications_label' => 'Kaynaklar',
                'team_home_title' => 'Ekibimiz',
                'disclaimer_text' => 'Bu sitede yer alan bilgiler yalnızca genel bilgilendirme amaçlıdır; hukuki tavsiye niteliği taşımaz ve avukat-müvekkil ilişkisi kurmaz. Sitemiz Türkiye Barolar Birliği Reklam Yasağı Yönetmeliği\'ne uygun olarak hazırlanmıştır.',
                'bar_registration' => 'İstanbul Barosu · Sicil No: 12345',
                'office_hours_note' => 'Görüşmeler yalnızca randevu ile yapılmaktadır.',
                'consultation_success' => 'Ön görüşme talebiniz alındı. Avukatımız en kısa sürede sizinle iletişime geçecektir.',
            ],
        ];
    }

    public function settingFields(): array
    {
        return [
            'hero_eyebrow' => ['label' => 'Hero üst etiketi', 'type' => 'text', 'help' => 'Başlığın üstündeki küçük altın metin. Örn. Adalet, Daima Yanınızda', 'rules' => ['max:80']],
            'appointment_button_text' => ['label' => 'Randevu butonu metni', 'type' => 'text', 'help' => 'Üst menüdeki altın buton.', 'rules' => ['max:40']],
            'consultation_label' => ['label' => 'Ön görüşme etiketi', 'type' => 'text', 'help' => 'Menü ve buton metinlerinde kullanılır.', 'rules' => ['max:50']],
            'consultation_intro' => ['label' => 'Ön görüşme sayfası açıklaması', 'type' => 'textarea', 'rules' => ['max:500']],
            'consultation_success' => ['label' => 'Ön görüşme formu başarı mesajı', 'type' => 'text', 'rules' => ['max:255']],
            'publications_label' => ['label' => 'Kaynaklar menü etiketi', 'type' => 'text', 'rules' => ['max:50']],
            'team_home_title' => ['label' => 'Ana sayfa ekip başlığı', 'type' => 'text', 'rules' => ['max:120']],
            'disclaimer_text' => ['label' => 'Yasal uyarı (footer)', 'type' => 'textarea', 'help' => 'TBB Reklam Yasağı Yönetmeliği\'ne uygun bilgilendirme metni.', 'rules' => ['max:1000']],
            'bar_registration' => ['label' => 'Baro sicil bilgisi', 'type' => 'text', 'help' => 'Örn. İstanbul Barosu · Sicil No: 12345', 'rules' => ['max:160']],
            'office_hours_note' => ['label' => 'Çalışma saati notu', 'type' => 'text', 'help' => 'Örn. Görüşmeler yalnızca randevu ile yapılmaktadır.', 'rules' => ['max:160']],
        ];
    }

    public function adminMenu(): array
    {
        return [
            ['label' => 'Ön Görüşme Talepleri', 'route' => 'admin.consultations.index', 'pattern' => 'admin.consultations.*', 'icon' => 'calendar', 'permission' => 'manage-sector'],
            ['label' => 'Kaynaklar', 'route' => 'admin.publications.index', 'pattern' => 'admin.publications.*', 'icon' => 'document', 'permission' => 'manage-sector'],
        ];
    }

    public function publicMenu(): array
    {
        return [
            ['label' => setting('publications_label', 'Kaynaklar'), 'route' => 'publications.index', 'pattern' => 'kaynaklar*'],
        ];
    }

    public function dashboardStats(): array
    {
        return [
            ['label' => 'Ön Görüşme Talepleri', 'value' => Consultation::query()->where('status', 'new')->count(), 'sub' => Consultation::query()->count().' toplam · yeni talep', 'route' => 'admin.consultations.index', 'icon' => 'calendar'],
            ['label' => 'Kaynaklar', 'value' => Publication::query()->count(), 'sub' => Publication::query()->active()->count().' yayında', 'route' => 'admin.publications.index', 'icon' => 'document'],
        ];
    }

    public function sitemapEntries(): array
    {
        return [
            ['url' => route('publications.index'), 'updated' => Publication::query()->active()->latest('updated_at')->first()?->updated_at, 'priority' => '0.7'],
            ['url' => route('consultations.create'), 'updated' => null, 'priority' => '0.8'],
        ];
    }

    public function messageTypes(): array
    {
        return ['consultation' => 'Ön Görüşme Talebi'];
    }

    public function homeData(): array
    {
        return [
            'services' => setting('show_services', '1') === '1' ? Service::query()->active()->ordered()->limit(6)->get() : collect(),
            'team' => TeamMember::query()->active()->where('is_featured', true)->ordered()->limit(4)->get(),
            'testimonials' => Testimonial::query()->active()->ordered()->limit(3)->get(),
            'faqs' => Faq::query()->active()->ordered()->limit(6)->get(),
            'partners' => Partner::query()->active()->ordered()->get(),
            'posts' => setting('show_blog', '1') === '1' ? Post::query()->with('category')->published()->latestPublished()->limit(4)->get() : collect(),
            'publications' => Publication::query()->active()->ordered()->limit(3)->get(),
            'stats' => site_stats(),
        ];
    }
}
