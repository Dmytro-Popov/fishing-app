@extends('layouts.app')

@section('title', 'Add New Catch')

@section('content')
    <h1>➕ Add New Catch</h1>

    <form action="/catches" method="POST" style="margin-top: 30px;">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">📅 Date</label>
            <input type="date" name="date" required
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">📍 Location</label>
            <input type="text" name="location" placeholder="Lake Tahoe, CA" required
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">🎣 Tackle</label>
            <input type="text" name="tackle" placeholder="Spinning rod, 8lb line" required
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">🪱 Bait</label>
            <input type="text" name="bait" placeholder="Worms, lures" required
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">🐟 Fish Species</label>
            <input type="text" name="species" placeholder="Bass, Trout, Pike..." required
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">⚖️ Weight (kg)</label>
            <input type="number" name="weight" step="0.01" placeholder="2.5"
                   style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;">
        </div>

        <button type="submit" class="btn">💾 Save Catch</button>
        <a href="/catches" style="margin-left: 10px; color: #6b7280;">Cancel</a>
    </form>
@endsection
