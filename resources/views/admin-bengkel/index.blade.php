<x-layout.dashboard-admin>
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Daftar Admin Bengkel</h6>
                <a href="{{ route('admin-bengkel.create') }}" class="btn btn-light btn-sm text-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Admin Bengkel
                </a>
            </div>

            <div class="card-body">
                <div id="searchTable">
                    <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                        <div class="gridjs-head">
                            <div class="gridjs-search">
                                <input type="search" placeholder="Cari admin bengkel..." aria-label="Cari admin bengkel..."
                                    class="gridjs-input gridjs-search-input form-control" onkeyup="filterTable(this.value)">
                            </div>
                        </div>

                        <div class="gridjs-wrapper" style="height: auto;">
                            <table role="grid" class="gridjs-table text-nowrap table table-hover align-middle">
                                <thead class="gridjs-thead bg-light">
                                    <tr class="gridjs-tr">
                                        <th class="gridjs-th">#</th>
                                        <th class="gridjs-th">Foto</th>
                                        <th class="gridjs-th">Nama</th>
                                        <th class="gridjs-th">Email</th>
                                        <th class="gridjs-th text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="gridjs-tbody" id="adminTableBody">
                                    @forelse ($adminBengkels as $admin)
                                        <tr class="gridjs-tr">
                                            <td class="gridjs-td">{{ $loop->iteration }}</td>
                                            <td class="gridjs-td">
                                                @if ($admin->avatar)
                                                    <img src="{{ $admin->avatar }}" alt="Avatar"
                                                        class="rounded-circle" width="40" height="40">
                                                @else
                                                    <img src="https://placehold.co/100x100" alt="Default Avatar"
                                                        class="rounded-circle" width="40" height="40">
                                                @endif
                                            </td>
                                            <td class="gridjs-td">{{ $admin->name }}</td>
                                            <td class="gridjs-td">{{ $admin->email }}</td>
                                            <td class="gridjs-td text-center">
                                                <a href="{{ route('admin-bengkel.edit', $admin->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin-bengkel.destroy', $admin->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus akun admin bengkel ini?')"
                                                        class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data admin bengkel.</td>
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