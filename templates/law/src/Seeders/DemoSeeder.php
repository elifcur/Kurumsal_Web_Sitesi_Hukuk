<?php

namespace Templates\Law\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Service;
use App\Models\Tag;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Services\Settings;
use Illuminate\Database\Seeder;
use Templates\Law\Models\Consultation;
use Templates\Law\Models\Publication;

/**
 * Hukuk bürosu sitesini kurulur kurulmaz dolu gösteren demo içerik.
 * Idempotent: kaynak (publications) kaydı varsa hiçbir şey oluşturulmaz (demo logo/hero ayarları da bu blokta atanır).
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (Publication::query()->exists()) {
            return;
        }

        $settings = app(Settings::class);
        $settings->set('logo', '/images/templates/law/logo.png', 'general');
        $settings->set('hero_image', '/images/templates/law/hero.jpg', 'home');

        $serviceImages = ['/images/templates/law/service-1.jpg', '/images/templates/law/service-2.jpg', '/images/templates/law/service-3.jpg', '/images/templates/law/service-4.jpg'];

        $services = collect([
            ['title' => 'Ceza Hukuku', 'icon' => 'scale', 'excerpt' => 'Ceza davalarında etkin savunma ve hukuki destek; soruşturma ve kovuşturma aşamalarında şüpheli, sanık ve müşteki vekilliği.'],
            ['title' => 'Aile Hukuku', 'icon' => 'document', 'excerpt' => 'Boşanma, velayet, nafaka ve aile hukukuna dair tüm süreçler; mal paylaşımı, vasiyetname ve miras uyuşmazlıkları.'],
            ['title' => 'Ticaret Hukuku', 'icon' => 'building', 'excerpt' => 'Şirketler, sözleşmeler ve ticari davalar için çözüm odaklı hizmet; şirket kuruluşu, ortaklık sözleşmeleri, birleşme-devralma.'],
            ['title' => 'Gayrimenkul Hukuku', 'icon' => 'home', 'excerpt' => 'Tapu, kira, imar ve mülkiyet davalarında yanınızda; kat karşılığı inşaat sözleşmeleri ve kentsel dönüşüm.'],
            ['title' => 'İş ve Sosyal Güvenlik Hukuku', 'icon' => 'briefcase', 'excerpt' => 'İşe iade, kıdem-ihbar tazminatı, mobbing ve işveren tarafında uyum süreçleri.'],
            ['title' => 'Sözleşmeler ve Arabuluculuk', 'icon' => 'users', 'excerpt' => 'Ticari sözleşmelerin hazırlanması, müzakeresi ve ihtiyari ya da dava şartı arabuluculuk süreçleri.'],
        ])->map(fn (array $service, int $i) => Service::factory()->create($service + ['image' => $serviceImages[$i % count($serviceImages)], 'sort_order' => $i, 'is_featured' => true]));

        $lawyers = collect([
            ['name' => 'Av. Selin Yılmaz', 'title' => 'Kurucu Ortak', 'excerpt' => 'Ticaret ve şirketler hukuku alanında 18 yıllık deneyim; birleşme-devralma ve ortaklık uyuşmazlıklarında kurumsal müvekkilleri temsil eder.', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Uzmanlık', 'value' => 'Ticaret ve şirketler hukuku'], ['label' => 'Diller', 'value' => 'Türkçe, İngilizce'], ['label' => 'Eğitim', 'value' => 'İstanbul Üniversitesi Hukuk Fakültesi; LL.M. (King\'s College London)']]],
            ['name' => 'Av. Kerem Yalçın', 'title' => 'Ortak', 'excerpt' => 'İş hukuku ve sosyal güvenlik uyuşmazlıklarında hem işçi hem işveren tarafında geniş dava tecrübesi.', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Uzmanlık', 'value' => 'İş ve sosyal güvenlik hukuku'], ['label' => 'Diller', 'value' => 'Türkçe, İngilizce'], ['label' => 'Eğitim', 'value' => 'Ankara Üniversitesi Hukuk Fakültesi']]],
            ['name' => 'Av. Elif Demirtaş', 'title' => 'Kıdemli Avukat', 'excerpt' => 'Gayrimenkul, kira ve inşaat sözleşmelerinden doğan uyuşmazlıklar ile kentsel dönüşüm süreçlerinde uzmanlaşmıştır.', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Uzmanlık', 'value' => 'Gayrimenkul ve inşaat hukuku'], ['label' => 'Diller', 'value' => 'Türkçe, Almanca'], ['label' => 'Eğitim', 'value' => 'Marmara Üniversitesi Hukuk Fakültesi']]],
            ['name' => 'Av. Burak Şener', 'title' => 'Avukat · Arabulucu', 'excerpt' => 'Aile ve miras hukuku davaları; Adalet Bakanlığı siciline kayıtlı arabulucu.', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Uzmanlık', 'value' => 'Aile ve miras hukuku, arabuluculuk'], ['label' => 'Diller', 'value' => 'Türkçe, İngilizce'], ['label' => 'Eğitim', 'value' => 'Galatasaray Üniversitesi Hukuk Fakültesi']]],
            ['name' => 'Av. Zeynep Koç', 'title' => 'Avukat', 'excerpt' => 'Ceza hukuku ve ekonomik suçlar alanında soruşturma ve kovuşturma aşamalarında müdafilik.', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Uzmanlık', 'value' => 'Ceza hukuku'], ['label' => 'Diller', 'value' => 'Türkçe, Fransızca'], ['label' => 'Eğitim', 'value' => 'Dokuz Eylül Üniversitesi Hukuk Fakültesi']]],
        ])->map(fn (array $lawyer, int $i) => TeamMember::factory()->create($lawyer + ['sort_order' => $i, 'is_featured' => $i < 4, 'socials' => ['linkedin' => 'https://www.linkedin.com/']]));

        foreach ([
            ['M. K.', 'Kurumsal müvekkil · Lojistik', 'Ortaklık uyuşmazlığımızı dava aşamasına gelmeden, öngörülebilir bir çerçevede çözdüler. Her adımda ne olacağını önceden bildik.'],
            ['A. T.', 'Bireysel müvekkil', 'İşe iade sürecinde ilk günden itibaren sakin, net ve ulaşılabilir oldular. Sonuç beklediğimizden de iyiydi.'],
            ['S. Y.', 'Bireysel müvekkil', 'Miras paylaşımı gibi hassas bir konuda ailemizi yormadan, hukuki çerçeveyi açıkça anlatarak süreci yönettiler.'],
        ] as $i => [$name, $title, $content]) {
            Testimonial::factory()->create(['name' => $name, 'title' => $title, 'content' => $content, 'rating' => 5, 'sort_order' => $i]);
        }

        foreach ([
            ['Ön görüşme ücretli mi?', 'İlk ön görüşme, meselenizin hangi çalışma alanına girdiğini ve nasıl bir yol izleneceğini belirlemek amacıyla yapılır; ücret ve çalışma koşulları bu görüşmede açıkça paylaşılır.'],
            ['Avukatlık ücreti nasıl belirlenir?', 'Ücretler, Türkiye Barolar Birliği Avukatlık Asgari Ücret Tarifesi esas alınarak işin niteliğine ve kapsamına göre yazılı sözleşmeyle belirlenir.'],
            ['Dava açmadan önce arabuluculuk zorunlu mu?', 'İş, ticari ve kira uyuşmazlıkları gibi bazı alanlarda arabuluculuk dava şartıdır. Meselenize göre zorunlu ya da ihtiyari arabuluculuk yolunu birlikte değerlendiririz.'],
            ['Dosyamla kim ilgilenecek?', 'Her dosyadan sorumlu bir avukat bulunur ve bu avukat sizinle doğrudan iletişim kurar. Gerekli hallerde ilgili alandaki ortağımız da sürece dahil olur.'],
            ['Şehir dışından müvekkil kabul ediyor musunuz?', 'Evet. Görüşmeler ofisimizde ya da çevrim içi yapılabilir; duruşmalar için Türkiye genelinde takip ve gerektiğinde yerel meslektaşlarımızla iş birliği yapıyoruz.'],
            ['Belgelerimi nasıl iletmeliyim?', 'Ön görüşme sonrasında size güvenli bir paylaşım yöntemi iletilir. Lütfen ilk aşamada yalnızca özet bilgi paylaşın; ayrıntıları görüşmede ele alırız.'],
        ] as $i => [$question, $answer]) {
            Faq::factory()->create(['question' => $question, 'answer' => $answer, 'sort_order' => $i]);
        }

        foreach ([['İstanbul Barosu', 'https://www.istanbulbarosu.org.tr'], ['Türkiye Barolar Birliği', 'https://www.barobirlik.org.tr'], ['ICC Türkiye', 'https://www.icc.tobb.org.tr'], ['Arabuluculuk Derneği', null]] as $i => [$name, $url]) {
            Partner::factory()->create(['name' => $name, 'url' => $url, 'sort_order' => $i]);
        }

        $category = Category::factory()->post()->create(['name' => 'Makaleler']);
        $tags = collect(['iş hukuku', 'ticaret hukuku', 'kira', 'arabuluculuk', 'miras'])->map(fn ($n) => Tag::factory()->create(['name' => $n]));
        $author = User::query()->first();

        foreach ([
            ['İşe İade Davasında Süreler ve Arabuluculuk Şartı', 'Fesih bildiriminden itibaren bir ay içinde arabulucuya başvurulmaması davanın usulden reddine yol açar. Süreleri ve dikkat edilecek noktaları özetliyoruz.'],
            ['Anonim Şirketlerde Ortaklar Arası Uyuşmazlıkların Çözümü', 'Pay sahipleri sözleşmesi, hakimiyet uyuşmazlıkları ve haklı sebeple fesih davası hangi durumlarda gündeme gelir?'],
            ['Kira Sözleşmelerinde Tahliye Sebepleri: 2026 Güncel Uygulama', 'İhtiyaç sebebiyle tahliye, iki haklı ihtar ve tahliye taahhüdü konularında Yargıtay\'ın son dönem yaklaşımı.'],
            ['Miras Paylaşımında Saklı Pay ve Tenkis Davası', 'Vasiyetname ya da sağlararası kazandırmalarla saklı payı ihlal edilen mirasçıların hakları ve dava süreleri.'],
            ['Ticari Sözleşmelerde Mücbir Sebep Maddesi Nasıl Kaleme Alınmalı?', 'Aşırı ifa güçlüğü ile mücbir sebep arasındaki fark ve sözleşmeye eklenecek koruyucu hükümler.'],
        ] as $i => [$title, $excerpt]) {
            $post = Post::factory()->create(['title' => $title, 'excerpt' => $excerpt, 'user_id' => $author?->id, 'category_id' => $category->id, 'published_at' => now()->subDays(6 * $i + 2)]);
            $post->tags()->sync($tags->random(2)->pluck('id'));
        }

        foreach ([
            ['İşçi ve İşveren İçin Fesih Süreci Rehberi', 'guide', 'Fesih bildirimi, savunma alma, arabuluculuk ve dava aşamalarını adım adım anlatan uygulama rehberi.', 'documents/fesih-sureci-rehberi.pdf', null],
            ['Kira Sözleşmesi Örneği (Konut)', 'form', 'Türk Borçlar Kanunu\'na uygun, boşluk doldurmalı konut kira sözleşmesi şablonu.', 'documents/konut-kira-sozlesmesi.pdf', null],
            ['Vekaletname İçin Gerekli Bilgiler', 'form', 'Noterde avukat vekaletnamesi düzenletirken gereken bilgiler ve büromuzun vekalet bilgileri.', 'documents/vekaletname-bilgileri.pdf', null],
            ['Aylık Mevzuat Bülteni · Eylül 2026', 'bulletin', 'Ay içinde Resmî Gazete\'de yayımlanan, müvekkillerimizi ilgilendiren düzenlemelerin özeti.', 'documents/bulten-2026-09.pdf', null],
            ['KVKK Uyum Kontrol Listesi', 'article', 'Kişisel Verileri Koruma Kurumu\'nun yayımladığı rehberlere dayalı, şirketler için uyum kontrol listesi.', null, 'https://www.kvkk.gov.tr/'],
        ] as $i => [$title, $type, $summary, $file, $url]) {
            Publication::factory()->create(['title' => $title, 'type' => $type, 'summary' => $summary, 'file' => $file, 'external_url' => $url, 'published_at' => now()->subWeeks($i), 'sort_order' => $i]);
        }

        foreach ([
            ['Deniz Arslan', 'İşten çıkarılma sonrası tazminat', 'new', 'phone', 4, 1],
            ['Murat Öztürk', 'Ortaklık payı devri sözleşmesi', 'contacted', 'email', 2, 0],
            ['Gamze Ünal', 'Kiracının tahliyesi', 'scheduled', 'office', 3, 2],
            ['Hakan Çelik', 'Vasiyetname düzenleme', 'closed', 'phone', 1, 3],
            ['Nur Kaplan', 'Şirket kuruluşu ve ana sözleşme', 'new', 'email', 2, null],
        ] as $i => [$name, $subject, $status, $contact, $serviceIndex, $lawyerIndex]) {
            Consultation::factory()->create([
                'name' => $name,
                'subject' => $subject,
                'status' => $status,
                'preferred_contact' => $contact,
                'service_id' => $services[$serviceIndex]->id,
                'team_member_id' => $lawyerIndex === null ? null : $lawyers[$lawyerIndex]->id,
                'notes' => $status === 'scheduled' ? 'Perşembe 14:00 ofiste görüşme.' : null,
                'created_at' => now()->subDays($i),
            ]);
        }
    }
}
