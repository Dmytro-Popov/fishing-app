@extends('layouts.app')

@section('title', __('messages.add_new_catch_title'))

@section('content')
    <h1 style="max-width: 600px; margin: 0 auto 10px;">➕ {{ __('messages.add_new_catch_title') }}</h1>
    <p class="subtitle" style="max-width: 600px; margin: 0 auto 30px;">{{ __('messages.record_success') }}</p>

    <form action="/catches" method="POST" style="max-width: 600px; margin: 0 auto 30px;" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📅 {{ __('messages.date') }}
            </label>
            <input type="date" name="date" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ date('Y-m-d') }}">
        </div>

        <div style="margin-bottom: 20px; padding: 20px; border: 2px solid #e5e7eb; border-radius: 12px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📍 {{ __('messages.location') }}
            </label>
            <input type="text" name="location" id="location-input" placeholder="e.g. Dnestr, Odessa region"
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; margin-bottom: 12px;">
            <small style="color: #6b7280; display: block; margin-bottom: 12px;">{{ __('messages.location_hint') }}</small>
            <div id="map" style="height: 400px; width: 100%; border-radius: 12px; border: 1px solid #ddd;"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🎣 {{ __('messages.tackle') }}
            </label>
            <input type="text" name="tackle" placeholder="Spinning rod, 8lb line" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🪱 {{ __('messages.bait') }}
            </label>
            <input type="text" name="bait" placeholder="Worms, lures, flies..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🐟 {{ __('messages.fish_species') }}
            </label>
            <input type="text" name="species" placeholder="Bass, Trout, Pike..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                ⚖️ {{ __('messages.weight_kg') }}
            </label>
            <input type="number" name="weight" step="0.01" placeholder="2.5"
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
            <small style="color: #6b7280;">{{ __('messages.optional') }}</small>
        </div>

        {{-- TROPHY SECTION --}}
        <div style="margin: 30px 0; padding: 20px; background: #fffbeb; border-radius: 12px; border: 2px solid #fcd34d;">
            <h3 style="color: #92400e; margin-bottom: 20px; font-size: 18px;">
                🏆 {{ __('messages.trophy') }}
                <span style="font-size: 13px; font-weight: normal; color: #6b7280;">({{ __('messages.optional') }})</span>
            </h3>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                    🐟 {{ __('messages.trophy_species') }}
                </label>
                <input type="text" name="trophy_species" placeholder="Carp, Pike, Bass..."
                    style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                    ⚖️ {{ __('messages.trophy_weight') }}
                </label>
                <input type="number" name="trophy_weight" step="0.01" placeholder="5.0" min="0" max="999.99"
                    style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                    📸 {{ __('messages.trophy_photo') }}
                </label>
                <input type="file" name="photo" accept="image/*">
            </div>
        </div>
        {{-- END TROPHY SECTION --}}

        {{-- WEATHER SECTION --}}
        <div style="margin: 30px 0; padding: 20px; background: #f0f9ff; border-radius: 12px; border: 2px solid #bae6fd;">
            <h3 style="color: #0369a1; margin-bottom: 20px; font-size: 18px;">
                🌤️ {{ __('messages.weather_conditions') }}
                <span style="font-size: 13px; font-weight: normal; color: #6b7280;">({{ __('messages.optional') }})</span>
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        🌡️ {{ __('messages.temperature') }}
                    </label>
                    <input type="number" name="temperature" step="0.1" placeholder="25.0" min="-50" max="50"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        ☁️ {{ __('messages.weather_condition') }}
                    </label>
                    <select name="weather_condition"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; background: white;">
                        <option value="">-- {{ __('messages.select') }} --</option>
                        <option value="Sunny">☀️ {{ __('messages.sunny') }}</option>
                        <option value="Partly Cloudy">⛅ {{ __('messages.partly_cloudy') }}</option>
                        <option value="Cloudy">☁️ {{ __('messages.cloudy') }}</option>
                        <option value="Overcast">🌥️ {{ __('messages.overcast') }}</option>
                        <option value="Rainy">🌧️ {{ __('messages.rainy') }}</option>
                        <option value="Stormy">⛈️ {{ __('messages.stormy') }}</option>
                        <option value="Foggy">🌫️ {{ __('messages.foggy') }}</option>
                        <option value="Snowy">❄️ {{ __('messages.snowy') }}</option>
                        <option value="Windy">💨 {{ __('messages.windy') }}</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        💨 {{ __('messages.wind_speed') }}
                    </label>
                    <input type="number" name="wind_speed" step="0.1" placeholder="5.0" min="0" max="100"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        🔵 {{ __('messages.pressure') }}
                    </label>
                    <input type="number" name="pressure" placeholder="760" min="600" max="900"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 14px;">
                        💧 {{ __('messages.humidity') }}
                    </label>
                    <input type="number" name="humidity" placeholder="65" min="0" max="100"
                        style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px;">
                </div>
            </div>
        </div>
        {{-- END WEATHER SECTION --}}

        <script>
            let map;
            let marker;

            function initMap() {
                const defaultCoords = { lat: 46.4825, lng: 30.7233 };
                map = new google.maps.Map(document.getElementById("map"), {
                    center: defaultCoords,
                    zoom: 10,
                    mapTypeId: 'terrain'
                });
                map.addListener("click", (e) => { placeMarker(e.latLng); });
            }

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({ position: location, map: map, draggable: true });
                    marker.addListener('dragend', (e) => {
                        document.getElementById("latitude").value = e.latLng.lat();
                        document.getElementById("longitude").value = e.latLng.lng();
                        if (!document.getElementById('location-input').value) {
                            document.getElementById('location-input').value = e.latLng.lat().toFixed(4) + ', ' + e.latLng.lng().toFixed(4);
                        }
                    });
                }
                document.getElementById("latitude").value = location.lat();
                document.getElementById("longitude").value = location.lng();
                if (!document.getElementById('location-input').value) {
                    document.getElementById('location-input').value = location.lat().toFixed(4) + ', ' + location.lng().toFixed(4);
                }
            }

            if (typeof google === 'undefined') {
                const script = document.createElement('script');
                script.src = "https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_key') }}&callback=initMap";
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            } else {
                initMap();
            }
        </script>

        <button type="submit" class="btn">💾 {{ __('messages.save_catch') }}</button>
        <a href="/catches" style="margin-left: 15px; color: #6b7280; text-decoration: none;">{{ __('messages.cancel') }}</a>
    </form>
@endsection
