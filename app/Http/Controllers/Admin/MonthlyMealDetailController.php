<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\MonthlyMealDetail;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyMealDetailExport;
use App\Models\DinningMonth;
use App\Models\DinningStudent;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;

class MonthlyMealDetailController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:monthly-meal-detail-view|monthly-meal-detail-create|monthly-meal-detail-update|monthly-meal-detail-delete', ['only' => ['index']]);
        $this->middleware('permission:monthly-meal-detail-create', ['only' => ['create','store']]);
        $this->middleware('permission:monthly-meal-detail-update', ['only' => ['edit','update']]);
        $this->middleware('permission:monthly-meal-detail-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Monthly Meal Detail';
        $info=new stdClass();
        $info->title = 'Monthly Meal Details';
        $info->first_button_title = 'Add Monthly Meal Detail';
        $info->first_button_route = 'admin.monthly-meal-details.create';
        $info->route_index = 'admin.monthly-meal-details.index';
        $info->description = 'These all are Monthly Meal Details';


        $per_page = request('per_page', 20);
        $with_data=[];


    $userId = auth()->user()->id;
    $student = DinningStudent::where('user_id', $userId)->first();

    if (!$student) {
        abort(404, 'Student not found');
    }

    $dinningMonth = DinningMonth::find($student->dinning_month_id);

    if (!$dinningMonth) {
        abort(404, 'Dinning Month not found');
    }

    // Meal date range based on month
    $from = $dinningMonth->from;
    $to = $dinningMonth->to;

    // Daily summary
    $data = Meal::selectRaw('meal_date,
                COUNT(DISTINCT dinning_student_id) as students,
                SUM(lunch + dinner) as meals,
                SUM(lunch) as total_lunch,
                SUM(dinner) as total_dinner')
        ->whereBetween('meal_date', [$from, $to])
        ->groupBy('meal_date')
        ->orderBy('meal_date', 'ASC')
        ->paginate($per_page);

    // Monthly total
    $total_meals = Meal::whereBetween('meal_date', [$from, $to])
        ->sum(DB::raw('lunch + dinner'));

    $total_lunch = Meal::whereBetween('meal_date', [$from, $to])
        ->sum('lunch');

    $total_dinner = Meal::whereBetween('meal_date', [$from, $to])
        ->sum('dinner');

    return view('admin.monthly-meal-details.index', compact(
        'page_title',
        'info',
        'data',
        'total_meals',
        'total_lunch',
        'total_dinner',
        'per_page'
    ))->with($with_data);



        
    }

    public function create()
    {
        $page_title = 'Monthly Meal Detail Create';
        $info=new stdClass();
        $info->title = 'Monthly Meal Details';
        $info->first_button_title = 'All Monthly Meal Detail';
        $info->first_button_route = 'admin.monthly-meal-details.index';
        $info->form_route = 'admin.monthly-meal-details.store';

        return view('admin.monthly-meal-details.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'gender' => 'nullable|string|in:male,female',
                    
            'user_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new MonthlyMealDetail;
        
        $row->gender = $request->gender;
        
        $row->user_id = $request->user_id;
        
        $row->save();
        
        return redirect()->route('admin.monthly-meal-details.index')
        ->with('success','Monthly Meal Detail created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Monthly Meal Detail Details';
        $info = new stdClass();
        $info->title = 'Monthly Meal Details Details';
        $info->first_button_title = 'Edit Monthly Meal Detail';
        $info->first_button_route = 'admin.monthly-meal-details.edit';
        $info->second_button_title = 'All Monthly Meal Detail';
        $info->second_button_route = 'admin.monthly-meal-details.index';
        $info->description = '';


        $data = MonthlyMealDetail::findOrFail($id);


        return view('admin.monthly-meal-details.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Monthly Meal Detail Edit';
        $info=new stdClass();
        $info->title = 'Monthly Meal Details';
        $info->first_button_title = 'Add Monthly Meal Detail';
        $info->first_button_route = 'admin.monthly-meal-details.create';
        $info->second_button_title = 'All Monthly Meal Detail';
        $info->second_button_route = 'admin.monthly-meal-details.index';
        $info->form_route = 'admin.monthly-meal-details.update';
        $info->route_destroy = 'admin.monthly-meal-details.destroy';

        $data=MonthlyMealDetail::where('id',$id)->first();

        return view('admin.monthly-meal-details.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'gender' => 'nullable|string|in:male,female',
                    
            'user_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = MonthlyMealDetail::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->gender=$request->gender;
        
        $row->user_id=$request->user_id;
        
        $row->save();
        
        return redirect()->route('admin.monthly-meal-details.show',$id)
        ->with('success','Monthly Meal Detail updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=MonthlyMealDetail::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.monthly-meal-details.index')
        ->with('success','Monthly Meal Detail deleted successfully!');
    }
}