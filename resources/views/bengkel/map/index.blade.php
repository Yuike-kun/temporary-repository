<x-layout.dashboard-admin>
    @push('script')
        <style>
            #map {
                height: 500px;
            }
        </style>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @endpush

    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Map Bengkel</h6>
            </div>

            <div class="card-body">
                <div id="searchTable">
                    <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">

                        <div class="gridjs-wrapper" style="height: auto;">
                            <div id="map"></div>
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

        document.addEventListener("DOMContentLoaded", function() {
            const map = L.map('map').setView([-2.5489, 118.0149], 5); // Pusatkan di Indonesia

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const bengkels = @json($bengkels);

            bengkels.forEach(bengkel => {
                if (bengkel.latitude && bengkel.longitude) {
                    L.marker([bengkel.latitude, bengkel.longitude])
                        .addTo(map)
                        .bindPopup(`<strong>${bengkel.name}</strong><br>${bengkel.address}`);
                }
            });
        });
    </script>
</x-layout.dashboard-admin>
