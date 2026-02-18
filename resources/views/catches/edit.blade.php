@extends('layouts.app')

@section('title', 'Edit Catch')

@section('content')
    <h1>✏️ Edit Catch</h1>
    <p class="subtitle">Update your fishing record</p>

    <form action="/catches/{{ $catch->id }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📅 Date
            </label>
            <input type="date" name="date" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ $catch->date->format('Y-m-d') }}">
            @error('date')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                📍 Location
            </label>
            <input type="text" name="location" placeholder="Lake Tahoe, CA" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ old('location', $catch->location) }}">
            @error('location')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🎣 Tackle
            </label>
            <input type="text" name="tackle" placeholder="Spinning rod, 8lb line" required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ old('tackle', $catch->tackle) }}">
            @error('tackle')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🪱 Bait
            </label>
            <input type="text" name="bait" placeholder="Worms, lures, flies..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ old('bait', $catch->bait) }}">
            @error('bait')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                🐟 Fish Species
            </label>
            <input type="text" name="species" placeholder="Bass, Trout, Pike..." required
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ old('species', $catch->species) }}">
            @error('species')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                ⚖️ Weight (kg)
            </label>
            <input type="number" name="weight" step="0.01" placeholder="2.5"
                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;"
                value="{{ old('weight', $catch->weight) }}">
            @error('weight')
                <span style="color: #dc2626; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">💾 Update Catch</button>
        <a href="/catches" style="margin-left: 15px; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
@endsection
