@extends('layouts.app')

@section('title', 'My Catches')

@section('content')
    <h1 style="height: 30px;">🎣 My Catches</h1>

    <p style="height: 50px;"class="subtitle">Your fishing diary. Track every catch, analyze patterns, improve your technique.
    </p>

    @if (session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <a href="/catches/create" class="btn">➕ Add New Catch</a>

        {{-- Sorting buttons --}}
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <span style="color: #6b7280; font-weight: 600; font-size: 14px;">Sort by:</span>

            <a href="/catches?sort=created_at&order=desc"
                class="sort-btn {{ $currentSort === 'created_at' ? 'active' : '' }}">
                🕐 Latest
            </a>

            <a href="/catches?sort=date&order=desc" class="sort-btn {{ $currentSort === 'date' ? 'active' : '' }}">
                📅 Date
            </a>

            <a href="/catches?sort=weight&order=desc" class="sort-btn {{ $currentSort === 'weight' ? 'active' : '' }}">
                ⚖️ Weight
            </a>

            <a href="/catches?sort=species&order=asc" class="sort-btn {{ $currentSort === 'species' ? 'active' : '' }}">
                🐟 Species
            </a>
        </div>
    </div>

    @if ($catches->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 style="color: #6b7280; margin-bottom: 10px;">No catches yet</h3>
            <p>Start tracking your fishing adventures!</p>
        </div>
    @else
        <div style="margin-top: 30px;">
            @foreach ($catches as $catch)
                <div
                    style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">

                        {{-- LEFT: Catch details --}}
                        <div style="flex: 1;">
                            <h3 style="color: #2563eb; margin-bottom: 10px; font-size: 24px;">
                                <a href="/catches/{{ $catch->id }}" style="text-decoration: none; color: #2563eb;">
                                    🐟 {{ $catch->species }}
                                </a>
                            </h3>
                            <div style="color: #6b7280; font-size: 14px;">
                                <p style="margin: 5px 0;">
                                    📅 <strong>Date:</strong> {{ $catch->date->format('F d, Y') }}
                                </p>
                                <p style="margin: 5px 0;">
                                    📍 <strong>Location:</strong> {{ $catch->location }}
                                </p>
                                <p style="margin: 5px 0;">
                                    🎣 <strong>Tackle:</strong> {{ $catch->tackle }}
                                </p>
                                <p style="margin: 5px 0;">
                                    🪱 <strong>Bait:</strong> {{ $catch->bait }}
                                </p>
                                @if ($catch->weight)
                                    <p style="margin: 5px 0;">
                                        ⚖️ <strong>Weight:</strong> {{ $catch->weight }} kg
                                    </p>
                                @endif

                                {{-- PHOTO --}}
                                @if ($catch->photo)
                                    <img src="{{ asset('storage/' . $catch->photo) }}"
                                        style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                                @endif

                                {{-- WEATHER BLOCK --}}
                                @if ($catch->weather_condition || $catch->temperature !== null)
                                    <div
                                        style="margin-top: 12px; padding: 12px; background: #f0f9ff; border-radius: 8px; border-left: 3px solid #38bdf8;">
                                        <p
                                            style="margin: 0 0 8px 0; font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 1px;">
                                            🌤️ Weather
                                        </p>
                                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                                            @if ($catch->weather_condition)
                                                <span style="font-size: 13px; color: #374151;">
                                                    ☁️ {{ $catch->weather_condition }}
                                                </span>
                                            @endif
                                            @if ($catch->temperature !== null)
                                                <span style="font-size: 13px; color: #374151;">
                                                    🌡️ {{ $catch->temperature }}°C
                                                </span>
                                            @endif
                                            @if ($catch->wind_speed !== null)
                                                <span style="font-size: 13px; color: #374151;">
                                                    💨 {{ $catch->wind_speed }} m/s
                                                </span>
                                            @endif
                                            @if ($catch->pressure)
                                                <span style="font-size: 13px; color: #374151;">
                                                    🔵 {{ $catch->pressure }} mmHg
                                                </span>
                                            @endif
                                            @if ($catch->humidity)
                                                <span style="font-size: 13px; color: #374151;">
                                                    💧 {{ $catch->humidity }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                {{-- END WEATHER BLOCK --}}
                            </div>
                        </div>

                        {{-- RIGHT: Action buttons --}}
                        <div style="display: flex; gap: 5px; margin-left: 15px;">

                            <a href="/catches/{{ $catch->id }}/edit"
                                style="display: inline-block; padding: 8px 16px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                                ✏️ Edit
                            </a>

                            <form action="/catches/{{ $catch->id }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this catch?');"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
