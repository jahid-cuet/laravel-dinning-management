<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\DinningStudent;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DinningStudentExport;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DinningStudentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dinning-student-view|dinning-student-create|dinning-student-update|dinning-student-delete', ['only' => ['index']]);
        $this->middleware('permission:dinning-student-create', ['only' => ['create','store']]);
        $this->middleware('permission:dinning-student-update', ['only' => ['edit','update']]);
        $this->middleware('permission:dinning-student-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Dinning Student';
        $info=new stdClass();
        $info->title = 'Dinning Students';
        $info->first_button_title = 'Add Dinning Student';
        $info->first_button_route = 'admin.dinning-students.create';
        $info->route_index = 'admin.dinning-students.index';
        $info->description = 'These all are Dinning Students';


    $per_page = request('per_page', 20);
    $with_data = [];

// Sum of meals per user
$mealSums = Meal::select('user_id', DB::raw('SUM(COALESCE(lunch,0) + COALESCE(dinner,0)) as total_meals'))
    ->groupBy('user_id');

// Duration (min from, max to) per user
$durationSub = Meal::join('dinning_months', 'meals.dinning_month_id', '=', 'dinning_months.id')
    ->select('meals.user_id', 
        DB::raw('MIN(dinning_months.`from`) as from_date'), 
        DB::raw('MAX(dinning_months.`to`) as to_date'))
    ->groupBy('meals.user_id');

// Main query: INNER JOIN to only get users with meals
$data = User::joinSub($mealSums, 'meal_sums', function($join) {
        $join->on('users.id', '=', 'meal_sums.user_id');
    })
    ->leftJoinSub($durationSub, 'durations', function($join) {
        $join->on('users.id', '=', 'durations.user_id');
    })
    ->select('users.*', 'meal_sums.total_meals', 'durations.from_date', 'durations.to_date')
    ->orderBy('users.id', 'DESC')
    ->paginate($per_page);

        return view('admin.dinning-students.index', compact('page_title', 'data', 'info','per_page'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Dinning Student Create';
        $info=new stdClass();
        $info->title = 'Dinning Students';
        $info->first_button_title = 'All Dinning Student';
        $info->first_button_route = 'admin.dinning-students.index';
        $info->form_route = 'admin.dinning-students.store';

        return view('admin.dinning-students.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'student_id' => [
                'required',
                'string',
                Rule::unique('dinning_students', 'student_id'),
            ],
                    
            'name' => 'required|string',
                    
            // 'txid' => 'required|string',
                    
            'total_meals' => 'required|integer',
                    
            'from' => 'required|date',
                    
            'to' => 'required|date',
                    
            // 'paid_status' => 'nullable|string|in:paid,unpaid',
                    
            // 'user_id' => 'nullable|integer',
                    
            'dinning_month_id' => 'required|integer',
                    
            'department_id' => 'required|integer',
                    
            'student_session_id' => 'required|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new DinningStudent;
        
        $row->student_id = $request->student_id;
        
        $row->name = $request->name;
        
        // $row->txid = $request->txid;
        
        $row->total_meals = $request->total_meals;
        
        $row->from = $request->from;
        
        $row->to = $request->to;
        
        // $row->paid_status = $request->paid_status;
        
        $row->user_id=auth()->user()->id;
        
        $row->dinning_month_id = $request->dinning_month_id;
        
        $row->department_id = $request->department_id;
        
        $row->student_session_id = $request->student_session_id;
        
        if($request->hasfile('avatar')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('avatar'),
                'storage/Dinning-Students',
                ['png','jpg','jpeg','gif']
            );

            if(isset($file_response['result']) && !$file_response['result'])
            {
                
                return back()->with('warning',$file_response['message']);
            }

            $row->avatar = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.dinning-students.index')
        ->with('success','Dinning Student created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Dinning Student Details';
        $info = new stdClass();
        $info->title = 'Dinning Students Details';
        $info->first_button_title = 'Edit Dinning Student';
        $info->first_button_route = 'admin.dinning-students.edit';
        $info->second_button_title = 'All Dinning Student';
        $info->second_button_route = 'admin.dinning-students.index';
        $info->description = '';


        $data = DinningStudent::findOrFail($id);


        return view('admin.dinning-students.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Dinning Student Edit';
        $info=new stdClass();
        $info->title = 'Dinning Students';
        $info->first_button_title = 'Add Dinning Student';
        $info->first_button_route = 'admin.dinning-students.create';
        $info->second_button_title = 'All Dinning Student';
        $info->second_button_route = 'admin.dinning-students.index';
        $info->form_route = 'admin.dinning-students.update';
        $info->route_destroy = 'admin.dinning-students.destroy';

        $data=DinningStudent::where('id',$id)->first();

        return view('admin.dinning-students.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'student_id' => [
                'required',
                'string',
                Rule::unique('dinning_students', 'student_id')->ignore($id),
            ],
                    
            'name' => 'required|string',
                    
            // 'txid' => 'required|string',
                    
            'total_meals' => 'required|integer',
                    
            'from' => 'required|date',
                    
            'to' => 'required|date',
                    
            // 'paid_status' => 'nullable|string|in:paid,unpaid',
                    
            // 'user_id' => 'nullable|integer',
                    
            'dinning_month_id' => 'required|integer',
                    
            'department_id' => 'required|integer',
                    
            'student_session_id' => 'required|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = DinningStudent::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->student_id=$request->student_id;
        
        $row->name=$request->name;
        
        // $row->txid=$request->txid;
        
        $row->total_meals=$request->total_meals;
        
        $row->from=$request->from;
        
        $row->to=$request->to;
        
        // $row->paid_status=$request->paid_status;
        
         $row->user_id=auth()->user()->id;
        
        $row->dinning_month_id=$request->dinning_month_id;
        
        $row->department_id=$request->department_id;
        
        $row->student_session_id=$request->student_session_id;
        
        if($request->hasfile('avatar')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('avatar'),
                'storage/Dinning-Students',
                ['png','jpg','jpeg','gif']
            );
            if(isset($file_response['result']) && !$file_response['result'])
            {
                
                return back()->with('warning',$file_response['message']);
            }

            $old_file=$row->avatar;
            FileManager::deleteFile($old_file);

            $row->avatar = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.dinning-students.show',$id)
        ->with('success','Dinning Student updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=DinningStudent::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        if($row['avatar']!='')
        {
            FileManager::deleteFile($row['avatar']);
        }
        
        $row->delete();
        
        return redirect()->route('admin.dinning-students.index')
        ->with('success','Dinning Student deleted successfully!');
    }
}