@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
    <h1 style="margin-bottom: 5px;">🎣 Dashboard</h1>
    <p class="subtitle" style="margin-bottom: 30px;">{{ auth()->user()->name }}'s fishing overview</p>

    {{-- STATS CARDS --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">

        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 8px;">🎣</div>
            <div style="font-size: 32px; font-weight: 700; color: #2563eb;">{{ $totalCatches }}</div>
            <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">Total Catches</div>
        </div>

        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 8px;">🏆</div>
            @if($bestTrophy)
                <div style="font-size: 24px; font-weight: 700; color: #92400e;">{{ $bestTrophy->trophy_weight }} kg</div>
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">{{ $bestTrophy->trophy_species }}</div>
            @else
                <div style="font-size: 18px; font-weight: 600; color: #6b7280;">—</div>
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">No trophy yet</div>
            @endif
        </div>

        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 8px;">📍</div>
            @if($topLocation)
                <div style="font-size: 18px; font-weight: 700; color: #374151;">{{ $topLocation->location }}</div>
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">{{ $topLocation->count }} catches</div>
            @else
                <div style="font-size: 18px; font-weight: 600; color: #6b7280;">—</div>
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">No location yet</div>
            @endif
        </div>

    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

        {{-- RECENT CATCHES --}}
        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
            <h3 style="color: #374151; margin-bottom: 15px;">🕐 Recent Catches</h3>
            @if($recentCatches->isEmpty())
                <p style="color: #6b7280; text-align: center; padding: 20px 0;">No catches yet</p>
            @else
                @foreach($recentCatches as $catch)
                    <a href="/catches/{{ $catch->id }}" style="text-decoration: none;">
                        <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                            @if($catch->photo)
                                <img src="{{ asset('storage/' . $catch->photo) }}"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                            @else
                                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">🐟</div>
                            @endif
                            <div>
                                <div style="font-weight: 600; color: #374151;">{{ $catch->species }}</div>
                                <div style="font-size: 13px; color: #6b7280;">{{ $catch->date->format('F d, Y') }}</div>
                                <div style="font-size: 13px; color: #6b7280;">📍 {{ $catch->location ?: '—' }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
                <a href="/catches" style="display: block; text-align: center; margin-top: 15px; color: #2563eb; text-decoration: none; font-size: 14px;">
                    View all catches →
                </a>
            @endif
        </div>

        {{-- CHART --}}
        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
            <h3 style="color: #374151; margin-bottom: 15px;">📊 This Month</h3>
            @if($chartData->isEmpty())
                <p style="color: #6b7280; text-align: center; padding: 20px 0;">No catches this month</p>
            @else
                <canvas id="dashChart"></canvas>
            @endif
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        @if($chartData->isNotEmpty())
        const ctx = document.getElementById('dashChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $chartData->keys()->toJson() !!},
                datasets: [{
                    label: 'Catches',
                    data: {!! $chartData->values()->toJson() !!},
                    backgroundColor: 'rgba(37, 99, 235, 0.5)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
        @endif
    </script>
@endsection
