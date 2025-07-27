<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StudentSession;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

 public function create()
    {
        $departments = Department::all();
        $sessions = StudentSession::all();

        return view('Frontend.register',compact('departments', 'sessions'));
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)//: Response
    {
        // $auth_index_name=env('AUTH_PHONE_SUPPORT')? 'email_or_phone':'email';
        // if(filter_var($request[$auth_index_name], FILTER_VALIDATE_EMAIL))
        // {
        //     $fixed_country_code=env('FIXED_COUNTRY_CODE');
        //     $request->validate([
        //         'name' => ['required', 'string', 'max:255'],

        //         'country_code' => $fixed_country_code!=''? 'nullable':'required',

        //         $auth_index_name => 'required|lowercase|email|max:255|unique:users,email',

        //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     ]);

        //     $country_code=$fixed_country_code?? $request->country_code;

        //     $user = new User;
        //     $user->name = $request->name;
        //     $user->country_code = $country_code;
        //     $user->signup_by = 'email';
        //     $user->notify_by = 'email';
        //     $user->email = $request[$auth_index_name];
        //     $user->password = Hash::make($request->password);
        //     $user->save();
            
        // }
        // else
        // {
        //     $fixed_country_code=env('FIXED_COUNTRY_CODE');
        //     $request->validate([
        //         'name' => ['required', 'string', 'max:255'],
        //         'country_code' => $fixed_country_code!=''? 'nullable':'required',
        //         $auth_index_name => [
        //             'required',
        //             'regex:/^[0-9]+$/',
        //             Rule::unique('users', 'phone')->where(function ($query) {
        //                 return $query->where('country_code', $fixed_country_code?? request('country_code'));
        //             }),
        //         ],
        //         'otp' =>['required', 'integer'],
        //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     ]);


        //     $country_code=$fixed_country_code?? $request->country_code;


        //     $check_otp_query = DB::table('phone_otps')->where([
        //         'country_code'=>$country_code,
        //         'phone' => $request[$auth_index_name], 
        //         'otp' => $request->otp, 
        //         'type' => 'signup'
        //     ]);


        //     $check_otp =$check_otp_query->first();
            
        //     if ($check_otp!='') 
        //     {
        //         $check_otp_query->delete();
        //     }
        //     else
        //     {
        //         return apiResponse($result=false,$message="Invalid OTP",$data=null,$code=201);
        //     }

        //     $user = new User;
        //     $user->name = $request->name;
        //     $user->country_code = $country_code;
        //     $user->signup_by = 'phone';
        //     $user->notify_by = 'phone';
        //     $user->phone = $request[$auth_index_name];
        //     $user->password = null;
        //     $user->save();

        // }

    $request->validate([
    'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id'],
    'name' => ['required', 'string', 'max:255'],
    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
    'department_id' => ['required', 'integer', Rule::exists('departments', 'id')],
    'student_session_id' => ['required', 'integer', Rule::exists('student_sessions', 'id')],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
   'student_id' => $request->student_id,
    'name' => $request->name,
    'email' => $request->email,
    'department_id' => $request->department_id,
    'student_session_id' => $request->student_session_id,
    'password' => Hash::make($request->password),
        // 'provider', 'provider_id', etc. can be added if using social login
    ]);

    // event(new Registered($user));

    Auth::login($user);

   return redirect()->route('student.dashboard');

}
}
