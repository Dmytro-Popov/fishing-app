<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishCatch;
use App\Services\WeatherService;

class CatchController extends Controller
{
    /**
     * Display a listing of catches.
     */
    public function index(Request $request)
    {
        // Получаем параметр сортировки из URL (?sort=weight)
    $sortBy = $request->input('sort', 'created_at'); // По умолчанию created_at
    $sortOrder = $request->input('order', 'desc');   // По умолчанию desc (новые первые)

    // Валидация параметров (защита от SQL injection)
    $allowedSorts = ['created_at', 'date', 'weight', 'species'];
    $allowedOrders = ['asc', 'desc'];

    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'created_at';
    }

    if (!in_array($sortOrder, $allowedOrders)) {
        $sortOrder = 'desc';
    }

    // Получаем уловы с сортировкой
    $catches = FishCatch::orderBy($sortBy, $sortOrder)->get();

    return view('catches.index', [
        'catches' => $catches,
        'currentSort' => $sortBy,
        'currentOrder' => $sortOrder,
    ]);
    }

    /**
     * Show the form for creating a new catch.
     */
    public function create()
    {
        return view('catches.create');
    }

    /**
     * Store a newly created catch in storage.
     */
    public function store(Request $request)
    {
        // Валидация данных
    $validated = $request->validate([
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'tackle' => 'required|string|max:255',
        'bait' => 'required|string|max:255',
        'species' => 'required|string|max:255',
        'weight' => 'nullable|numeric|min:0|max:999.99',
        'temperature' => 'nullable|numeric|min:-60|max:60',
        'weather_condition' => 'nullable|string|max:100',
        'wind_speed' => 'nullable|numeric|min:0|max:100',
        'pressure' => 'nullable|integer|min:600|max:900',
        'humidity' => 'nullable|integer|min:0|max:100',
    ]);

        // Получаем данные о погоде через сервис
       // $weatherData = $this->weatherService->getManual($validated);

        // Объединяем данные улова и погоды
        FishCatch::create($validated);

        // Редирект на список уловов с сообщением
        return redirect('/catches')->with('success', 'Catch added successfully!');
    }

    /**
     * Display the specified catch.
     */
    public function show(string $id)
    {
        return view('catches.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified catch.
     */
    public function edit(string $id)
    {
        $catch = FishCatch::findOrFail($id);
        return view('catches.edit', ['catch' => $catch]);
    }

    /**
     * Update the specified catch in storage.
     */
    public function update(Request $request, string $id)
    {
        // Находим улов
    $catch = FishCatch::findOrFail($id);

    // Валидация данных
    $validated = $request->validate([
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'tackle' => 'required|string|max:255',
        'bait' => 'required|string|max:255',
        'species' => 'required|string|max:255',
        'weight' => 'nullable|numeric|min:0|max:999.99',
        'temperature' => 'nullable|numeric|min:-60|max:60',
        'weather_condition' => 'nullable|string|max:100',
        'wind_speed' => 'nullable|numeric|min:0|max:100',
        'pressure' => 'nullable|integer|min:600|max:900',
        'humidity' => 'nullable|integer|min:0|max:100',
    ]);

        // Обновляем данные
        $catch->update($validated);

        return redirect('/catches')->with('success', 'Catch updated successfully!');
    }

    /**
     * Remove the specified catch from storage.
     */
    public function destroy(string $id)
    {
        return "Catch #{$id} deleted! (temporary message)";
    }

    // Внедрение зависимости (Dependency Injection)
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }
}
