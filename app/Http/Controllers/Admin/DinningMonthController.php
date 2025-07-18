<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\DinningMonth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DinningMonthExport;
use App\Models\DinningStudent;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;

class DinningMonthController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dinning-month-view|dinning-month-create|dinning-month-update|dinning-month-delete', ['only' => ['index']]);
        $this->middleware('permission:dinning-month-create', ['only' => ['create','store']]);
        $this->middleware('permission:dinning-month-update', ['only' => ['edit','update']]);
        $this->middleware('permission:dinning-month-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Dinning Month';
        $info=new stdClass();
        $info->title = 'Dinning Months';
        $info->first_button_title = 'Add Dinning Month';
        $info->first_button_route = 'admin.dinning-months.create';
        $info->route_index = 'admin.dinning-months.index';
        $info->description = 'These all are Dinning Months';


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = DinningMonth::query();

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','title','meal_rate','from','to'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        

        
        if($request->export_table)
        {
            $filePath='DinningMonths.csv';
            $export_data=$data->get();
            $excel_data=new DinningMonthExport($export_data);
            return Excel::download($excel_data, $filePath);
        }
        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->paginate($per_page);


    $months = DinningMonth::orderBy('id', 'DESC')->paginate($per_page);

    // Calculate total meals for each month based on meal_date within month range
    foreach ($months as $month) {
        $totalMeals = Meal::whereDate('meal_date', '>=', $month->from)
                        ->whereDate('meal_date', '<=', $month->to)
                        ->sum(DB::raw('lunch + dinner'));

        $month->total_meals = $totalMeals;

        // Also get total students for this month
        $totalStudents = DinningStudent::where('dinning_month_id', $month->id)->count();
        $month->total_students = $totalStudents;

        // Calculate total cost
        $month->total_cost = $month->meal_rate * $totalMeals;
    }

        return view('admin.dinning-months.index', compact('page_title', 'data', 'info','per_page','months'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Dinning Month Create';
        $info=new stdClass();
        $info->title = 'Dinning Months';
        $info->first_button_title = 'All Dinning Month';
        $info->first_button_route = 'admin.dinning-months.index';
        $info->form_route = 'admin.dinning-months.store';
        $students = DinningStudent::all() ?? collect();

        return view('admin.dinning-months.create',compact('page_title','info','students'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'title' => 'required|string',
                    
            'meal_rate' => 'required|integer',
                    
            'from' => 'required|date',
                    
            'to' => 'required|date',
                    
            'user_id' => 'nullable|integer',
                    
            // 'dinning_student_id' => 'required|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new DinningMonth;
        
        $row->title = $request->title;
        
        $row->meal_rate = $request->meal_rate;
        
        $row->from = $request->from;
        
        $row->to = $request->to;
        
        $row->user_id = $request->user_id;
        
        $row->dinning_student_id = $request->dinning_student_id;
        
        $row->save();
        
        return redirect()->route('admin.dinning-months.index')
        ->with('success','Dinning Month created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Dinning Month Details';
        $info = new stdClass();
        $info->title = 'Dinning Months Details';
        $info->first_button_title = 'Edit Dinning Month';
        $info->first_button_route = 'admin.dinning-months.edit';
        $info->second_button_title = 'All Dinning Month';
        $info->second_button_route = 'admin.dinning-months.index';
        $info->description = '';


        $data = DinningMonth::findOrFail($id);


        return view('admin.dinning-months.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Dinning Month Edit';
        $info=new stdClass();
        $info->title = 'Dinning Months';
        $info->first_button_title = 'Add Dinning Month';
        $info->first_button_route = 'admin.dinning-months.create';
        $info->second_button_title = 'All Dinning Month';
        $info->second_button_route = 'admin.dinning-months.index';
        $info->form_route = 'admin.dinning-months.update';
        $info->route_destroy = 'admin.dinning-months.destroy';

        $data=DinningMonth::where('id',$id)->first();

        return view('admin.dinning-months.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'title' => 'required|string',
                    
            'meal_rate' => 'required|integer',
                    
            'from' => 'required|date',
                    
            'to' => 'required|date',
                    
            'user_id' => 'nullable|integer',
                    
            'dinning_student_id' => 'required|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = DinningMonth::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->title=$request->title;
        
        $row->meal_rate=$request->meal_rate;
        
        $row->from=$request->from;
        
        $row->to=$request->to;
        
        $row->user_id=$request->user_id;
        
        $row->dinning_student_id=$request->dinning_student_id;
        
        $row->save();
        
        return redirect()->route('admin.dinning-months.show',$id)
        ->with('success','Dinning Month updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=DinningMonth::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.dinning-months.index')
        ->with('success','Dinning Month deleted successfully!');
    }
}