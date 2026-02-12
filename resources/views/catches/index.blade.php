@extends('layouts.app')

@section('title', 'My Catches')

@section('content')
    <h1>🎣 My Catches</h1>
    <p class="subtitle">Your fishing diary. Track every catch, analyze patterns, improve your technique.</p>
    <a href="/catches/create" class="btn">➕ Add New Catch</a>
    <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <h3 style="color: #6b7280; margin-bottom: 10px;">No catches yet</h3>
        <p>Start tracking your fishing adventures!</p>
    </div>
@endsection
