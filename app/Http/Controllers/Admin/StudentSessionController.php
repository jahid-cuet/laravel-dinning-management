<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\StudentSession;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentSessionExport;


class StudentSessionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:student-session-view|student-session-create|student-session-update|student-session-delete', ['only' => ['index']]);
        $this->middleware('permission:student-session-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-session-update', ['only' => ['edit','update']]);
        $this->middleware('permission:student-session-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Student Session';
        $info=new stdClass();
        $info->title = 'Student Sessions';
        $info->first_button_title = 'Add Student Session';
        $info->first_button_route = 'admin.student-sessions.create';
        $info->route_index = 'admin.student-sessions.index';
        $info->description = 'These all are Student Sessions';


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = StudentSession::query();

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','hsc_session','name'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        

        
        if($request->export_table)
        {
            $filePath='StudentSessions.csv';
            $export_data=$data->get();
            $excel_data=new StudentSessionExport($export_data);
            return Excel::download($excel_data, $filePath);
        }
        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->paginate($per_page);

        return view('admin.student-sessions.index', compact('page_title', 'data', 'info','per_page'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Student Session Create';
        $info=new stdClass();
        $info->title = 'Student Sessions';
        $info->first_button_title = 'All Student Session';
        $info->first_button_route = 'admin.student-sessions.index';
        $info->form_route = 'admin.student-sessions.store';

        return view('admin.student-sessions.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'hsc_session' => 'nullable|string',
                    
            'name' => 'nullable|string|in:2019-20,2020-21,2021-22,2022-23,2023-24',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new StudentSession;
        
        $row->hsc_session = $request->hsc_session;
        
        $row->name = $request->name;
        
        $row->save();
        
        return redirect()->route('admin.student-sessions.index')
        ->with('success','Student Session created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Student Session Details';
        $info = new stdClass();
        $info->title = 'Student Sessions Details';
        $info->first_button_title = 'Edit Student Session';
        $info->first_button_route = 'admin.student-sessions.edit';
        $info->second_button_title = 'All Student Session';
        $info->second_button_route = 'admin.student-sessions.index';
        $info->description = '';


        $data = StudentSession::findOrFail($id);


        return view('admin.student-sessions.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Student Session Edit';
        $info=new stdClass();
        $info->title = 'Student Sessions';
        $info->first_button_title = 'Add Student Session';
        $info->first_button_route = 'admin.student-sessions.create';
        $info->second_button_title = 'All Student Session';
        $info->second_button_route = 'admin.student-sessions.index';
        $info->form_route = 'admin.student-sessions.update';
        $info->route_destroy = 'admin.student-sessions.destroy';

        $data=StudentSession::where('id',$id)->first();

        return view('admin.student-sessions.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'hsc_session' => 'nullable|string',
                    
            'name' => 'nullable|string|in:2019-20,2020-21,2021-22,2022-23,2023-24',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = StudentSession::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->hsc_session=$request->hsc_session;
        
        $row->name=$request->name;
        
        $row->save();
        
        return redirect()->route('admin.student-sessions.show',$id)
        ->with('success','Student Session updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=StudentSession::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.student-sessions.index')
        ->with('success','Student Session deleted successfully!');
    }
}