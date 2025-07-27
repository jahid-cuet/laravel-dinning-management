<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DinningMonth;
use App\Models\Meal;
use App\Models\RefundMeal;
use App\Models\RefundRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentRefundRequestController extends Controller
{
    public function index()
{

     $userId = auth()->id();

    $dinning_month = DinningMonth::latest()->first();
    $mealRate = $dinning_month->meal_rate;

    // Get all dates from from → to
    $dates = [];
    $start = Carbon::parse($dinning_month->from);
    $end = Carbon::parse($dinning_month->to);

    while ($start->lte($end)) {
        $dates[] = $start->toDateString();
        $start->addDay();
    }

    // Get meals from DB
    $meals = Meal::where('user_id', $userId)
        ->whereBetween('meal_date', [$dinning_month->from, $dinning_month->to])
        ->get()
        ->keyBy('meal_date')
        ->map(fn($meal) => [
            'lunch' => $meal->lunch,
            'dinner' => $meal->dinner,
        ]);

    return view('Frontend.refund-request', compact('dates','dinning_month','meals','mealRate'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'dinning_month_id' => 'required|exists:dinning_months,id',
        'meals' => 'required|array',
    ]);

    $userId = Auth::id();
    $mealInputs = $validated['meals'];
    $dinningMonth = DinningMonth::findOrFail($validated['dinning_month_id']);

    DB::transaction(function () use ($mealInputs, $userId, $dinningMonth) {
        $totalMeals = 0;

        foreach ($mealInputs as $date => $types) {
            $meal = Meal::where('user_id', $userId)
                        ->whereDate('meal_date', $date)
                        ->first();

            if (!$meal) continue;

            $updates = [];

            if (isset($types['lunch']) && $meal->lunch == 1) {
                $updates['lunch'] = 0;
                $totalMeals++;
            }

            if (isset($types['dinner']) && $meal->dinner == 1) {
                $updates['dinner'] = 0;
                $totalMeals++;
            }

            if (!empty($updates)) {
                $meal->update($updates);
            }
        }

        RefundRequest::create([
            'user_id' => $userId,
            'dinning_month_id' => $dinningMonth->id,
            'total_meal' => $totalMeals,
            'total_amount' => $totalMeals * $dinningMonth->meal_rate,
            'status' => 'Refunded',
        ]);
    });

    return redirect()->route('student.refund-request.index')->with('success', 'Refund request submitted!');
}


}
