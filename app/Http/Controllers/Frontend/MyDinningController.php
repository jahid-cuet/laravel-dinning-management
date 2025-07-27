<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DinningMonth;
use App\Models\Meal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class MyDinningController extends Controller
{
    public function index(){

        $per_page = request('per_page', 20);
        $with_data=[];
        
    $month = DinningMonth::latest()->first();

    if (!$month) {
        return redirect()->back()->with('error', 'No active month found.');
    }

    $from = Carbon::parse($month->from);
    $to = Carbon::parse($month->to);

    // Get all meals of the user in that month
    $meals = Meal::where('user_id', auth()->id())
                ->whereBetween('meal_date', [$from, $to])
                ->get()
                ->keyBy(function ($meal) {
                    return Carbon::parse($meal->meal_date)->format('Y-m-d');
                });

    // Create full period of month (even if user didn't select meal for that date)
    $period = CarbonPeriod::create($from, $to);


    $months = DinningMonth::orderBy('id', 'DESC')->paginate($per_page);

    return view('Frontend.my-dinning', compact('per_page','months', 'meals','period'))->with($with_data);

    }
}
