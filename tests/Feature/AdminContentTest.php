<?php

use App\Models\RentalItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('protects content management behind authentication', function () {
    $this->get(route('admin.content.index', 'services'))->assertRedirect(route('login'));
});

it('allows admin to create and delete a service', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('admin.content.store', 'services'), [
        'category' => 'workshop',
        'name' => 'Workshop Kreatif',
        'slug' => 'workshop-kreatif',
        'description' => 'Workshop untuk tim.',
        'features' => "Fasilitator\nModul",
        'sort_order' => 1,
        'is_active' => 1,
    ])->assertRedirect(route('admin.content.index', 'services'));

    $service = Service::query()->where('slug', 'workshop-kreatif')->firstOrFail();
    expect($service->features)->toBe(['Fasilitator', 'Modul']);

    $this->delete(route('admin.content.destroy', ['resource' => 'services', 'id' => $service->id]))
        ->assertRedirect();

    expect(Service::find($service->id))->toBeNull();
});

it('renders rental item management pages for admins', function () {
    Service::factory()->create(['category' => 'penyewaan', 'slug' => 'sewa-alat']);

    $this->actingAs(User::factory()->create())
        ->get(route('admin.content.index', 'rental-items'))
        ->assertOk()
        ->assertSee('Item Sewa');

    $this->get(route('admin.content.create', 'rental-items'))
        ->assertOk()
        ->assertSee('Kategori Alat')
        ->assertSee('Foto Item')
        ->assertSee('Tampilkan di website');
});

it('allows admin to create a rental item with a photo', function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());

    $rentalService = Service::factory()->create(['category' => 'penyewaan', 'slug' => 'sewa-alat']);

    $this->post(route('admin.content.store', 'rental-items'), [
        'service_id' => $rentalService->id,
        'category' => 'sound',
        'name' => 'Sound System Baru',
        'description' => 'Paket sound untuk acara.',
        'photo' => UploadedFile::fake()->image('sound.jpg'),
        'sort_order' => 1,
        'is_active' => 1,
    ])->assertRedirect(route('admin.content.index', 'rental-items'));

    $item = RentalItem::query()->where('name', 'Sound System Baru')->firstOrFail();

    expect($item->is_active)->toBeTrue()
        ->and($item->category)->toBe('sound');

    Storage::disk('public')->assertExists($item->photo);
    $this->get('/')->assertSuccessful()->assertSee('Sound System Baru');
});
