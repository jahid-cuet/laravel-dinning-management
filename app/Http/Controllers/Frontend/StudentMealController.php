<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DinningMonth;
use App\Models\DinningStudent;
use App\Models\Meal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentMealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $per_page = request('per_page', 20);
        $with_data=[];
        
    $month = DinningMonth::latest()->first();
    if (!$month) {
        return redirect()->back()->with('error', 'No active month found.');
    }

$mealRate = $month->meal_rate; // adjust logic to get correct month


    // Start from today or from_date (whichever is later)
    $from = Carbon::parse($month->from);
    $today = Carbon::today();
    $startDate = $from->greaterThan($today) ? $from : $today;

    $to = Carbon::parse($month->to);
    $period = CarbonPeriod::create($startDate, $to);

// $student = DinningStudent::where('user_id', auth()->id())->first();


// Now it's safe to use $student->id
$meals = Meal::whereBetween('meal_date', [$startDate, $to])
    ->get()
    ->keyBy('meal_date');

        $data = DinningMonth::query();

        $data =$data->orderBy('id', 'DESC');

        $data =$data->paginate($per_page);

    $months = DinningMonth::orderBy('id', 'DESC')->paginate($per_page);

    return view('Frontend.available-meal', compact('per_page','month','period', 'meals','mealRate'))->with($with_data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    // You should validate input here (optional)
    $data = $request->validate([
        'meals' => 'array',
        'meals.*.lunch' => 'nullable|in:1',
        'meals.*.dinner' => 'nullable|in:1',
        // 'dinning_month_id' => 'required|exists:dinning_months,id',
    ]);

    // Set your student and month IDs however you get them
    $userId = auth()->user()->id; // example: logged-in user id

    foreach ($data['meals'] ?? [] as $date => $meals) {
        // Find existing or create new record for this date, student, and month
        $meal = DB::table('meals')->where([
            ['meal_date', '=', $date],
            ['user_id', '=', $userId],
        ])->first();

        if ($meal) {
            // Update existing
            DB::table('meals')->where('id', $meal->id)->update([
                'lunch' => isset($meals['lunch']) ? 1 : 0,
                'dinner' => isset($meals['dinner']) ? 1 : 0,
            ]);
        } else {
            // Insert new
            DB::table('meals')->insert([
                'meal_date' => $date,
                'lunch' => isset($meals['lunch']) ? 1 : 0,
                'dinner' => isset($meals['dinner']) ? 1 : 0,
                'user_id' => $userId,
                'dinning_month_id' => $request->dinning_month_id,
                'order' => 0,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Meal selections saved successfully.');
}

    

    /**
     * Display the specified resource.
     */
    public function monthlyMealDetails()
    {

      $month = DinningMonth::latest()->first();

if (!$month) {
    return redirect()->back()->with('error', 'No active month found.');
}

$meals = DB::table('meals')
    ->select(
        'meal_date',
        DB::raw('COUNT(DISTINCT user_id) as students'),
        DB::raw('SUM(CASE WHEN lunch = 1 THEN 1 ELSE 0 END) as total_lunch'),
        DB::raw('SUM(CASE WHEN dinner = 1 THEN 1 ELSE 0 END) as total_dinner'),
        DB::raw('SUM(CASE WHEN lunch = 1 THEN 1 ELSE 0 END + CASE WHEN dinner = 1 THEN 1 ELSE 0 END) as total_meals')
    )
    ->whereBetween('meal_date', [$month->from, $month->to])
    ->groupBy('meal_date')
    ->orderBy('meal_date', 'asc')
    ->get();

    return view('Frontend.monthlyMealDetails', compact('meals'));
    
    }


    public function dailyMealDetails($date)
{
    // Fetch all meals for the given date
    $meals = Meal::where('meal_date', $date)
        ->get();

    $totalLunch = $meals->where('lunch', 1)->count();
    $totalDinner = $meals->where('dinner', 1)->count();
    $totalMeals = $totalLunch + $totalDinner;
    $uniqueStudents = $meals->pluck('user_id')->unique()->count();

    return view('Frontend.daily-meal-details', compact(
        'meals', 'totalLunch', 'totalDinner', 'totalMeals', 'uniqueStudents', 'date'
    ));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
