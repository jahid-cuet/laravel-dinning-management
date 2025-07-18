<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\MealToken;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MealTokenExport;
use App\Models\DinningStudent;
use App\Models\Meal;

class MealTokenController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:meal-token-view|meal-token-create|meal-token-update|meal-token-delete', ['only' => ['index']]);
        $this->middleware('permission:meal-token-create', ['only' => ['create','store']]);
        $this->middleware('permission:meal-token-update', ['only' => ['edit','update']]);
        $this->middleware('permission:meal-token-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Meal Token';
        $info=new stdClass();
        $info->title = 'Meal Tokens';
        $info->first_button_title = 'Add Meal Token';
        $info->first_button_route = 'admin.meal-tokens.create';
        $info->route_index = 'admin.meal-tokens.index';
        $info->description = 'These all are Meal Tokens';


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = MealToken::query();

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','token_number','time_type','dinning_date','dinning_time'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        

        
        if($request->export_table)
        {
            $filePath='MealTokens.csv';
            $export_data=$data->get();
            $excel_data=new MealTokenExport($export_data);
            return Excel::download($excel_data, $filePath);
        }
        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->paginate($per_page);

        return view('admin.meal-tokens.index', compact('page_title', 'data', 'info','per_page'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Meal Token Create';
        $info=new stdClass();
        $info->title = 'Meal Tokens';
        $info->first_button_title = 'All Meal Token';
        $info->first_button_route = 'admin.meal-tokens.index';
        $info->form_route = 'admin.meal-tokens.store';


    $now = Carbon::now()->setTimezone('Asia/Dhaka')->format('d/m/Y h:i A');
    $meal_time = Carbon::now()->setTimezone('Asia/Dhaka')->hour >= 17 ? "Dinner time" : "Lunch time";



    return view('admin.meal-tokens.create',compact('page_title','info','now','meal_time'));
    }

    public function store(Request $request)
    {
        
        // $validation_rules=[
        //     'token_number' => [
        //         'required',
        //         'string',
        //         Rule::unique('meal_tokens', 'token_number'),
        //     ],
                    
        //     'time_type' => 'required|string',
                    
        //     'dinning_date' => 'required|date',
                    
        //     'dinning_time' => 'required|date_format:H:i',
                    
        //     'dinning_student_id' => 'nullable|integer',
                    
        // ];
        // $this->validate($request, $validation_rules);
        // $row =new MealToken;
        
        // $row->token_number = $request->token_number;
        
        // $row->time_type = $request->time_type;
        
        // $row->dinning_date = $request->dinning_date;
        
        // $row->dinning_time = $request->dinning_time;
        
        // $row->dinning_student_id = $request->dinning_student_id;
        
        // $row->save();
        
        // return redirect()->route('admin.meal-tokens.index')
        // ->with('success','Meal Token created successfully!');





         $student = DinningStudent::where('student_id', $request->student_id)->first();

    if (!$student) {
        return response()->json(['status' => 'error', 'message' => 'Invalid Student ID.']);
    }

    $today = Carbon::now('Asia/Dhaka')->format('Y-m-d');

    $meal = Meal::where('dinning_student_id', $student->id)
                ->whereDate('meal_date', $today)
                ->first();

    if (!$meal) {
        return response()->json(['status' => 'error', 'message' => 'No meal booked for today.']);
    }

    // Determine meal time based on current time
    $now = Carbon::now('Asia/Dhaka');
    if ($now->format('H:i') >= '06:00' && $now->format('H:i') <= '14:00') {
        $mealTime = 'Lunch';
    } elseif ($now->format('H:i') >= '18:00' && $now->format('H:i') <= '23:59') {
        $mealTime = 'Dinner';
    } else {
        $mealTime = 'Unknown';
    }

return response()->json([
    'status'   => 'success',
    'student'  => $student->name,
    'student_id' => $student->student_id,
    'meal_id'  => $meal->id,
    'meal_date'=> $meal->meal_date,
    'mealTime' => $mealTime
]);
    }

    public function show($id)
    {
        
        $page_title = 'Meal Token Details';
        $info = new stdClass();
        $info->title = 'Meal Tokens Details';
        $info->first_button_title = 'Edit Meal Token';
        $info->first_button_route = 'admin.meal-tokens.edit';
        $info->second_button_title = 'All Meal Token';
        $info->second_button_route = 'admin.meal-tokens.index';
        $info->description = '';


        $data = MealToken::findOrFail($id);


        return view('admin.meal-tokens.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Meal Token Edit';
        $info=new stdClass();
        $info->title = 'Meal Tokens';
        $info->first_button_title = 'Add Meal Token';
        $info->first_button_route = 'admin.meal-tokens.create';
        $info->second_button_title = 'All Meal Token';
        $info->second_button_route = 'admin.meal-tokens.index';
        $info->form_route = 'admin.meal-tokens.update';
        $info->route_destroy = 'admin.meal-tokens.destroy';

        $data=MealToken::where('id',$id)->first();

        return view('admin.meal-tokens.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'token_number' => [
                'required',
                'string',
                Rule::unique('meal_tokens', 'token_number')->ignore($id),
            ],
                    
            'time_type' => 'required|string',
                    
            'dinning_date' => 'required|date',
                    
            'dinning_time' => 'required|date_format:H:i',
                    
            'dinning_student_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = MealToken::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->token_number=$request->token_number;
        
        $row->time_type=$request->time_type;
        
        $row->dinning_date=$request->dinning_date;
        
        $row->dinning_time=$request->dinning_time;
        
        $row->dinning_student_id=$request->dinning_student_id;
        
        $row->save();
        
        return redirect()->route('admin.meal-tokens.show',$id)
        ->with('success','Meal Token updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=MealToken::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.meal-tokens.index')
        ->with('success','Meal Token deleted successfully!');
    }



public function validateTokenAjax(Request $request)
{
    $student = DinningStudent::where('student_id', $request->student_id)->first();

    if (!$student) {
        return response()->json(['status' => 'error', 'message' => 'Invalid Student ID.']);
    }

    $today = Carbon::now('Asia/Dhaka')->format('Y-m-d');

    $meal = Meal::where('dinning_student_id', $student->id)
                ->whereDate('meal_date', $today)
                ->first();

    if (!$meal) {
        return response()->json(['status' => 'error', 'message' => 'No meal booked for today.']);
    }

    // Determine meal time based on current time
    $now = Carbon::now('Asia/Dhaka');
    if ($now->format('H:i') >= '06:00' && $now->format('H:i') <= '14:00') {
        $mealTime = 'Lunch';
    } elseif ($now->format('H:i') >= '18:00' && $now->format('H:i') <= '23:59') {
        $mealTime = 'Dinner';
    } else {
        $mealTime = 'Unknown';
    }

    return response()->json([
        'status' => 'success',
        'student' => $student->name,
        'mealTime' => $mealTime,
        'lunch'    => $meal->lunch,
        'dinner'   => $meal->dinner
    ]);
}

}