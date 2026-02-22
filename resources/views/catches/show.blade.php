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
                <p>⚖️ <strong>Weight:</strong> {{ $catch->weight }} kg</p>
            @endif

            @if ($catch->photo)
                <div style="margin-top: 15px;">
                    <img src="{{ asset('storage/' . $catch->photo) }}"
                        style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                </div>
            @endif

            @if ($catch->weather_condition || $catch->temperature !== null)
                <div
                    style="margin-top: 15px; padding: 15px; background: #f0f9ff; border-radius: 8px; border-left: 3px solid #38bdf8;">
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

        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="/catches/{{ $catch->id }}/edit"
                style="padding: 10px 20px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px;">
                ✏️ Edit
            </a>
        </div>

    </div>
@endsection
