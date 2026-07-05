<section class="section-padding bg-white" id="map-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="text-uppercase text-primary fw-bold small tracking-wider">Explore The Region</span>
                <h2 class="section-title">Interactive Tourism Map</h2>
                <p class="text-muted">Locate beach resorts, historical heritage sites, local weaving centers, and municipal services across the municipality of Gubat.</p>
            </div>
        </div>

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Map Container Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
            <div class="row g-0">
                <!-- Sidebar Landmark List -->
                <div class="col-lg-4 bg-light border-end d-flex flex-column" style="max-height: 500px; overflow-y: auto;">
                    <div class="p-3 bg-primary text-white">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-geo-fill me-2"></i> Destinations Directory</h6>
                    </div>
                    <div class="list-group list-group-flush" id="landmark-list">
                        <!-- Items populated by JS -->
                    </div>
                </div>

                <!-- Actual Interactive Map -->
                <div class="col-lg-8 position-relative">
                    <div id="tourismMap" style="height: 500px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Center of Gubat Sorsogon
        const gubatCoords = [12.9189, 124.1232];
        
        // Initialize Map
        const map = L.map('tourismMap').setView(gubatCoords, 13);

        // Load OpenStreetMap Tiles (Positron Lite/NoLabels style is premium, or standard OSM)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Landmark points database
        const landmarks = [
            {
                name: "Lola Sayong Surf Camp",
                category: "Beach & Surfing",
                coords: [12.9023, 124.1374],
                description: "Famous surfing camp and cottages.",
                icon: "bi-tsunami",
                badgeClass: "bg-warning text-dark"
            },
            {
                name: "Rizal Public Beach",
                category: "Beach & Surfing",
                coords: [12.9015, 124.1368],
                description: "Prisitine coastline, public cottages & picnics.",
                icon: "bi-water",
                badgeClass: "bg-info text-dark"
            },
            {
                name: "St. Anthony of Padua Parish",
                category: "Heritage & History",
                coords: [12.9192, 124.1228],
                description: "Century-old historical town church.",
                icon: "bi-bank",
                badgeClass: "bg-danger"
            },
            {
                name: "Bulacao Weaving Center",
                category: "Livelihood & Crafts",
                coords: [12.9234, 124.1102],
                description: "Traditional abaca weaving weavers.",
                icon: "bi-basket",
                badgeClass: "bg-success"
            },
            {
                name: "Bentuco Clay Pottery",
                category: "Livelihood & Crafts",
                coords: [12.9356, 124.0894],
                description: "Locally-crafted clay and earthenware jars.",
                icon: "bi-palette",
                badgeClass: "bg-success"
            },
            {
                name: "Gubat Municipal Hall",
                category: "Public Service",
                coords: [12.9189, 124.1232],
                description: "Municipal Tourism Office headquarters.",
                icon: "bi-building-fill",
                badgeClass: "bg-secondary"
            }
        ];

        const listContainer = document.getElementById('landmark-list');
        const markersGroup = [];

        // Add Markers and Sidebar items
        landmarks.forEach(function(landmark, index) {
            // Map Marker
            const marker = L.marker(landmark.coords).addTo(map);
            marker.bindPopup(`
                <div style="font-family: 'Poppins', sans-serif;">
                    <span class="badge ${landmark.badgeClass} mb-1">${landmark.category}</span>
                    <h6 class="fw-bold mb-1" style="color: #0F4C81;">${landmark.name}</h6>
                    <p class="small text-muted mb-0">${landmark.description}</p>
                </div>
            `);
            markersGroup.push(marker);

            // Sidebar List Item
            const listItem = document.createElement('a');
            listItem.href = 'javascript:void(0);';
            listItem.className = 'list-group-item list-group-item-action p-3 d-flex align-items-start gap-3 border-0 border-bottom';
            listItem.innerHTML = `
                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 40px; height: 40px; min-width: 40px;">
                    <i class="bi ${landmark.icon} fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <span class="badge ${landmark.badgeClass} mb-1 small" style="font-size: 0.7rem;">${landmark.category}</span>
                    <h6 class="mb-1 fw-bold text-dark small" style="font-size: 0.85rem;">${landmark.name}</h6>
                    <p class="mb-0 text-muted small" style="font-size: 0.75rem;">${landmark.description}</p>
                </div>
            `;

            // Click interaction
            listItem.addEventListener('click', function() {
                // Pan map to marker
                map.flyTo(landmark.coords, 15);
                // Open popup
                marker.openPopup();
                
                // Highlight item
                document.querySelectorAll('#landmark-list .list-group-item').forEach(el => el.classList.remove('active', 'bg-primary-subtle'));
                listItem.classList.add('bg-primary-subtle');
            });

            listContainer.appendChild(listItem);
        });
    });
</script>
