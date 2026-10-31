<?php

use App\Models\Collaboration;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Testimonial;

it('shows public event organizer pages', function () {
    $this->get('/')->assertSuccessful()->assertSee('Membuat momen penting terasa lebih berarti.');
    $this->get('/tentang')->assertSuccessful()->assertSee('Tentang kami');
    $this->get('/layanan')->assertSuccessful()->assertSee('Layanan');
    $this->get('/kontak')->assertSuccessful()->assertSee('Mari bicarakan acara Anda.');
});

it('shows landing page conversion sections with live content', function () {
    SiteSetting::create(['key' => 'whatsapp_number', 'value' => '628111222333']);
    SocialLink::create(['platform' => 'Instagram', 'url' => 'https://instagram.com/nusaevent', 'icon' => 'fa-brands fa-instagram', 'sort_order' => 1]);

    $service = Service::factory()->create(['name' => 'Workshop Publik', 'slug' => 'workshop-publik']);
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
        'comment' => 'Acara berjalan sangat baik.',
        'rating' => 5,
    ]);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Layanan untuk setiap kebutuhan acara')
        ->assertSee('Kerja sama yang sudah berjalan')
        ->assertSee('Kata mereka yang sudah bekerja bersama kami')
        ->assertSee($service->name)
        ->assertSee($collaboration->event_name)
        ->assertSee($testimonial->name)
        ->assertSee('Instagram')
        ->assertSee('wa.me/628111222333', false);
});

it('shows service detail by slug', function () {
    $service = Service::factory()->create(['slug' => 'event-test', 'name' => 'Event Test', 'is_active' => true]);

    $this->get(route('services.show', $service))->assertSuccessful()->assertSee('Event Test');
});
