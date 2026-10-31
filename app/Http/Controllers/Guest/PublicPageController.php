<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\Testimonial;
use App\Support\SiteContent;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function about(): View
    {
        return view('guest.about', ['settings' => SiteContent::settings()]);
    }

    public function services(): View
    {
        return view('guest.services', [
            'services' => Service::query()
                ->where('is_active', true)
                ->orderByRaw("CASE WHEN category = 'penyewaan' THEN 0 ELSE 1 END")
                ->orderBy('sort_order')
                ->get(),
            'settings' => SiteContent::settings(),
        ]);
    }

    public function service(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('guest.service-detail', [
            'service' => $service->load(['rentalItems' => fn ($query) => $query->where('is_active', true)]),
            'settings' => SiteContent::settings(),
        ]);
    }

    public function collaborations(): View
    {
        return view('guest.collaborations', ['collaborations' => Collaboration::query()->where('is_active', true)->with('photos')->latest('event_date')->get(), 'settings' => SiteContent::settings()]);
    }

    public function collaboration(Collaboration $collaboration): View
    {
        abort_unless($collaboration->is_active, 404);

        return view('guest.collaboration-detail', ['collaboration' => $collaboration->load('photos'), 'settings' => SiteContent::settings()]);
    }

    public function testimonials(): View
    {
        return view('guest.testimonials', ['testimonials' => Testimonial::query()->where('is_active', true)->latest()->get(), 'settings' => SiteContent::settings()]);
    }

    public function contact(): View
    {
        return view('guest.contact', ['socialLinks' => SocialLink::query()->where('is_active', true)->orderBy('sort_order')->get(), 'settings' => SiteContent::settings()]);
    }
}
