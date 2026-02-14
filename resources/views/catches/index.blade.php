@extends('layouts.app')

@section('title', 'My Catches')

@section('content')
    <h1>🎣 My Catches</h1>
    <p class="subtitle">Your fishing diary. Track every catch, analyze patterns, improve your technique.</p>

   @if(session('success'))
    <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
        ✅ {{ session('success') }}
    </div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
    <a href="/catches/create" class="btn">➕ Add New Catch</a>

    {{-- Кнопки сортировки --}}
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <span style="color: #6b7280; font-weight: 600; font-size: 14px;">Sort by:</span>

        <a href="/catches?sort=created_at&order=desc"
           class="sort-btn {{ $currentSort === 'created_at' ? 'active' : '' }}">
            🕐 Latest
        </a>

        <a href="/catches?sort=date&order=desc"
           class="sort-btn {{ $currentSort === 'date' ? 'active' : '' }}">
            📅 Date
        </a>

        <a href="/catches?sort=weight&order=desc"
           class="sort-btn {{ $currentSort === 'weight' ? 'active' : '' }}">
            ⚖️ Weight
        </a>

        <a href="/catches?sort=species&order=asc"
           class="sort-btn {{ $currentSort === 'species' ? 'active' : '' }}">
            🐟 Species
        </a>
    </div>
</div>


    </div>

    @if($catches->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 style="color: #6b7280; margin-bottom: 10px;">No catches yet</h3>
            <p>Start tracking your fishing adventures!</p>
        </div>
    @else
        <div style="margin-top: 30px;">
            @foreach($catches as $catch)
                <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <h3 style="color: #2563eb; margin-bottom: 10px; font-size: 24px;">
                                🐟 {{ $catch->species }}
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
                                @if($catch->weight)
                                    <p style="margin: 5px 0;">
                                        ⚖️ <strong>Weight:</strong> {{ $catch->weight }} kg
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <a href="/catches/{{ $catch->id }}/edit"
                               style="display: inline-block; padding: 8px 16px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; margin-right: 5px;">
                                ✏️ Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
