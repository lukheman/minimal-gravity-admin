<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use App\Models\RentalItem;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    private const RESOURCES = [
        'rental-items' => ['title' => 'Item Sewa', 'model' => RentalItem::class, 'fields' => ['service_id', 'category', 'name', 'description', 'photo', 'sort_order', 'is_active']],
        'services' => ['title' => 'Layanan', 'model' => Service::class, 'fields' => ['category', 'name', 'slug', 'description', 'features', 'sort_order', 'is_active']],
        'collaborations' => ['title' => 'Kerja Sama', 'model' => Collaboration::class, 'fields' => ['partner_name', 'event_name', 'slug', 'event_date', 'service_category', 'description', 'is_active']],
        'testimonials' => ['title' => 'Testimoni', 'model' => Testimonial::class, 'fields' => ['name', 'organization', 'comment', 'rating', 'is_active']],
        'social-links' => ['title' => 'Media Sosial', 'model' => SocialLink::class, 'fields' => ['platform', 'url', 'icon', 'sort_order', 'is_active']],
    ];

    public function index(string $resource): View
    {
        $config = $this->config($resource);
        $records = $config['model']::query()->latest()->paginate(12);

        return view('admin.content.index', compact('resource', 'config', 'records'));
    }

    public function create(string $resource): View
    {
        return view('admin.content.form', [
            'resource' => $resource,
            'config' => $this->config($resource),
            'record' => null,
            'rentalServices' => $this->rentalServices($resource),
        ]);
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $config = $this->config($resource);
        $data = $this->validated($request, $resource);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('rental', 'public');
        }

        $config['model']::create($data);

        return redirect()->route('admin.content.index', $resource)->with('success', $config['title'].' berhasil ditambahkan.');
    }

    public function edit(string $resource, int $id): View
    {
        $config = $this->config($resource);

        return view('admin.content.form', [
            'resource' => $resource,
            'config' => $config,
            'record' => $config['model']::findOrFail($id),
            'rentalServices' => $this->rentalServices($resource),
        ]);
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $config = $this->config($resource);
        $record = $config['model']::findOrFail($id);
        $data = $this->validated($request, $resource);

        if ($request->hasFile('photo')) {
            if ($record->photo) {
                Storage::disk('public')->delete($record->photo);
            }

            $data['photo'] = $request->file('photo')->store('rental', 'public');
        }

        $record->update($data);

        return redirect()->route('admin.content.index', $resource)->with('success', $config['title'].' berhasil diperbarui.');
    }

    public function destroy(string $resource, int $id): RedirectResponse
    {
        $config = $this->config($resource);
        $record = $config['model']::findOrFail($id);

        if ($record->photo) {
            Storage::disk('public')->delete($record->photo);
        }

        $record->delete();

        return back()->with('success', $config['title'].' berhasil dihapus.');
    }

    public function settings(): View
    {
        return view('admin.content.settings', ['settings' => SiteSetting::query()->pluck('value', 'key')]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'footer_tagline' => ['nullable', 'string'],
            'hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_note' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'whatsapp_number' => ['nullable', 'string'],
            'whatsapp_template' => ['nullable', 'string'],
            'operating_hours' => ['nullable', 'string'],
            'map_embed' => ['nullable', 'string'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function config(string $resource): array
    {
        abort_unless(isset(self::RESOURCES[$resource]), 404);

        return self::RESOURCES[$resource];
    }

    private function validated(Request $request, string $resource): array
    {
        $rules = match ($resource) {
            'rental-items' => ['service_id' => ['required', 'exists:services,id'], 'category' => ['nullable', Rule::in(array_keys(config('rental.categories')))], 'name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string'], 'photo' => ['nullable', 'image', 'max:2048'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']],
            'services' => ['category' => ['required', 'in:pelatihan,workshop,seminar,penyewaan'], 'name' => ['required', 'string', 'max:255'], 'slug' => ['required', 'string', 'max:255'], 'description' => ['required', 'string'], 'features' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']],
            'collaborations' => ['partner_name' => ['required', 'string'], 'event_name' => ['required', 'string'], 'slug' => ['required', 'string'], 'event_date' => ['required', 'date'], 'service_category' => ['nullable', 'string'], 'description' => ['nullable', 'string'], 'is_active' => ['nullable', 'boolean']],
            'testimonials' => ['name' => ['required', 'string'], 'organization' => ['nullable', 'string'], 'comment' => ['required', 'string'], 'rating' => ['nullable', 'integer', 'between:1,5'], 'is_active' => ['nullable', 'boolean']],
            default => ['platform' => ['required', 'string'], 'url' => ['required', 'url'], 'icon' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']],
        };
        $data = $request->validate($rules);
        if ($resource === 'services') {
            $data['features'] = $data['features'] ? array_values(array_filter(array_map('trim', explode("\n", $data['features'])))) : [];
        }
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function rentalServices(string $resource)
    {
        if ($resource !== 'rental-items') {
            return collect();
        }

        return Service::query()
            ->where('category', 'penyewaan')
            ->orderBy('sort_order')
            ->get();
    }
}
