<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\Meal;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MealExport;
use App\Models\DinningStudent;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:meal-view|meal-create|meal-update|meal-delete', ['only' => ['index']]);
        $this->middleware('permission:meal-create', ['only' => ['create','store']]);
        $this->middleware('permission:meal-update', ['only' => ['edit','update']]);
        $this->middleware('permission:meal-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Meal';
        $info=new stdClass();
        $info->title = 'Meals';
        $info->first_button_title = 'Add Meal';
        $info->first_button_route = 'admin.meals.create';
        $info->route_index = 'admin.meals.index';
        $info->description = 'These all are today"s Meals';


        $today = date('Y-m-d');

        // Fetch today's total counts
        $total_meals = Meal::whereDate('meal_date', $today)->sum(DB::raw('lunch + dinner'));
        $total_lunch = Meal::whereDate('meal_date', $today)->sum('lunch');
        $total_dinner = Meal::whereDate('meal_date', $today)->sum('dinner');


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = Meal::with([
        'dinningStudent.department',
        'dinningStudent.studentSession'
    ])
    ->whereDate('meal_date', $today)
    ->orderBy('id', 'DESC')      // move this BEFORE get()
    ->paginate($per_page); 

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','meal_date','lunch','dinner'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        

        

      // paginate before get(), no need to call get()

// Return to view
return view('admin.meals.index', compact('page_title', 'data', 'info', 'per_page', 'total_meals', 'total_lunch', 'total_dinner'))->with($with_data);

        
    }


    public function create()
    {
        $page_title = 'Meal Create';
        $info=new stdClass();
        $info->title = 'Meals';
        $info->first_button_title = 'All Meal';
        $info->first_button_route = 'admin.meals.index';
        $info->form_route = 'admin.meals.store';

        return view('admin.meals.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'meal_date' => 'required|date',
                    
            'lunch' => 'required|integer',
                    
            'dinner' => 'required|integer',
                    
            'dinning_student_id' => 'required|integer',
                    
            // 'dinning_month_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new Meal;
        
        $row->meal_date = $request->meal_date;
        
        $row->dinning_student_id = $request->dinning_student_id;
        
        // $row->dinning_month_id = $request->dinning_month_id;
        
        $row->lunch=$request->lunch? 1:0;
        
        $row->dinner=$request->dinner? 1:0;
        
        $row->save();
        
        return redirect()->route('admin.meals.index')
        ->with('success','Meal created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Meal Details';
        $info = new stdClass();
        $info->title = 'Meals Details';
        $info->first_button_title = 'Edit Meal';
        $info->first_button_route = 'admin.meals.edit';
        $info->second_button_title = 'All Meal';
        $info->second_button_route = 'admin.meals.index';
        $info->description = '';


        $data = Meal::findOrFail($id);


        return view('admin.meals.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Meal Edit';
        $info=new stdClass();
        $info->title = 'Meals';
        $info->first_button_title = 'Add Meal';
        $info->first_button_route = 'admin.meals.create';
        $info->second_button_title = 'All Meal';
        $info->second_button_route = 'admin.meals.index';
        $info->form_route = 'admin.meals.update';
        $info->route_destroy = 'admin.meals.destroy';

        $data=Meal::where('id',$id)->first();

        return view('admin.meals.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'meal_date' => 'required|date',
                    
            'lunch' => 'required|integer',
                    
            'dinner' => 'required|integer',
                    
            'dinning_student_id' => 'required|integer',
                    
            // 'dinning_month_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = Meal::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->meal_date=$request->meal_date;
        
        $row->dinning_student_id=$request->dinning_student_id;
        
        // $row->dinning_month_id=$request->dinning_month_id;
        
            $row->lunch=$request->lunch? 1:0;
        
            $row->dinner=$request->dinner? 1:0;
        
        $row->save();
        
        return redirect()->route('admin.meals.show',$id)
        ->with('success','Meal updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=Meal::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.meals.index')
        ->with('success','Meal deleted successfully!');
    }
}