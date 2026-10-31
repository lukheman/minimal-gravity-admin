<x-layouts.app title="Dashboard - Admin">
    <x-layout.page-header title="Dashboard Overview" subtitle="Ringkasan katalog sewa dan konten website.">
        <x-slot:actions>
            <a class="btn btn-primary" href="{{ route('admin.content.create', 'rental-items') }}">
                <i class="fas fa-plus me-2"></i>Tambah Item Sewa
            </a>
        </x-slot:actions>
    </x-layout.page-header>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <x-layout.stat-card icon="fas fa-box-open" label="Total Item Sewa" :value="$stats['rental_items']" variant="primary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-layout.stat-card icon="fas fa-eye" label="Item Tampil" :value="$stats['active_rental_items']" variant="success" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-layout.stat-card icon="fas fa-handshake" label="Kerja Sama" :value="$stats['collaborations']" variant="secondary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-layout.stat-card icon="fas fa-quote-left" label="Testimoni" :value="$stats['testimonials']" variant="warning" />
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <x-layout.modern-card>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Item sewa terbaru</h2>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.content.index', 'rental-items') }}">Kelola katalog</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Nama Item</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Urutan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentItems as $item)
                                <tr>
                                    <td><strong>{{ $item->name }}</strong></td>
                                    <td class="text-muted">{{ $item->categoryLabel() }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                            {{ $item->is_active ? 'Tampil' : 'Sembunyi' }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $item->sort_order }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada item sewa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-layout.modern-card>
        </div>

        <div class="col-lg-4">
            <x-layout.modern-card>
                <h2 class="h5 mb-3">Akses cepat</h2>
                <div class="d-flex flex-column gap-2">
                    <a class="btn btn-outline-primary text-start" href="{{ route('admin.content.index', 'rental-items') }}"><i class="fas fa-box-open me-2"></i>Katalog sewa</a>
                    <a class="btn btn-outline-primary text-start" href="{{ route('admin.content.index', 'collaborations') }}"><i class="fas fa-handshake me-2"></i>Kerja sama</a>
                    <a class="btn btn-outline-primary text-start" href="{{ route('admin.content.index', 'testimonials') }}"><i class="fas fa-quote-left me-2"></i>Testimoni</a>
                    <a class="btn btn-outline-primary text-start" href="{{ route('admin.settings') }}"><i class="fas fa-sliders me-2"></i>Profil & kontak</a>
                    <a class="btn btn-outline-secondary text-start" href="{{ route('home') }}" target="_blank"><i class="fas fa-arrow-up-right-from-square me-2"></i>Lihat website</a>
                </div>
            </x-layout.modern-card>
        </div>
    </div>
</x-layouts.app>
