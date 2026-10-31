@php
    $heroEyebrow = $settings['hero_eyebrow'] ?? 'Event organizer untuk momen penting';
    $heroTitle = $settings['hero_title'] ?? 'Membuat momen penting terasa lebih berarti.';
    $heroSubtitle = $settings['hero_subtitle'] ?? 'Kami merancang dan menyelenggarakan acara yang rapi, hangat, dan meninggalkan kesan — dari pelatihan hingga penyewaan perlengkapan.';
    $waUrl = \App\Support\SiteContent::whatsappUrl($settings);
    $featured = $collaborations->first();
    $categoryIcons = [
        'pelatihan' => 'fa-solid fa-chalkboard-user',
        'workshop' => 'fa-solid fa-screwdriver-wrench',
        'seminar' => 'fa-solid fa-microphone-lines',
        'penyewaan' => 'fa-solid fa-box-open',
    ];
@endphp

<x-layouts.public :title="($settings['site_name'] ?? 'Nusa Event Organizer').' — Wujudkan Acara Berkesan'" :settings="$settings">
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="eyebrow d-inline-block mb-3">{{ $heroEyebrow }}</span>
                    <h1 class="display-3 mb-3">{{ $heroTitle }}</h1>
                    <p class="lead text-secondary mb-4">{{ $heroSubtitle }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a class="btn btn-main" href="{{ $waUrl }}" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp me-1"></i> Konsultasi via WhatsApp
                        </a>
                        <a class="btn btn-ghost" href="{{ route('services') }}">Lihat layanan</a>
                    </div>

                    <p class="small text-secondary mb-3">
                        <i class="fa-solid fa-circle-check me-1" style="color: var(--teal)"></i>
                        {{ $settings['hero_note'] ?? 'Dipercaya instansi, sekolah, perusahaan, dan komunitas.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-4 pt-2">
                        <div>
                            <div class="stat-value">{{ $stats['collaborations'] }}</div>
                            <div class="small text-secondary">Kegiatan terlaksana</div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['partners'] }}</div>
                            <div class="small text-secondary">Mitra kerja sama</div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['services'] }}</div>
                            <div class="small text-secondary">Layanan tersedia</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    @if ($featured)
                        <div class="card-clean p-3 p-md-4">
                            <div class="media-frame mb-3">
                                @if ($featured->coverUrl())
                                    <img src="{{ $featured->coverUrl() }}" alt="Foto kegiatan {{ $featured->event_name }}" loading="lazy">
                                @else
                                    <i class="fa-solid fa-images"></i>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <span class="eyebrow">Sorotan acara</span>
                                    <h2 class="h4 mt-1 mb-1">{{ $featured->event_name }}</h2>
                                    <div class="text-secondary small">{{ $featured->partner_name }}</div>
                                </div>
                                <span class="badge rounded-pill px-3 py-2" style="background: var(--mint); color: var(--teal)">
                                    {{ $featured->event_date->format('Y') }}
                                </span>
                            </div>
                            <p class="text-secondary small mt-3 mb-3">{{ \Illuminate\Support\Str::limit($featured->description, 110) }}</p>
                            <a class="text-link" href="{{ route('collaborations.show', $featured) }}">
                                Lihat cerita kegiatan <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @else
                        <div class="card-clean p-4 p-md-5" style="background: var(--teal); color: #fff;">
                            <span class="eyebrow" style="color: #f3c77e">Sejak awal</span>
                            <h2 class="mt-3">Satu partner untuk seluruh kebutuhan acara.</h2>
                            <p class="mb-0 opacity-75">Pelatihan, workshop, seminar, dan penyewaan perlengkapan — dikelola dalam satu alur kerja yang jelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="layanan">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Yang kami kerjakan</span>
                    <h2 class="display-6 mt-2 mb-2">Layanan untuk setiap kebutuhan acara</h2>
                    <p class="text-secondary mb-0">Mulai dari peningkatan kapasitas tim hingga penyewaan perlengkapan.</p>
                </div>
                <a class="text-link text-nowrap" href="{{ route('services') }}">Lihat semua layanan <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                @forelse ($services as $service)
                    <div class="col-md-6 col-lg-3">
                        <a class="card-clean p-4 d-flex flex-column text-decoration-none text-dark" href="{{ route('services.show', $service) }}">
                            <div class="icon-box mb-3">
                                <i class="{{ $categoryIcons[$service->category] ?? 'fa-solid fa-calendar-check' }}"></i>
                            </div>
                            <span class="eyebrow mb-2">{{ ucfirst($service->category) }}</span>
                            <h3 class="h5">{{ $service->name }}</h3>
                            <p class="text-secondary small mb-3">{{ \Illuminate\Support\Str::limit($service->description, 90) }}</p>

                            @if (! empty($service->features))
                                <ul class="list-unstyled small text-secondary mb-3">
                                    @foreach (array_slice($service->features, 0, 2) as $feature)
                                        <li class="mb-1"><i class="fa-solid fa-check me-2" style="color: var(--teal)"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <span class="text-link mt-auto">Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </a>
                    </div>
                @empty
                    @foreach (['Pelatihan', 'Workshop', 'Seminar', 'Penyewaan'] as $name)
                        <div class="col-md-6 col-lg-3">
                            <div class="card-clean p-4">
                                <div class="icon-box mb-3"><i class="fa-solid fa-calendar-check"></i></div>
                                <h3 class="h5">{{ $name }}</h3>
                                <p class="text-secondary small mb-0">Layanan profesional untuk acara yang berdampak.</p>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-4">
                    <span class="eyebrow">Cara kami bekerja</span>
                    <h2 class="display-6 mt-2">Proses jelas, Anda tetap tenang.</h2>
                    <p class="text-secondary">Kami menjaga komunikasi dan detail agar setiap tahap acara berjalan sesuai rencana.</p>
                    <a class="btn btn-main mt-2" href="{{ $waUrl }}" target="_blank" rel="noopener">Mulai konsultasi</a>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        @foreach ([
                            ['icon' => 'fa-comments', 'title' => 'Konsultasi kebutuhan', 'text' => 'Ceritakan tujuan, peserta, dan anggaran acara Anda.'],
                            ['icon' => 'fa-list-check', 'title' => 'Rencana yang matang', 'text' => 'Kami susun konsep, rundown, dan kebutuhan teknis secara terperinci.'],
                            ['icon' => 'fa-calendar-check', 'title' => 'Eksekusi di hari-H', 'text' => 'Tim hadir memastikan acara berjalan rapi dari awal hingga selesai.'],
                        ] as $step)
                            <div class="col-md-4">
                                <div class="card-clean p-4 h-100">
                                    <div class="icon-box mb-3"><i class="fa-solid {{ $step['icon'] }}"></i></div>
                                    <h3 class="h6">{{ $step['title'] }}</h3>
                                    <p class="text-secondary small mb-0">{{ $step['text'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="kerja-sama">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Rekam jejak</span>
                    <h2 class="display-6 mt-2 mb-2">Kerja sama yang sudah berjalan</h2>
                    <p class="text-secondary mb-0">Lihat kegiatan yang telah kami selenggarakan bersama mitra.</p>
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

    <section class="section section-soft" id="testimoni">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div class="section-head">
                    <span class="eyebrow">Testimoni</span>
                    <h2 class="display-6 mt-2 mb-2">Kata mereka yang sudah bekerja bersama kami</h2>
                    <p class="text-secondary mb-0">Pengalaman mitra adalah bagian penting dari cara kami bekerja.</p>
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
                                    <div class="rounded-circle d-grid place-items-center" style="width: 42px; height: 42px; background: var(--mint); color: var(--teal); display: grid; place-items: center; font-weight: 700;">
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
                            <p class="text-secondary mb-0">Kami siap membantu merencanakan acara Anda.</p>
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
                        <span class="eyebrow" style="color: #f3c77e">Langkah berikutnya</span>
                        <h2 class="display-6 text-white mt-2 mb-2">Siap merencanakan acara Anda?</h2>
                        <p class="mb-0 text-white-50">Ceritakan kebutuhan Anda. Kami akan membantu menyusun rencana yang sesuai.</p>
                    </div>
                    <div class="col-lg-4 d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                        <a class="btn btn-light" href="{{ $waUrl }}" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp me-1"></i> Konsultasi via WhatsApp
                        </a>
                        <a class="btn btn-outline-light" href="{{ route('contact') }}">Lihat kontak</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
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
</x-layouts.public>
