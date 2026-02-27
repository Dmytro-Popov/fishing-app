@extends('layouts.app')

@section('title', $catch->species)

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">

        <a href="/catches" style="color: #6b7280; text-decoration: none;">← Back to list</a>

        <h1 style="margin-top: 20px;">🐟 {{ $catch->species }}</h1>

        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 25px; margin-top: 20px;">

            <p>📅 <strong>Date:</strong> {{ $catch->date->format('F d, Y') }}</p>
            <p>📍 <strong>Location:</strong> {{ $catch->location }}</p>
            <p>🎣 <strong>Tackle:</strong> {{ $catch->tackle }}</p>
            <p>🪱 <strong>Bait:</strong> {{ $catch->bait }}</p>

            @if ($catch->weight)
                <p>⚖️ <strong>Total Weight:</strong> {{ $catch->weight }} kg</p>
            @endif

            @if ($catch->weather_condition || $catch->temperature !== null)
                <div style="margin-top: 15px; padding: 15px; background: #f0f9ff; border-radius: 8px; border-left: 3px solid #38bdf8;">
                    <p style="font-weight: 700; color: #0369a1; margin-bottom: 10px;">🌤️ Weather</p>
                    @if ($catch->weather_condition)
                        <p>☁️ {{ $catch->weather_condition }}</p>
                    @endif
                    @if ($catch->temperature !== null)
                        <p>🌡️ {{ $catch->temperature }}°C</p>
                    @endif
                    @if ($catch->wind_speed !== null)
                        <p>💨 {{ $catch->wind_speed }} m/s</p>
                    @endif
                    @if ($catch->pressure)
                        <p>🔵 {{ $catch->pressure }} mmHg</p>
                    @endif
                    @if ($catch->humidity)
                        <p>💧 {{ $catch->humidity }}%</p>
                    @endif
                </div>
            @endif

            {{-- TROPHY BLOCK --}}
            @if ($catch->trophy_species || $catch->trophy_weight || $catch->photo)
                <div style="margin-top: 15px; padding: 15px; background: #fffbeb; border-radius: 8px; border-left: 3px solid #fcd34d;">
                    <p style="font-weight: 700; color: #92400e; margin-bottom: 10px;">🏆 Trophy</p>
                    @if ($catch->trophy_species)
                        <p>🐟 <strong>Species:</strong> {{ $catch->trophy_species }}</p>
                    @endif
                    @if ($catch->trophy_weight)
                        <p>⚖️ <strong>Weight:</strong> {{ $catch->trophy_weight }} kg</p>
                    @endif
                    @if ($catch->photo)
                        <div style="margin-top: 10px;">
                            <img src="{{ asset('storage/' . $catch->photo) }}"
                                onclick="document.getElementById('photo-modal').style.display='flex'"
                                style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer;">
                        </div>
                    @endif
                </div>
            @endif
            {{-- END TROPHY BLOCK --}}
        </div>

        {{-- MODAL --}}
        @if ($catch->photo)
            <div id="photo-modal" onclick="this.style.display='none'"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center; cursor: pointer;">
                <img src="{{ asset('storage/' . $catch->photo) }}"
                    style="max-width: 90%; max-height: 90vh; border-radius: 8px; object-fit: contain;">
                <span style="position: absolute; top: 20px; right: 30px; color: white; font-size: 36px; cursor: pointer;">✕</span>
            </div>
        @endif
        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="/catches/{{ $catch->id }}/edit"
                style="padding: 10px 20px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px;">
                ✏️ Edit
            </a>
        </div>

    </div>
@endsection
