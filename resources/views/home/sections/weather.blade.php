<section class="section-padding bg-white" id="weather-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="text-uppercase text-primary fw-bold small tracking-wider">Plan Ahead</span>
                <h2 class="section-title">Weather & Travel Essentials</h2>
                <p class="text-muted">Stay updated with current surfing conditions, ocean tides, weather patterns, and helpful travel guidelines for Gubat.</p>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Weather Widget Card (Live Open-Meteo API) -->
            <div class="col-lg-5">
                <div class="card card-tourism h-100 text-white p-4 shadow-sm" style="background: linear-gradient(135deg, var(--primary-color), var(--dark-color)) !important; background-color: var(--primary-color); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 d-flex align-items-center">
                            <i id="weather-header-icon" class="bi bi-cloud-sun me-2 text-warning"></i> Gubat Live Weather
                        </h5>
                        <span id="weather-status-badge" class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-50 px-2 py-1 rounded-pill small">
                            <i class="bi bi-broadcast me-1"></i> Connecting...
                        </span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <div class="display-3 fw-bold font-outfit" id="weather-temp">--°C</div>
                        <div>
                            <span class="fs-5 d-block fw-semibold text-warning" id="weather-condition">Checking weather...</span>
                            <span class="small text-white-75" id="weather-details">Humidity: --% | Wind: -- km/h</span>
                        </div>
                    </div>

                    <div class="table-responsive border-top border-white-10 pt-3">
                        <table class="table table-borderless text-white mb-0 small">
                            <tbody>
                                <tr class="border-bottom border-white-10">
                                    <td class="text-white-50 py-2">Surf Swell Advisory</td>
                                    <td class="text-end fw-bold text-warning py-2" id="weather-swell">Pacific Swell (Active)</td>
                                </tr>
                                <tr class="border-bottom border-white-10">
                                    <td class="text-white-50 py-2">Location</td>
                                    <td class="text-end fw-semibold text-white py-2">Gubat, Sorsogon</td>
                                </tr>
                                <tr>
                                    <td class="text-white-50 py-2">Coordinates</td>
                                    <td class="text-end text-white-50 py-2">12.92° N, 124.12° E</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-auto pt-3 text-center">
                        <small class="text-white-50" id="weather-footer-note">
                            <i class="bi bi-info-circle me-1"></i> Live data powered by Open-Meteo. Optimal conditions for Pacific surfing.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Travel Tips Card -->
            <div class="col-lg-7">
                <div class="row g-3 h-100">
                    @foreach($weatherTips as $tip)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light p-3" style="border-radius: 15px;">
                                <div class="card-body p-2">
                                    <h6 class="fw-bold text-dark d-flex align-items-center">
                                        <i class="bi {{ $tip->icon_class }} text-primary me-2"></i> 
                                        {{ $tip->title }}
                                    </h6>
                                    <p class="text-muted small mb-0">{{ $tip->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Client-side Real-time Weather Script (Free Open-Meteo API) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tempEl = document.getElementById('weather-temp');
    const condEl = document.getElementById('weather-condition');
    const detailsEl = document.getElementById('weather-details');
    const badgeEl = document.getElementById('weather-status-badge');
    const iconEl = document.getElementById('weather-header-icon');

    // WMO Weather code interpretations
    function interpretWeatherCode(code) {
        if (code === 0) return { text: 'Clear Sky', icon: 'bi-sun-fill' };
        if (code === 1) return { text: 'Mainly Clear', icon: 'bi-brightness-high-fill' };
        if (code === 2) return { text: 'Partly Cloudy', icon: 'bi-cloud-sun-fill' };
        if (code === 3) return { text: 'Overcast', icon: 'bi-clouds-fill' };
        if (code >= 45 && code <= 48) return { text: 'Foggy / Haze', icon: 'bi-cloud-fog2-fill' };
        if (code >= 51 && code <= 55) return { text: 'Light Drizzle', icon: 'bi-cloud-drizzle-fill' };
        if (code >= 61 && code <= 65) return { text: 'Rain Showers', icon: 'bi-cloud-rain-fill' };
        if (code >= 80 && code <= 82) return { text: 'Passing Showers', icon: 'bi-cloud-rain-heavy-fill' };
        if (code >= 95) return { text: 'Thunderstorm', icon: 'bi-cloud-lightning-rain-fill' };
        return { text: 'Tropical Weather', icon: 'bi-cloud-sun-fill' };
    }

    function getWindDirection(deg) {
        const compass = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
        return compass[Math.round(deg / 22.5) % 16] || 'E';
    }

    function applyWeatherData(current) {
        const temp = Math.round(current.temperature_2m);
        const humidity = current.relative_humidity_2m;
        const windSpeed = Math.round(current.wind_speed_10m);
        const windDir = getWindDirection(current.wind_direction_10m);
        const condition = interpretWeatherCode(current.weather_code);

        tempEl.textContent = temp + '°C';
        condEl.textContent = condition.text;
        detailsEl.textContent = 'Humidity: ' + humidity + '% | Wind: ' + windSpeed + ' km/h ' + windDir;
        badgeEl.innerHTML = '<i class="bi bi-broadcast me-1 text-success"></i> Live Gubat';
        badgeEl.className = 'badge bg-success bg-opacity-25 text-white border border-success border-opacity-50 px-2 py-1 rounded-pill small';

        if (iconEl) {
            iconEl.className = 'bi ' + condition.icon + ' me-2 text-warning';
        }
    }

    function applyFallback() {
        tempEl.textContent = '30°C';
        condEl.textContent = 'Partly Cloudy';
        detailsEl.textContent = 'Humidity: 75% | Wind: 14 km/h NE';
        badgeEl.innerHTML = '<i class="bi bi-clock-history me-1"></i> Seasonal Guide';
        badgeEl.className = 'badge bg-warning bg-opacity-25 text-white border border-warning border-opacity-50 px-2 py-1 rounded-pill small';
    }

    // Check cache first (valid for 10 minutes)
    const cached = localStorage.getItem('gubat_weather_cache');
    const cachedTime = localStorage.getItem('gubat_weather_time');
    const now = Date.now();

    if (cached && cachedTime && (now - cachedTime < 10 * 60 * 1000)) {
        try {
            applyWeatherData(JSON.parse(cached));
            return;
        } catch (e) {
            localStorage.removeItem('gubat_weather_cache');
        }
    }

    // Fetch live from free Open-Meteo endpoint (Gubat coordinates: 12.9194, 124.1242)
    const url = 'https://api.open-meteo.com/v1/forecast?latitude=12.9194&longitude=124.1242&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,wind_direction_10m&timezone=Asia%2FManila';

    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 6000);

    fetch(url, { signal: controller.signal })
        .then(response => {
            clearTimeout(timeoutId);
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            if (data && data.current) {
                applyWeatherData(data.current);
                localStorage.setItem('gubat_weather_cache', JSON.stringify(data.current));
                localStorage.setItem('gubat_weather_time', now);
            } else {
                applyFallback();
            }
        })
        .catch(err => {
            console.warn('Weather fetch fallback engaged:', err);
            applyFallback();
        });
});
</script>
