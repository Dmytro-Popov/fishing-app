@extends('layouts.app')

@section('title', 'My Catches')

@section('content')
    <h1>🎣 My Catches</h1>

    <p style="margin: 20px 0; color: #6b7280;">
        Your fishing diary. Track every catch, analyze patterns, improve your technique.
    </p>

    <a href="/catches/create" class="btn">+ Add New Catch</a>

    <div style="margin-top: 30px; padding: 40px; background: #f9fafb; border-radius: 8px; text-align: center; color: #9ca3af;">
        <p>📋 No catches yet. Start tracking your fishing adventures!</p>
    </div>
@endsection
