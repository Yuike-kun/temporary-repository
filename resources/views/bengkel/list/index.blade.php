<x-layout.dashboard-admin>
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Daftar List Bengkel</h6>
                <a href="{{ route('bengkel.list.create') }}" class="btn btn-light btn-sm text-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Bengkel
                </a>
            </div>

            <div class="card-body">
                <div id="searchTable">
                    <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                        <div class="gridjs-head">
                            <div class="gridjs-search">
                                <input type="search" placeholder="Cari bengkel..." aria-label="Cari bengkel..."
                                    class="gridjs-input gridjs-search-input form-control" onkeyup="filterTable(this.value)">
                            </div>
                        </div>

                        <div class="gridjs-wrapper" style="height: auto;">
                            <table role="grid" class="gridjs-table text-nowrap table table-hover align-middle">
                                <thead class="gridjs-thead bg-light">
                                    <tr class="gridjs-tr">
                                        <th class="gridjs-th">#</th>
                                        <th class="gridjs-th">Nama Bengkel</th>
                                        <th class="gridjs-th">Pemilik</th>
                                        <th class="gridjs-th">Alamat</th>
                                        <th class="gridjs-th">Telepon</th>
                                        <th class="gridjs-th">Jam Operasional</th>
                                        <th class="gridjs-th">Status</th>
                                        <th class="gridjs-th text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="gridjs-tbody" id="adminTableBody">
                                    @forelse ($bengkels as $b)
                                        <tr class="gridjs-tr">
                                            <td class="gridjs-td">{{ $loop->iteration }}</td>
                                            <td class="gridjs-td">{{ $b->name }}</td>
                                            <td class="gridjs-td">{{ $b->user->name ?? '-' }}</td>
                                            <td class="gridjs-td">{{ Str::limit($b->address, 30) }}</td>
                                            <td class="gridjs-td">{{ $b->phone ?? '-' }}</td>
                                            <td class="gridjs-td">{{ $b->open_time->format('H:i') }} - {{ $b->close_time->format('H:i') }}</td>
                                            <td class="gridjs-td">
                                                @if ($b->is_verified)
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                                @endif
                                            </td>
                                            <td class="gridjs-td text-center">
                                                <a href="{{ route('bengkel.list.edit', $b->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('bengkel.list.destroy', $b->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus bengkel ini?')"
                                                        class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Belum ada data bengkel.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script pencarian sederhana --}}
    <script>
        function filterTable(keyword) {
            keyword = keyword.toLowerCase();
            const rows = document.querySelectorAll("#adminTableBody tr");
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        }
    </script>
</x-layout.dashboard-admin>
