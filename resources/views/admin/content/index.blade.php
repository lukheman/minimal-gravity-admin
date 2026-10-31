<x-layouts.app :title="$config['title'].' - Admin'">
    <x-layout.page-header :title="$config['title']" subtitle="Kelola konten website. Perubahan langsung tampil di halaman publik.">
        <x-slot:actions>
            <a class="btn btn-primary" href="{{ route('admin.content.create', $resource) }}">
                <i class="fas fa-plus me-2"></i>Tambah
            </a>
        </x-slot:actions>
    </x-layout.page-header>

    <x-layout.modern-card>
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>
                                <strong>{{ $record->name ?? $record->event_name ?? $record->platform }}</strong>
                                @if ($resource === 'rental-items')
                                    <br><small class="text-muted">{{ $record->categoryLabel() }}</small>
                                @endif
                            </td>
                            <td class="text-muted">
                                {{ $record->organization ?? $record->partner_name ?? $record->url ?? Str::limit($record->description ?? '', 70) }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $record->is_active ? 'success' : 'secondary' }}">
                                    {{ $record->is_active ? 'Tampil' : 'Sembunyi' }}
                                </span>
                            </td>
                            <td>{{ $record->created_at->format('d M Y') }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.content.edit', [$resource, $record->id]) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.content.destroy', [$resource, $record->id]) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $records->links() }}
    </x-layout.modern-card>
</x-layouts.app>
