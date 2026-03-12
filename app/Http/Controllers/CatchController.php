<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishCatch;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Storage;

class CatchController extends Controller
{
    // Dependency injection (Dependency Injection)
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }
    /**
     * Display a listing of catches.
     */
    public function index(Request $request)
    {
        $sortBy = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');

        $allowedSorts = ['created_at', 'date', 'weight', 'species'];
        $allowedOrders = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        if (!in_array($sortOrder, $allowedOrders)) $sortOrder = 'desc';

        // Current user's catches only
        $catches = FishCatch::where('user_id', auth()->id())
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

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

        // Data validation
        $validated = $request->validate([
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'tackle' => 'required|string|max:255',
            'bait' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'temperature' => 'nullable|numeric|min:-60|max:60',
            'weather_condition' => 'nullable|string|max:100',
            'wind_speed' => 'nullable|numeric|min:0|max:100',
            'pressure' => 'nullable|integer|min:600|max:900',
            'humidity' => 'nullable|integer|min:0|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'trophy_species' => 'nullable|string|max:255',
            'trophy_weight' => 'nullable|numeric|min:0|max:999.99',
        ]);

        if (!$request->location && !$request->latitude) {
            return back()->withErrors(['location' => 'Please enter a location or select a point on the map.'])->withInput();
        }

        // If a photo is uploaded, save it.
        $photo = $request->file('photo');
        if ($photo && $photo->isValid()) {
            $validated['photo'] = $photo->store('catches', 'public');
        }

        // Add the user_id of the current user
        $validated['user_id'] = auth()->id();
        FishCatch::create($validated);

        // Получаем данные о погоде через сервис
        // $weatherData = $this->weatherService->getManual($validated);

        // Объединяем данные улова и погоды
        //\App\Models\FishCatch::create($validated);

        // Редирект на список уловов с сообщением
        return redirect('/catches')->with('success', 'Catch added successfully!');
    }

    /**
     * Display the specified catch.
     */
    public function show(string $id)
    {
        $catch = FishCatch::findOrFail($id);

        return view('catches.show', compact('catch'));
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
        // Finding the catch
        $catch = FishCatch::findOrFail($id);



        // Data validation
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

        // Deleting photos
        if ($request->has('remove_photo') && $catch->photo) {
            Storage::disk('public')->delete($catch->photo);
            $validated['photo'] = null;
        }

        // New photo
        $files = $request->allFiles();
        if (isset($files['photo'])) {
            $photo = $files['photo'];
            if ($catch->photo) {
                Storage::disk('public')->delete($catch->photo);
            }
            $validated['photo'] = $photo->store('catches', 'public');
        }

        // Updating data
        $catch->update($validated);

        return redirect('/catches')->with('success', 'Catch updated successfully!');
    }

    public function stats(Request $request)
    {
        $period = $request->input('period', 'month');
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        if ($period === 'month') {
            $startDate = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        } else {
            $startDate = now()->subYear();
            $endDate = now();
        }

        $catches = FishCatch::where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        $chartData = $catches->groupBy(function ($catch) use ($period) {
            return $period === 'year'
                ? $catch->date->format('Y-m')
                : $catch->date->format('Y-m-d');
        })->map(fn($group) => $group->count());

        // Generate a list of years to choose from
        $years = FishCatch::where('user_id', auth()->id())
            ->selectRaw('strftime("%Y", date) as year')
            ->distinct()
            ->pluck('year')
            ->sortDesc();

        return view('catches.stats', compact('chartData', 'period', 'month', 'year', 'years'));
    }

    /**
     * Remove the specified catch from storage.
     */
    public function destroy(string $id)
    {
        // Find the catch by ID; if not found, it will automatically return a 404
        $catch = FishCatch::findOrFail($id);
        // We check that this is the catch of this particular user.
        if ($catch->user_id !== auth()->id()) {
            abort(403);
        }
        // Deleting a record from the database
        $catch->delete();

        // Redirect to the list with a success message
        return redirect('/catches')->with('success', 'Catch deleted successfully!');
    }

    public function dashboard()
    {
        $userId = auth()->id();

        // General statistics
        $totalCatches = FishCatch::where('user_id', $userId)->count();

        // The best trophy
        $bestTrophy = FishCatch::where('user_id', $userId)
            ->whereNotNull('trophy_weight')
            ->orderBy('trophy_weight', 'desc')
            ->first();

        // Favorite location
        $topLocation = FishCatch::where('user_id', $userId)
            ->whereNotNull('location')
            ->selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->first();

        // Last 3 catches
        $recentCatches = FishCatch::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->limit(3)
            ->get();

        // Graphics for the month
        $chartData = FishCatch::where('user_id', $userId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->orderBy('date')
            ->get()
            ->groupBy(fn($catch) => $catch->date->format('Y-m-d'))
            ->map(fn($group) => $group->count());

        return view('dashboard', compact(
            'totalCatches',
            'bestTrophy',
            'topLocation',
            'recentCatches',
            'chartData'
        ));
    }
}
