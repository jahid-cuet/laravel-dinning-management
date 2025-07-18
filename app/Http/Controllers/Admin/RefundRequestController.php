<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\RefundRequest;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RefundRequestExport;
use App\Models\DinningMonth;
use App\Models\DinningStudent;
use App\Models\Meal;
use App\Models\RefundMeal;
use Carbon\Carbon;

class RefundRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:refund-request-view|refund-request-create|refund-request-update|refund-request-delete', ['only' => ['index']]);
        $this->middleware('permission:refund-request-create', ['only' => ['create','store']]);
        $this->middleware('permission:refund-request-update', ['only' => ['edit','update']]);
        $this->middleware('permission:refund-request-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Refund Request';
        $info=new stdClass();
        $info->title = 'Refund Requests';
        $info->first_button_title = 'Add Refund Request';
        $info->first_button_route = 'admin.refund-requests.create';
        $info->route_index = 'admin.refund-requests.index';
        $info->description = 'These all are Refund Requests';


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = RefundRequest::with('dinningStudent');

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','status','total_meal','total_amount'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        $data =$data->orderBy('id', 'DESC');
        $data =$data->paginate($per_page);

        return view('admin.refund-requests.index', compact('page_title', 'data', 'info','per_page'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Refund Request Create';
        $info=new stdClass();
        $info->title = 'Refund Requests';
        $info->first_button_title = 'All Refund Request';
        $info->first_button_route = 'admin.refund-requests.index';
        $info->form_route = 'admin.refund-requests.store';


    $student = DinningStudent::where('user_id', auth()->id())->first();



    $meals = Meal::where('dinning_student_id', $student->id)
    ->where('meal_date', '>', Carbon::today()) // Only future meals
    ->orderBy('meal_date', 'ASC')
    ->get();


        return view('admin.refund-requests.create',compact('page_title','info','meals'));
    }

    public function store(Request $request)
    {
        
 $student = DinningStudent::where('user_id', auth()->id())->first();

    $mealsInput = $request->input('meals');
$mealRate = DinningMonth::find($student->dinning_month_id)?->meal_rate ?? 0;
    $totalMeals = 0;

    $refund = RefundRequest::create([
        'dinning_student_id' => $student->id,
        'status' => 'Pending'
    ]);

foreach ($mealsInput as $mealId => $mealData) {
    $meal = Meal::find($mealId);
    if (!$meal) continue;

    $lunch = isset($mealData['lunch']) ? 1 : 0;
    $dinner = isset($mealData['dinner']) ? 1 : 0;

    if ($lunch || $dinner) {
        RefundMeal::create([
            'refund_request_id' => $refund->id,
            'meal_date' => $meal->meal_date,
            'lunch' => $lunch,
            'dinner' => $dinner,
        ]);
        $totalMeals += $lunch + $dinner;
    }
}


    $refund->total_meal = $totalMeals;
    $refund->total_amount = $totalMeals * $mealRate;
    $refund->save();
        
        return redirect()->route('admin.refund-requests.index')
        ->with('success','Refund Request created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Refund Request Details';
        $info = new stdClass();
        $info->title = 'Refund Requests Details';
        $info->first_button_title = 'Edit Refund Request';
        $info->first_button_route = 'admin.refund-requests.edit';
        $info->second_button_title = 'All Refund Request';
        $info->second_button_route = 'admin.refund-requests.index';
        $info->description = '';


        $data = RefundRequest::findOrFail($id);


        return view('admin.refund-requests.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Refund Request Edit';
        $info=new stdClass();
        $info->title = 'Refund Requests';
        $info->first_button_title = 'Add Refund Request';
        $info->first_button_route = 'admin.refund-requests.create';
        $info->second_button_title = 'All Refund Request';
        $info->second_button_route = 'admin.refund-requests.index';
        $info->form_route = 'admin.refund-requests.update';
        $info->route_destroy = 'admin.refund-requests.destroy';

        $data=RefundRequest::where('id',$id)->first();

        return view('admin.refund-requests.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'status' => 'required|string',
                    
            'total_meal' => 'required|integer',
                    
            'total_amount' => 'required|integer',
                    
            'dinning_student_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = RefundRequest::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->status=$request->status;
        
        $row->total_meal=$request->total_meal;
        
        $row->total_amount=$request->total_amount;
        
        $row->dinning_student_id=$request->dinning_student_id;
        
        $row->save();
        
        return redirect()->route('admin.refund-requests.show',$id)
        ->with('success','Refund Request updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=RefundRequest::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.refund-requests.index')
        ->with('success','Refund Request deleted successfully!');
    }
}