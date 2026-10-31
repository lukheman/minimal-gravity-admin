<?php

use App\Models\Collaboration;
use App\Models\RentalItem;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Testimonial;

it('shows public event organizer pages', function () {
    $this->get('/')->assertSuccessful()->assertSee('Sewa perlengkapan acara, lengkap dan siap pakai.');
    $this->get('/tentang')->assertSuccessful()->assertSee('Tentang kami');
    $this->get('/layanan')->assertSuccessful()->assertSee('Layanan');
    $this->get('/kontak')->assertSuccessful()->assertSee('Mari bicarakan acara Anda.');
});

it('shows rental catalog with live items and whatsapp cta', function () {
    SiteSetting::create(['key' => 'whatsapp_number', 'value' => '628111222333']);
    SocialLink::create(['platform' => 'Instagram', 'url' => 'https://instagram.com/nusaevent', 'icon' => 'fa-brands fa-instagram', 'sort_order' => 1]);

    $rentalService = Service::factory()->create([
        'category' => 'penyewaan',
        'name' => 'Sewa Alat',
        'slug' => 'sewa-alat',
    ]);
    $item = RentalItem::create([
        'service_id' => $rentalService->id,
        'category' => 'sound',
        'name' => 'Sound System Test',
        'description' => 'Sound system untuk acara.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
    $collaboration = Collaboration::create([
        'partner_name' => 'PT Contoh',
        'event_name' => 'Seminar Contoh',
        'slug' => 'seminar-contoh',
        'event_date' => now(),
        'description' => 'Kegiatan contoh.',
    ]);
    $testimonial = Testimonial::create([
        'name' => 'Sari Contoh',
        'organization' => 'Instansi Contoh',
        'comment' => 'Peralatan lengkap dan datang tepat waktu.',
        'rating' => 5,
    ]);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Pilih alat, cek jadwal, kami antar.')
        ->assertSee('Alat kami sudah mendukung berbagai acara')
        ->assertSee('Kata mereka yang sudah menyewa')
        ->assertSee($item->name)
        ->assertSee('Sound System')
        ->assertSee($collaboration->event_name)
        ->assertSee($testimonial->name)
        ->assertSee('Instagram')
        ->assertSee('wa.me/628111222333', false)
        ->assertSee('Sound+System+Test', false);
});

it('renders dummy rental image assets for seeded catalog items', function () {
    $this->seed();

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('/assets/dummy-rental/tenda.svg', false)
        ->assertSee('/assets/dummy-rental/sound.svg', false)
        ->assertSee('/assets/dummy-rental/lighting.svg', false);
});

it('hides inactive rental items from the public catalog', function () {
    $rentalService = Service::factory()->create(['category' => 'penyewaan', 'slug' => 'sewa-alat']);
    RentalItem::create([
        'service_id' => $rentalService->id,
        'category' => 'tenda',
        'name' => 'Tenda Tersembunyi',
        'sort_order' => 1,
        'is_active' => false,
    ]);

    $this->get('/')->assertSuccessful()->assertDontSee('Tenda Tersembunyi');
});

it('shows service detail by slug', function () {
    $service = Service::factory()->create(['slug' => 'event-test', 'name' => 'Event Test', 'is_active' => true]);

    $this->get(route('services.show', $service))->assertSuccessful()->assertSee('Event Test');
});
