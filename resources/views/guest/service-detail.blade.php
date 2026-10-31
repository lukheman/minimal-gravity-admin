<x-layouts.public :title="$service->name.' — '.($settings['site_name'] ?? 'Nusa Event')" :settings="$settings">
    <section class="hero">
        <div class="container">
            <div class="eyebrow">{{ ucfirst($service->category) }}</div>
            <h1 class="display-4 mt-2">{{ $service->name }}</h1>
            <p class="lead text-secondary mt-3">{{ $service->description }}</p>
            <a class="btn btn-main mt-3" target="_blank" rel="noopener" href="{{ \App\Support\SiteContent::whatsappUrl($settings, 'Halo, saya ingin bertanya tentang '.$service->name.' untuk acara saya.') }}">
                <i class="fa-brands fa-whatsapp me-1"></i> Tanya layanan ini
            </a>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="display-6 mb-3">Yang Anda dapatkan</h2>
            <div class="row g-3">
                @foreach ($service->features ?? [] as $feature)
                    <div class="col-md-6">
                        <div class="card-clean p-3"><i class="fa-solid fa-check me-2" style="color: var(--teal)"></i>{{ $feature }}</div>
                    </div>
                @endforeach
            </div>

            @if ($service->rentalItems->isNotEmpty())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mt-5 mb-3">
                    <div>
                        <div class="eyebrow">Katalog</div>
                        <h2 class="display-6 mt-2 mb-0">Item yang bisa disewa</h2>
                    </div>
                    <span class="text-secondary">Harga menyesuaikan item dan durasi sewa.</span>
                </div>

                <div class="row g-4">
                    @foreach ($service->rentalItems as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-clean p-3 h-100 d-flex flex-column">
                                <div class="media-frame mb-3">
                                    @if ($item->photoUrl())
                                        <img src="{{ $item->photoUrl() }}" alt="Foto {{ $item->name }}" loading="lazy">
                                    @else
                                        <i class="{{ $item->categoryIcon() }}"></i>
                                    @endif
                                </div>
                                <span class="eyebrow mb-1">{{ $item->categoryLabel() }}</span>
                                <h3 class="h5">{{ $item->name }}</h3>
                                <p class="text-secondary small mb-3">{{ $item->description }}</p>
                                <a class="btn btn-ghost btn-sm mt-auto align-self-start" target="_blank" rel="noopener" href="{{ \App\Support\SiteContent::whatsappUrl($settings, 'Halo, saya ingin menyewa '.$item->name.' untuk acara saya. Mohon info ketersediaan dan harganya.') }}">
                                    <i class="fa-brands fa-whatsapp me-1"></i> Tanya ketersediaan
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
