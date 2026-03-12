@extends('layouts.app')

@section('title', __('messages.my_catches'))

@section('content')
    <h1 style="height: 30px;">🎣 {{ __('messages.my_catches') }}</h1>

    <p style="height: 50px;" class="subtitle">{{ __('messages.your_fishing_diary') }}</p>

    @if (session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <a href="/catches/create" class="btn">➕ {{ __('messages.add_new_catch') }}</a>

        {{-- Sorting buttons --}}
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <span style="color: #6b7280; font-weight: 600; font-size: 14px;">{{ __('messages.sort_by') }}:</span>

            <a href="/catches?sort=created_at&order=desc"
                class="sort-btn {{ $currentSort === 'created_at' ? 'active' : '' }}">
                🕐 {{ __('messages.latest') }}
            </a>
            <a href="/catches?sort=date&order=desc" class="sort-btn {{ $currentSort === 'date' ? 'active' : '' }}">
                📅 {{ __('messages.date') }}
            </a>
            <a href="/catches?sort=weight&order=desc" class="sort-btn {{ $currentSort === 'weight' ? 'active' : '' }}">
                ⚖️ {{ __('messages.weight') }}
            </a>
            <a href="/catches?sort=species&order=asc" class="sort-btn {{ $currentSort === 'species' ? 'active' : '' }}">
                🐟 {{ __('messages.species') }}
            </a>
        </div>
    </div>

    @if ($catches->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 style="color: #6b7280; margin-bottom: 10px;">{{ __('messages.no_catches_yet') }}</h3>
            <p>{{ __('messages.start_tracking') }}</p>
        </div>
    @else
        <div style="margin-top: 30px;">
            @foreach ($catches as $catch)
                <div
                    style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">

                        <div style="flex: 1;">
                            <h3 style="color: #2563eb; margin-bottom: 10px; font-size: 24px;">
                                 {{ $catch->species }}
                            </h3>
                            <div style="color: #6b7280; font-size: 14px;">
                                <p style="margin: 5px 0;">
                                    📅 <strong>{{ __('messages.date') }}:</strong> {{ $catch->date->format('F d, Y') }}
                                </p>
                                <p style="margin: 5px 0;">
                                    📍 <strong>{{ __('messages.location') }}:</strong>
                                    {{ $catch->location ?: ($catch->latitude ? $catch->latitude . ', ' . $catch->longitude : '—') }}
                                </p>
                                @if ($catch->weight)
                                    <p style="margin: 5px 0;">
                                        ⚖️ <strong>{{ __('messages.total_weight') }}:</strong> {{ $catch->weight }} kg
                                    </p>
                                @endif
                            </div>
                            <a href="/catches/{{ $catch->id }}"
                                style="display: inline-block; margin-top: 12px; padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                                🔍 {{ __('messages.full_info') }}
                            </a>
                        </div>

                        <div style="display: flex; gap: 5px; margin-left: 15px;">
                            <a href="/catches/{{ $catch->id }}/edit"
                                style="display: inline-block; padding: 8px 16px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                                ✏️ {{ __('messages.edit') }}
                            </a>
                            <form action="/catches/{{ $catch->id }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.delete_confirm') }}')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">
                                    🗑️ {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div style="margin-top: 20px;">
                {{ $catches->links() }}
            </div>
        </div>
    @endif
@endsection
