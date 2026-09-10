<?php

namespace Tests\Feature\Templates;

use App\Mail\ContactMessageReceived;
use App\Models\Service;
use App\Models\TeamMember;
use App\Services\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Templates\Law\Models\Consultation;
use Templates\Law\Models\Publication;
use Tests\TestCase;

class LawTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->activeTemplateKey() !== 'law') {
            $this->markTestSkipped('Bu test yalnızca law şablonu aktifken çalışır (APP_TEMPLATE=law).');
        }
    }

    public function test_home_page_renders_with_disclaimer_and_sector_sections(): void
    {
        app(Settings::class)->set('disclaimer_text', 'Bu site TBB Reklam Yasağı Yönetmeliği kapsamında hazırlanmıştır.');
        app(Settings::class)->set('bar_registration', 'İstanbul Barosu · Sicil No: 99999');
        Service::factory()->create(['title' => 'Ticaret Hukuku']);
        TeamMember::factory()->create(['name' => 'Av. Selin Aydın', 'is_featured' => true, 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu']]]);
        Publication::factory()->create(['title' => 'Fesih Rehberi']);
        Publication::factory()->inactive()->create(['title' => 'Gizli Kaynak']);

        $this->get('/')->assertOk()
            ->assertSee('Bu site TBB Reklam Yasağı Yönetmeliği kapsamında hazırlanmıştır.')
            ->assertSee('İstanbul Barosu · Sicil No: 99999')
            ->assertSee('Ticaret Hukuku')
            ->assertSee('Av. Selin Aydın')
            ->assertSee('Fesih Rehberi')
            ->assertDontSee('Gizli Kaynak')
            ->assertSee(route('consultations.create'));
    }

    public function test_service_and_lawyer_pages_render(): void
    {
        $service = Service::factory()->create(['title' => 'Aile ve Miras Hukuku']);
        $lawyer = TeamMember::factory()->create(['name' => 'Av. Kerem Yalçın', 'attributes' => [['label' => 'Baro', 'value' => 'İstanbul Barosu'], ['label' => 'Diller', 'value' => 'Türkçe, İngilizce']]]);

        $this->get('/hizmetler')->assertOk()->assertSee('Aile ve Miras Hukuku');
        $this->get($service->url())->assertOk()->assertSee('Aile ve Miras Hukuku')->assertSee(route('consultations.create', ['alan' => $service->id]));
        $this->get('/ekibimiz')->assertOk()->assertSee('Av. Kerem Yalçın')->assertSee('İstanbul Barosu');
        $this->get($lawyer->url())->assertOk()->assertSee('Türkçe, İngilizce')->assertSee(route('consultations.create', ['avukat' => $lawyer->id]));
        Publication::factory()->create();
        $this->get('/sitemap.xml')->assertOk()->assertSee(route('publications.index'))->assertSee(route('consultations.create'))->assertSee('<lastmod>', false);
    }

    public function test_consultation_form_renders_and_stores_request(): void
    {
        Mail::fake();
        app(Settings::class)->set('email', 'ofis@test.com');
        $service = Service::factory()->create(['title' => 'İş Hukuku']);
        $lawyer = TeamMember::factory()->create(['name' => 'Av. Elif Demirtaş']);

        $this->get('/on-gorusme')->assertOk()->assertSee('İş Hukuku')->assertSee('Av. Elif Demirtaş')->assertSee('KVKK');

        $this->from('/on-gorusme')->post(route('consultations.store'), [
            'name' => 'Deniz Arslan', 'email' => 'deniz@example.com', 'phone' => '0555 111 22 33',
            'service_id' => $service->id, 'team_member_id' => $lawyer->id, 'subject' => 'İşten çıkarılma',
            'message' => 'İş akdim geçen hafta feshedildi, tazminat haklarımı öğrenmek istiyorum.',
            'preferred_contact' => 'office', 'preferred_date' => now()->addDays(3)->toDateString(), 'kvkk' => 1,
        ])->assertRedirect('/on-gorusme')->assertSessionHas('success');

        $consultation = Consultation::query()->firstOrFail();
        $this->assertSame('new', $consultation->status);
        $this->assertSame($service->id, $consultation->service_id);
        $this->assertSame($lawyer->id, $consultation->team_member_id);
        $this->assertSame('office', $consultation->preferred_contact);
        $this->assertSame(now()->addDays(3)->toDateString(), $consultation->preferred_date->toDateString());

        $this->assertDatabaseHas('contact_messages', ['type' => 'consultation', 'email' => 'deniz@example.com']);
        Mail::assertSent(ContactMessageReceived::class, fn ($mail) => $mail->hasTo('ofis@test.com'));

        $this->get('/on-gorusme')->assertOk();
    }

    public function test_consultation_form_validation_and_honeypot(): void
    {
        $this->post(route('consultations.store'), ['name' => '', 'email' => 'x', 'message' => 'kısa', 'preferred_contact' => 'fax', 'preferred_date' => now()->subDay()->toDateString()])
            ->assertSessionHasErrors(['name', 'email', 'phone', 'message', 'preferred_contact', 'preferred_date', 'kvkk']);

        $this->post(route('consultations.store'), [
            'name' => 'Bot', 'email' => 'bot@x.com', 'phone' => '1', 'message' => str_repeat('spam ', 10), 'preferred_contact' => 'phone', 'kvkk' => 1, 'website' => 'http://spam',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, Consultation::query()->count());
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_publications_page_lists_active_resources_with_type_filter(): void
    {
        Publication::factory()->create(['title' => 'Kira Sözleşmesi Örneği', 'type' => 'form']);
        Publication::factory()->external()->create(['title' => 'KVKK Kontrol Listesi', 'type' => 'guide']);
        Publication::factory()->inactive()->create(['title' => 'Taslak Bülten', 'type' => 'bulletin']);

        $this->get('/kaynaklar')->assertOk()->assertSee('Kira Sözleşmesi Örneği')->assertSee('KVKK Kontrol Listesi')->assertDontSee('Taslak Bülten')->assertSee('https://www.mevzuat.gov.tr/');
        $this->get('/kaynaklar?tur=form')->assertOk()->assertSee('Kira Sözleşmesi Örneği')->assertDontSee('KVKK Kontrol Listesi');
        $this->get('/kaynaklar?q=KVKK')->assertOk()->assertSee('KVKK Kontrol Listesi')->assertDontSee('Kira Sözleşmesi Örneği');
        $this->get('/kaynaklar?tur=invalid')->assertSessionHasErrors('tur');
    }

    public function test_admin_can_track_consultation_status(): void
    {
        $user = $this->editor();
        $lawyer = TeamMember::factory()->create(['name' => 'Av. Burak Şener']);
        $consultation = Consultation::factory()->create(['name' => 'Gamze Ünal', 'subject' => 'Kiracının tahliyesi']);
        Consultation::factory()->status('closed')->create(['name' => 'Kapanmış Talep']);

        $this->get(route('admin.consultations.index'))->assertRedirect(route('admin.login'));
        $this->actingAs($user)->get(route('admin.consultations.index'))->assertOk()->assertSee('Gamze Ünal')->assertSee('Kapanmış Talep');
        $this->actingAs($user)->get(route('admin.consultations.index', ['status' => 'new']))->assertOk()->assertSee('Gamze Ünal')->assertDontSee('Kapanmış Talep');
        $this->actingAs($user)->get(route('admin.consultations.show', $consultation))->assertOk()->assertSee('Kiracının tahliyesi');

        $this->actingAs($user)->put(route('admin.consultations.update', $consultation), ['status' => 'scheduled', 'team_member_id' => $lawyer->id, 'notes' => 'Perşembe 14:00'])
            ->assertRedirect(route('admin.consultations.show', $consultation));

        $consultation->refresh();
        $this->assertSame('scheduled', $consultation->status);
        $this->assertSame($lawyer->id, $consultation->team_member_id);
        $this->assertSame('Perşembe 14:00', $consultation->notes);

        $this->actingAs($user)->put(route('admin.consultations.update', $consultation), ['status' => 'bogus'])->assertSessionHasErrors('status');

        $this->actingAs($user)->delete(route('admin.consultations.destroy', $consultation))->assertRedirect(route('admin.consultations.index'));
        $this->assertModelMissing($consultation);
    }

    public function test_admin_can_manage_publications(): void
    {
        $user = $this->editor();

        $this->actingAs($user)->get(route('admin.publications.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.publications.create'))->assertOk();

        $this->actingAs($user)->post(route('admin.publications.store'), ['title' => 'Vekaletname Bilgileri', 'type' => 'form', 'is_active' => 1])
            ->assertSessionHasErrors(['file', 'external_url']);

        $this->actingAs($user)->post(route('admin.publications.store'), [
            'title' => 'Vekaletname İçin Gerekli Bilgiler', 'type' => 'form', 'summary' => 'Noter için gerekenler.',
            'file' => 'documents/vekaletname.pdf', 'published_at' => '2026-09-01', 'is_active' => 1, 'sort_order' => 2,
        ])->assertRedirect();

        $publication = Publication::query()->firstOrFail();
        $this->assertSame('vekaletname-icin-gerekli-bilgiler', $publication->slug);
        $this->assertSame('Form', $publication->typeLabel());
        $this->assertFalse($publication->isExternal());

        $this->actingAs($user)->put(route('admin.publications.update', $publication), ['title' => 'Güncel Başlık', 'type' => 'guide', 'file' => '', 'external_url' => 'https://www.kvkk.gov.tr/', 'is_active' => 0])->assertRedirect();
        $publication->refresh();
        $this->assertFalse($publication->is_active);
        $this->assertTrue($publication->isExternal());
        $this->assertNull($publication->file);

        $this->get('/kaynaklar')->assertOk()->assertDontSee('Güncel Başlık');

        $this->actingAs($user)->delete(route('admin.publications.destroy', $publication));
        $this->assertModelMissing($publication);
    }

    public function test_products_section_is_disabled_for_this_template(): void
    {
        $this->get('/urunler')->assertNotFound();
        $this->actingAs($this->superAdmin())->get('/admin/products')->assertNotFound();
        $this->actingAs($this->superAdmin())->get(route('admin.dashboard'))->assertOk()->assertSee('Ön Görüşme Talepleri')->assertSee('Kaynaklar')->assertSee('Hukuk');
    }
}
