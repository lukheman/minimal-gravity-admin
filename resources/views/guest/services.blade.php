<x-layouts.public :title="'Layanan & Sewa Alat — '.($settings['site_name'] ?? 'Nusa Event')" :settings="$settings">
    <section class="hero">
        <div class="container">
            <div class="eyebrow">Layanan</div>
            <h1 class="display-4 mt-2">Sewa alat event dan layanan pendukung acara.</h1>
            <p class="lead text-secondary mt-3">Fokus kami adalah penyewaan perlengkapan acara. Kami juga membantu pelatihan, workshop, dan seminar bila dibutuhkan.</p>
            <a class="btn btn-main mt-3" href="{{ route('home') }}#katalog">
                <i class="fa-solid fa-box-open me-1"></i> Lihat katalog sewa
            </a>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-6">
                        <a href="{{ route('services.show', $service) }}" class="card-clean p-4 d-flex flex-column text-decoration-none text-dark h-100">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div class="icon-box mb-3">
                                    <i class="fa-solid {{ $service->category === 'penyewaan' ? 'fa-box-open' : 'fa-calendar-check' }}"></i>
                                </div>
                                @if ($service->category === 'penyewaan')
                                    <span class="badge rounded-pill" style="background: var(--mint); color: var(--teal);">Fokus kami</span>
                                @endif
                            </div>
                            <div class="eyebrow">{{ ucfirst($service->category) }}</div>
                            <h2 class="h4 mt-2">{{ $service->name }}</h2>
                            <p class="text-secondary">{{ $service->description }}</p>
                            @if (! empty($service->features))
                                <ul class="list-unstyled small text-secondary mb-3">
                                    @foreach ($service->features as $feature)
                                        <li class="mb-1"><i class="fa-solid fa-check me-2" style="color: var(--teal)"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <span class="text-link mt-auto">Lihat detail <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
