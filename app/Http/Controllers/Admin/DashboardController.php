<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use App\Models\RentalItem;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'rental_items' => RentalItem::query()->count(),
                'active_rental_items' => RentalItem::query()->where('is_active', true)->count(),
                'collaborations' => Collaboration::query()->count(),
                'testimonials' => Testimonial::query()->count(),
            ],
            'recentItems' => RentalItem::query()->latest()->limit(5)->get(),
        ]);
    }
}
