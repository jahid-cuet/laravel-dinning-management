<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\RefundMeal;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RefundMealExport;
use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;

class RefundMealController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:refund-meal-view|refund-meal-create|refund-meal-update|refund-meal-delete', ['only' => ['index']]);
        $this->middleware('permission:refund-meal-create', ['only' => ['create','store']]);
        $this->middleware('permission:refund-meal-update', ['only' => ['edit','update']]);
        $this->middleware('permission:refund-meal-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Today"s Meal';
        $info=new stdClass();
        $info->title = 'Today"s Meal';
        $info->first_button_title = 'Add Today Meal';
        $info->first_button_route = 'admin.refund-meals.create';
        $info->route_index = 'admin.refund-meals.index';
        $info->description = 'These all are Today"s Meals';

        $per_page =request('per_page', 20);
        $with_data=[];


$today = Carbon::today()->toDateString();

// Query unique user IDs who have meals today
$data = Meal::where('meal_date', $today)
    ->distinct('user_id') // get one meal per user
    ->orderBy('id', 'DESC')
    ->paginate($per_page);
// Now paginate the users based on those IDs


return view('admin.refund-meals.index', compact('page_title', 'data', 'info', 'per_page'))
    ->with($with_data);
    }


    public function create()
    {
        $page_title = 'Refund Meal Create';
        $info=new stdClass();
        $info->title = 'Refund Meals';
        $info->first_button_title = 'All Refund Meal';
        $info->first_button_route = 'admin.refund-meals.index';
        $info->form_route = 'admin.refund-meals.store';

        return view('admin.refund-meals.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'meal_date' => 'required|date',
                    
            'lunch' => 'nullable|integer',
                    
            'dinner' => 'nullable|integer',
                    
            'refund_request_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new RefundMeal;
        
        $row->meal_date = $request->meal_date;
        
        $row->refund_request_id = $request->refund_request_id;
        
            $row->lunch=$request->lunch? 1:0;
        
            $row->dinner=$request->dinner? 1:0;
        
        $row->save();
        
        return redirect()->route('admin.refund-meals.index')
        ->with('success','Refund Meal created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Refund Meal Details';
        $info = new stdClass();
        $info->title = 'Refund Meals Details';
        $info->first_button_title = 'Edit Refund Meal';
        $info->first_button_route = 'admin.refund-meals.edit';
        $info->second_button_title = 'All Refund Meal';
        $info->second_button_route = 'admin.refund-meals.index';
        $info->description = '';


        $data = RefundMeal::findOrFail($id);


        return view('admin.refund-meals.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Refund Meal Edit';
        $info=new stdClass();
        $info->title = 'Refund Meals';
        $info->first_button_title = 'Add Refund Meal';
        $info->first_button_route = 'admin.refund-meals.create';
        $info->second_button_title = 'All Refund Meal';
        $info->second_button_route = 'admin.refund-meals.index';
        $info->form_route = 'admin.refund-meals.update';
        $info->route_destroy = 'admin.refund-meals.destroy';

        $data=RefundMeal::where('id',$id)->first();

        return view('admin.refund-meals.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'meal_date' => 'required|date',
                    
            'lunch' => 'nullable|integer',
                    
            'dinner' => 'nullable|integer',
                    
            'refund_request_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = RefundMeal::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->meal_date=$request->meal_date;
        
        $row->refund_request_id=$request->refund_request_id;
        
            $row->lunch=$request->lunch? 1:0;
        
            $row->dinner=$request->dinner? 1:0;
        
        $row->save();
        
        return redirect()->route('admin.refund-meals.show',$id)
        ->with('success','Refund Meal updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=RefundMeal::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.refund-meals.index')
        ->with('success','Refund Meal deleted successfully!');
    }
}