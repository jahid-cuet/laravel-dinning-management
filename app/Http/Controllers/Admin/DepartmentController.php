<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\Department;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartmentExport;


class DepartmentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:department-view|department-create|department-update|department-delete', ['only' => ['index']]);
        $this->middleware('permission:department-create', ['only' => ['create','store']]);
        $this->middleware('permission:department-update', ['only' => ['edit','update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Department';
        $info=new stdClass();
        $info->title = 'Departments';
        $info->first_button_title = 'Add Department';
        $info->first_button_route = 'admin.departments.create';
        $info->route_index = 'admin.departments.index';
        $info->description = 'These all are Departments';


        $per_page = request('per_page', 20);
        $with_data=[];

        $data = Department::query();

        
        if(isset($request->search) && trim($request->search)!=''){
            $search_columns = ['id','name','code'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        

        
        if($request->export_table)
        {
            $filePath='Departments.csv';
            $export_data=$data->get();
            $excel_data=new DepartmentExport($export_data);
            return Excel::download($excel_data, $filePath);
        }
        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->paginate($per_page);

        return view('admin.departments.index', compact('page_title', 'data', 'info','per_page'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Department Create';
        $info=new stdClass();
        $info->title = 'Departments';
        $info->first_button_title = 'All Department';
        $info->first_button_route = 'admin.departments.index';
        $info->form_route = 'admin.departments.store';

        return view('admin.departments.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'name' => 'required|string',
                    
            'code' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new Department;
        
        $row->name = $request->name;
        
        $row->code = $request->code;
        
        $row->save();
        
        return redirect()->route('admin.departments.index')
        ->with('success','Department created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Department Details';
        $info = new stdClass();
        $info->title = 'Departments Details';
        $info->first_button_title = 'Edit Department';
        $info->first_button_route = 'admin.departments.edit';
        $info->second_button_title = 'All Department';
        $info->second_button_route = 'admin.departments.index';
        $info->description = '';


        $data = Department::findOrFail($id);


        return view('admin.departments.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Department Edit';
        $info=new stdClass();
        $info->title = 'Departments';
        $info->first_button_title = 'Add Department';
        $info->first_button_route = 'admin.departments.create';
        $info->second_button_title = 'All Department';
        $info->second_button_route = 'admin.departments.index';
        $info->form_route = 'admin.departments.update';
        $info->route_destroy = 'admin.departments.destroy';

        $data=Department::where('id',$id)->first();

        return view('admin.departments.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'name' => 'required|string',
                    
            'code' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = Department::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->name=$request->name;
        
        $row->code=$request->code;
        
        $row->save();
        
        return redirect()->route('admin.departments.show',$id)
        ->with('success','Department updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=Department::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        
        $row->delete();
        
        return redirect()->route('admin.departments.index')
        ->with('success','Department deleted successfully!');
    }
}