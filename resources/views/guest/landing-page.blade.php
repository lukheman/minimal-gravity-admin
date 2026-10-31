@php
    $heroEyebrow = $settings['hero_eyebrow'] ?? 'Penyewaan alat event';
    $heroTitle = $settings['hero_title'] ?? 'Sewa perlengkapan acara, lengkap dan siap pakai.';
    $heroSubtitle = $settings['hero_subtitle'] ?? 'Tenda, sound system, lighting, kursi, panggung, hingga genset. Cek ketersediaan dan pesan langsung via WhatsApp.';
    $waUrl = \App\Support\SiteContent::whatsappUrl($settings);
    $featuredItems = $rentalItems->take(3);
    $categoryLabels = config('rental.categories');
@endphp

<x-layouts.public
    :title="($settings['site_name'] ?? 'Nusa Event').' — Sewa Alat Event'"
    description="Sewa tenda, sound system, lighting, kursi, panggung, dan genset untuk acara Anda. Cek ketersediaan dan pesan via WhatsApp."
    :settings="$settings"
>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="eyebrow d-inline-block mb-3">{{ $heroEyebrow }}</span>
                    <h1 class="display-3 mb-3">{{ $heroTitle }}</h1>
                    <p class="lead text-secondary mb-4">{{ $heroSubtitle }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a class="btn btn-main" href="#katalog">
                            <i class="fa-solid fa-box-open me-1"></i> Lihat katalog sewa
                        </a>
                        <a class="btn btn-ghost" href="{{ $waUrl }}" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp me-1"></i> Cek ketersediaan
                        </a>
                    </div>

                    <p class="small text-secondary mb-4">
                        <i class="fa-solid fa-circle-check me-1" style="color: var(--teal)"></i>
                        {{ $settings['hero_note'] ?? 'Antar, pasang, dan penarikan oleh tim kami.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-4">
                        <div>
                            <div class="stat-value">{{ $stats['rental_items'] }}</div>
                            <div class="small text-secondary">Item siap sewa</div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['rental_categories'] }}</div>
                            <div class="small text-secondary">Kategori alat</div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['collaborations'] }}</div>
                            <div class="small text-secondary">Acara didukung</div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['partners'] }}</div>
                            <div class="small text-secondary">Mitra kerja sama</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card-clean p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="eyebrow">Stok siap sewa</span>
                                <h2 class="h5 mt-1 mb-0">Perlengkapan yang sering dipesan</h2>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--mint); color: var(--teal)">
                                {{ $stats['rental_items'] }} item
                            </span>
                        </div>

                        @forelse ($featuredItems as $item)
                            <a class="d-flex align-items-center gap-3 py-3 text-decoration-none text-dark {{ ! $loop->last ? 'border-bottom' : '' }}" href="{{ \App\Support\SiteContent::whatsappUrl($settings, 'Halo, saya ingin menyewa '.$item->name.' untuk acara saya. Mohon info ketersediaan dan harganya.') }}" target="_blank" rel="noopener">
                                <div class="rental-thumb">
                                    @if ($item->photoUrl())
                                        <img src="{{ $item->photoUrl() }}" alt="{{ $item->name }}" loading="lazy">
                                    @else
                                        <i class="{{ $item->categoryIcon() }}"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $item->name }}</div>
                                    <div class="small text-secondary">{{ $item->categoryLabel() }}</div>
                                </div>
                                <i class="fa-brands fa-whatsapp" style="color: var(--teal)"></i>
                            </a>
                        @empty
                            <p class="text-secondary mb-0">Katalog sedang diperbarui. Hubungi kami untuk kebutuhan alat acara Anda.</p>
                        @endforelse

                        <a class="text-link d-inline-block mt-3" href="#katalog">Lihat semua item <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="katalog">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Katalog sewa</span>
                    <h2 class="display-6 mt-2 mb-2">Pilih alat, cek jadwal, kami antar.</h2>
                    <p class="text-secondary mb-0">Semua item dirawat dan diperiksa sebelum dikirim ke lokasi acara.</p>
                </div>
                <a class="btn btn-main text-nowrap" href="{{ $waUrl }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp me-1"></i> Tanya stok
                </a>
            </div>

            @if ($rentalItems->isNotEmpty())
                <div class="d-flex flex-wrap gap-2 mb-4" role="group" aria-label="Filter kategori alat">
                    <button type="button" class="filter-chip active" data-filter="all">Semua</button>
                    @foreach ($rentalCategories as $category)
                        <button type="button" class="filter-chip" data-filter="{{ $category }}">{{ $categoryLabels[$category] ?? 'Lainnya' }}</button>
                    @endforeach
                </div>

                <div class="row g-4">
                    @foreach ($rentalItems as $item)
                        <div class="col-md-6 col-lg-4" data-category="{{ $item->category }}">
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
            @else
                <div class="card-clean p-5 text-center">
                    <i class="fa-solid fa-box-open mb-3" style="font-size: 2rem; color: var(--teal)"></i>
                    <h3 class="h5">Katalog sedang disiapkan</h3>
                    <p class="text-secondary mb-3">Sampaikan kebutuhan alat acara Anda, kami bantu cek ketersediaannya.</p>
                    <a class="btn btn-main" href="{{ $waUrl }}" target="_blank" rel="noopener">Hubungi via WhatsApp</a>
                </div>
            @endif
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-4">
                    <span class="eyebrow">Kenapa sewa di kami</span>
                    <h2 class="display-6 mt-2">Fokus acara Anda, alat kami yang urus.</h2>
                    <p class="text-secondary">Tidak perlu membeli dan menyimpan perlengkapan sendiri. Sewa sesuai kebutuhan dan durasi acara.</p>
                    <a class="btn btn-main mt-2" href="{{ $waUrl }}" target="_blank" rel="noopener">Konsultasi kebutuhan alat</a>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        @foreach ([
                            ['icon' => 'fa-screwdriver-wrench', 'title' => 'Stok terawat', 'text' => 'Perlengkapan diperiksa sebelum digunakan.'],
                            ['icon' => 'fa-truck-fast', 'title' => 'Antar & pasang', 'text' => 'Tim membantu pengiriman, pemasangan, dan penarikan.'],
                            ['icon' => 'fa-calendar-days', 'title' => 'Fleksibel', 'text' => 'Sewa harian atau sesuai durasi acara Anda.'],
                            ['icon' => 'fa-headset', 'title' => 'Pendampingan', 'text' => 'Butuh bantuan teknis? Tim kami siap di lokasi.'],
                        ] as $value)
                            <div class="col-sm-6">
                                <div class="card-clean p-4 h-100">
                                    <div class="icon-box mb-3"><i class="fa-solid {{ $value['icon'] }}"></i></div>
                                    <h3 class="h6">{{ $value['title'] }}</h3>
                                    <p class="text-secondary small mb-0">{{ $value['text'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head mb-4">
                <span class="eyebrow">Cara sewa</span>
                <h2 class="display-6 mt-2 mb-2">Empat langkah, alat siap di lokasi.</h2>
            </div>
            <div class="row g-3">
                @foreach ([
                    ['number' => '01', 'title' => 'Pilih alat', 'text' => 'Lihat katalog atau sampaikan kebutuhan acara Anda.'],
                    ['number' => '02', 'title' => 'Cek jadwal', 'text' => 'Kami konfirmasi ketersediaan item pada tanggal acara.'],
                    ['number' => '03', 'title' => 'Konfirmasi', 'text' => 'Sepakati item, durasi, lokasi, dan biaya sewa.'],
                    ['number' => '04', 'title' => 'Antar & pasang', 'text' => 'Tim mengirim, memasang, lalu menarik kembali setelah acara.'],
                ] as $step)
                    <div class="col-sm-6 col-lg-3">
                        <div class="card-clean p-4 h-100">
                            <div class="step-number mb-3">{{ $step['number'] }}</div>
                            <h3 class="h6">{{ $step['title'] }}</h3>
                            <p class="text-secondary small mb-0">{{ $step['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($services->isNotEmpty())
        <section class="section section-soft">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div class="section-head">
                        <span class="eyebrow">Layanan pendukung</span>
                        <h2 class="display-6 mt-2 mb-2">Butuh pelatihan, workshop, atau seminar?</h2>
                        <p class="text-secondary mb-0">Selain penyewaan alat, kami juga membantu penyelenggaraan acara.</p>
                    </div>
                    <a class="text-link text-nowrap" href="{{ route('services') }}">Lihat layanan <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
                <div class="row g-4">
                    @foreach ($services->take(3) as $service)
                        <div class="col-md-4">
                            <a class="card-clean p-4 d-flex flex-column text-decoration-none text-dark h-100" href="{{ route('services.show', $service) }}">
                                <div class="icon-box mb-3"><i class="fa-solid fa-calendar-check"></i></div>
                                <span class="eyebrow mb-1">{{ ucfirst($service->category) }}</span>
                                <h3 class="h5">{{ $service->name }}</h3>
                                <p class="text-secondary small mb-3">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                                <span class="text-link mt-auto">Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Rekam jejak</span>
                    <h2 class="display-6 mt-2 mb-2">Alat kami sudah mendukung berbagai acara</h2>
                    <p class="text-secondary mb-0">Sebagian kegiatan yang menggunakan layanan dan perlengkapan kami.</p>
                </div>
                <a class="text-link text-nowrap" href="{{ route('collaborations') }}">Lihat semua kerja sama <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                @forelse ($collaborations as $collaboration)
                    <div class="col-md-6 col-lg-4">
                        <a class="card-clean p-3 d-flex flex-column text-decoration-none text-dark" href="{{ route('collaborations.show', $collaboration) }}">
                            <div class="media-frame mb-3 position-relative">
                                @if ($collaboration->coverUrl())
                                    <img src="{{ $collaboration->coverUrl() }}" alt="Foto kegiatan {{ $collaboration->event_name }}" loading="lazy">
                                @else
                                    <i class="fa-solid fa-camera-retro"></i>
                                @endif
                                <span class="badge rounded-pill position-absolute top-0 start-0 m-2 px-2 py-1" style="background: rgba(16, 42, 43, .8);">
                                    {{ $collaboration->event_date->format('d M Y') }}
                                </span>
                            </div>
                            <span class="eyebrow mb-1">{{ $collaboration->partner_name }}</span>
                            <h3 class="h5">{{ $collaboration->event_name }}</h3>
                            <p class="text-secondary small mb-3">{{ \Illuminate\Support\Str::limit($collaboration->description, 95) }}</p>
                            <span class="text-link mt-auto">Lihat galeri <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card-clean p-5 text-center">
                            <i class="fa-solid fa-handshake-angle mb-3" style="font-size: 2rem; color: var(--teal)"></i>
                            <h3 class="h5">Portofolio sedang kami siapkan</h3>
                            <p class="text-secondary mb-0">Hubungi kami untuk mengetahui kegiatan yang pernah kami tangani.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Testimoni</span>
                    <h2 class="display-6 mt-2 mb-2">Kata mereka yang sudah menyewa</h2>
                    <p class="text-secondary mb-0">Pengalaman mitra menjadi bagian penting dari cara kami bekerja.</p>
                </div>
                <a class="text-link text-nowrap" href="{{ route('testimonials') }}">Lihat semua testimoni <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                @forelse ($testimonials as $testimonial)
                    <div class="col-md-4">
                        <div class="card-clean p-4 h-100 d-flex flex-column">
                            <div class="mb-3" style="color: var(--gold);">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= ($testimonial->rating ?? 5) ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="flex-grow-1">“{{ $testimonial->comment }}”</p>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                @if ($testimonial->photoUrl())
                                    <img src="{{ $testimonial->photoUrl() }}" alt="Foto {{ $testimonial->name }}" width="42" height="42" class="rounded-circle" style="object-fit: cover;" loading="lazy">
                                @else
                                    <div class="rounded-circle" style="width: 42px; height: 42px; background: var(--mint); color: var(--teal); display: grid; place-items: center; font-weight: 700;">
                                        {{ $testimonial->initials() }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $testimonial->name }}</div>
                                    <div class="small text-secondary">{{ $testimonial->organization }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card-clean p-5 text-center">
                            <i class="fa-solid fa-quote-left mb-3" style="font-size: 2rem; color: var(--teal)"></i>
                            <h3 class="h5">Jadilah mitra berikutnya</h3>
                            <p class="text-secondary mb-0">Kami siap membantu kebutuhan alat acara Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-band p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="eyebrow" style="color: #f3c77e">Cek ketersediaan</span>
                        <h2 class="display-6 text-white mt-2 mb-2">Butuh alat untuk acara minggu ini?</h2>
                        <p class="mb-0 text-white-50">Kirim daftar kebutuhan dan tanggal acara. Kami bantu cek stok serta jadwal pengiriman.</p>
                    </div>
                    <div class="col-lg-4 d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                        <a class="btn btn-light" href="{{ $waUrl }}" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp me-1"></i> Chat via WhatsApp
                        </a>
                        <a class="btn btn-outline-light" href="{{ route('contact') }}">Lihat kontak</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .rental-thumb {
                width: 3.2rem;
                height: 3.2rem;
                border-radius: .9rem;
                background: var(--mint);
                color: var(--teal);
                display: grid;
                place-items: center;
                overflow: hidden;
                flex-shrink: 0;
            }

            .rental-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .filter-chip {
                border: 1px solid var(--line);
                background: #fff;
                color: var(--ink);
                border-radius: 999px;
                padding: .5rem 1rem;
                font-size: .875rem;
                font-weight: 600;
            }

            .filter-chip:hover,
            .filter-chip.active {
                background: var(--teal);
                border-color: var(--teal);
                color: #fff;
            }

            .step-number {
                font-family: 'Archivo', sans-serif;
                font-weight: 900;
                color: var(--gold);
                font-size: 1.75rem;
                line-height: 1;
                letter-spacing: -.03em;
            }

            .cta-band {
                background: linear-gradient(120deg, var(--teal), #123f3d);
                border-radius: 1.5rem;
                position: relative;
                overflow: hidden;
            }

            .cta-band::after {
                content: '';
                position: absolute;
                width: 18rem;
                height: 18rem;
                border-radius: 50%;
                right: -6rem;
                top: -6rem;
                background: rgba(217, 155, 75, .18);
            }

            .cta-band .btn {
                border-radius: 999px;
                font-weight: 600;
                padding: .7rem 1.2rem;
            }

            .cta-band .btn-outline-light:hover {
                color: var(--ink);
                background: #fff;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.querySelectorAll('.filter-chip').forEach(function (button) {
                button.addEventListener('click', function () {
                    var filter = button.dataset.filter;

                    document.querySelectorAll('[data-category]').forEach(function (card) {
                        card.classList.toggle('d-none', filter !== 'all' && card.dataset.category !== filter);
                    });

                    document.querySelectorAll('.filter-chip').forEach(function (chip) {
                        chip.classList.toggle('active', chip === button);
                    });
                });
            });
        </script>
    @endpush
</x-layouts.public>
