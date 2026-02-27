@extends('layouts.app')

@section('title', 'Bite Activity')

@section('content')
    <h1 style="margin-bottom: 20px">📊 Bite Activity</h1>
    <p class="subtitle" style="margin-bottom: 20px">Analyze your fishing patterns</p>

    {{-- MONTH/YEAR FILTER --}}
    @if ($period === 'month')
        <form method="GET" action="/stats"
            style="display: flex; gap: 10px; align-items: center; margin-bottom: 30px; flex-wrap: wrap;">
            <input type="hidden" name="period" value="month">

            <select name="month"
                style="padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;  min-width:120px">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endforeach
            </select>

            <select name="year"
                style="padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; min-width:90px">
                @foreach ($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            <button type="submit"
                style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">
                🔍 Show
            </button>
        </form>
    @endif

    {{-- CHART --}}
    <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #374151; margin-bottom: 20px;">🎣 Catches per day</h3>
        @if ($chartData->isEmpty())
            <p style="color: #6b7280; text-align: center; padding: 40px 0;">No catches in this period</p>
        @else
            <canvas id="catchChart" style="max-height: 400px;"></canvas>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        @if ($chartData->isNotEmpty())
            const ctx = document.getElementById('catchChart').getContext('2d');
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
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        @endif
    </script>
@endsection
