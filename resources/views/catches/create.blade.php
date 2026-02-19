@extends('layouts.app')

@section('title', 'Add New Catch')

@section('content')
    <h1>➕ Add New Catch</h1>
    <p class="subtitle">Record your fishing success</p>

    <form action="/catches" method="POST" style="max-width: 600px;">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📅 Date
            </label>
            <input type="date" name="date" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ date('Y-m-d') }}">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📍 Location
            </label>
            <input type="text" name="location" placeholder="Lake Tahoe, CA" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
            <small style="color: #6b7280;">Where did you fish?</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🎣 Tackle
            </label>
            <input type="text" name="tackle" placeholder="Spinning rod, 8lb line" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🪱 Bait
            </label>
            <input type="text" name="bait" placeholder="Worms, lures, flies..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🐟 Fish Species
            </label>
            <input type="text" name="species" placeholder="Bass, Trout, Pike..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                ⚖️ Weight (kg)
            </label>
            <input type="number" name="weight" step="0.01" placeholder="2.5"
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
            <small style="color: #6b7280;">Optional</small>
        </div>

        {{-- WEATHER SECTION --}}
        <div style="margin: 30px 0; padding: 20px; background: #f0f9ff; border-radius: 12px; border: 2px solid #bae6fd;">
            <h3 style="color: #0369a1; margin-bottom: 20px; font-size: 18px;">
                🌤️ Weather Conditions
                <span style="font-size: 13px; font-weight: normal; color: #6b7280;">(optional)</span>
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        🌡️ Temperature (°C)
                    </label>
                    <input type="number" name="temperature" step="0.1" placeholder="25.0"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        ☁️ Weather Condition
                    </label>
                    <select name="weather_condition"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; background: white;">
                        <option value="">-- Select --</option>
                        <option value="Sunny">☀️ Sunny</option>
                        <option value="Partly Cloudy">⛅ Partly Cloudy</option>
                        <option value="Cloudy">☁️ Cloudy</option>
                        <option value="Overcast">🌥️ Overcast</option>
                        <option value="Rainy">🌧️ Rainy</option>
                        <option value="Stormy">⛈️ Stormy</option>
                        <option value="Foggy">🌫️ Foggy</option>
                        <option value="Snowy">❄️ Snowy</option>
                        <option value="Windy">💨 Windy</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        💨 Wind Speed (m/s)
                    </label>
                    <input type="number" name="wind_speed" step="0.1" placeholder="5.0"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        🔵 Pressure (mmHg)
                    </label>
                    <input type="number" name="pressure" placeholder="760"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        💧 Humidity (%)
                    </label>
                    <input type="number" name="humidity" placeholder="65"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>

            </div>
        </div>
        {{-- END WEATHER SECTION --}}

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div class="mb-4">
            <label class="form-label fw-bold">📍 Exact fishing spot</label>
            <div id="map" style="height: 400px; width: 100%; border-radius: 12px; border: 1px solid #ddd;"></div>
            <small class="text-muted">Click on the map to mark a point</small>
        </div>
        <div style="height: 50px;">
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap" async
            defer></script>

        <script>
            let map;
            let marker;

            function initMap() {
                // Центр по умолчанию (например, твои частые места Hadjider или Dnestr)
                const defaultCoords = {
                    lat: 46.4825,
                    lng: 30.7233
                };

                map = new google.maps.Map(document.getElementById("map"), {
                    center: defaultCoords,
                    zoom: 10,
                    mapTypeId: 'terrain' // Рыбакам удобнее рельефная карта
                });

                // Клик по карте
                map.addListener("click", (e) => {
                    placeMarker(e.latLng);
                });
            }

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: true
                    });
                }

                // Записываем координаты в скрытые инпуты для Laravel
                document.getElementById("latitude").value = location.lat();
                document.getElementById("longitude").value = location.lng();
            }
        </script>

        <button type="submit" class="btn">💾 Save Catch</button>
        <a href="/catches" style="margin-left: 15px; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
@endsection
