<?php

use App\Models\Service;
use App\Models\User;

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
