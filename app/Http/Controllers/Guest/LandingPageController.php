<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use App\Models\RentalItem;
use App\Models\Service;
use App\Models\Testimonial;
use App\Support\SiteContent;

class LandingPageController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function __invoke()
    {
        $collaborations = Collaboration::query()
            ->where('is_active', true)
            ->with('photos')
            ->latest('event_date')
            ->limit(3)
            ->get();

        $rentalItems = RentalItem::query()
            ->where('is_active', true)
            ->whereHas('service', fn ($query) => $query->where('category', 'penyewaan')->where('is_active', true))
            ->orderBy('sort_order')
            ->get();

        return view('guest.landing-page', [
            'rentalItems' => $rentalItems,
            'rentalCategories' => $rentalItems->pluck('category')->filter()->unique()->values(),
            'services' => Service::query()->where('is_active', true)->where('category', '!=', 'penyewaan')->orderBy('sort_order')->get(),
            'collaborations' => $collaborations,
            'testimonials' => Testimonial::query()->where('is_active', true)->latest()->limit(3)->get(),
            'stats' => [
                'rental_items' => $rentalItems->count(),
                'rental_categories' => $rentalItems->pluck('category')->filter()->unique()->count(),
                'collaborations' => Collaboration::query()->where('is_active', true)->count(),
                'partners' => Collaboration::query()->where('is_active', true)->distinct()->count('partner_name'),
            ],
            'settings' => SiteContent::settings(),
        ]);
    }
}
