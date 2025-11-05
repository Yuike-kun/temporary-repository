<x-layout.dashboard-admin>
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Daftar List Servis</h6>
                <a href="{{ route('service.create') }}" class="btn btn-light btn-sm text-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Servis
                </a>
            </div>

            <div class="card-body">
                <div id="searchTable">
                    <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                        <div class="gridjs-head">
                            <div class="gridjs-search">
                                <input type="search" placeholder="Cari servis..." aria-label="Cari servis..."
                                    class="gridjs-input gridjs-search-input form-control" onkeyup="filterTable(this.value)">
                            </div>
                        </div>

                        <div class="gridjs-wrapper" style="height: auto;">
                            <table role="grid" class="gridjs-table text-nowrap table table-hover align-middle">
                                <thead class="gridjs-thead bg-light">
                                    <tr class="gridjs-tr">
                                        <th class="gridjs-th">#</th>
                                        <th class="gridjs-th">Nama Servis</th>
                                        <th class="gridjs-th">Deskripsi</th>
                                        <th class="gridjs-th text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="gridjs-tbody" id="adminTableBody">
                                    @forelse ($services as $service)
                                        <tr class="gridjs-tr">
                                            <td class="gridjs-td">{{ $loop->iteration }}</td>
                                            <td class="gridjs-td">{{ $service->name }}</td>
                                            <td class="gridjs-td">{{ $service->description ?? '-' }}</td>
                                            <td class="gridjs-td text-center">
                                                <a href="{{ route('service.edit', $service->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('service.destroy', $service->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus servis ini?')"
                                                        class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada data servis.</td>
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