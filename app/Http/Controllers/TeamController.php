<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Response;
use DB;
use Hash;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        if($user->level == 10){

            $users = User::OrderBy('level', 'DESC')->get();

            return view('authentication.team.index', compact('user', 'users'));
        } else {
            $notification = array(
                'message' => 'You don\'t have permission to access this area.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function create(Request $request)
    {
            if( $request->ajax() )
            {
                $user = \Auth::user();

                if($user->level == 10){

                    return view('authentication.team.new', compact('user'));

                } else {
                    return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
                }
            }  else {
                $notification = array(
                    'message' => 'Ilegal operation. The administrator was notified.',
                    'alert-type' => 'error'
                );
                return redirect()->route('authenticated.dashboard')->with($notification);
            }

    }

    public function store(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            if($user->level == 10){
                $rules = [
                    'name' => 'required|min:5|max:40',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|same:confirm_password',
                    'confirm_password' => 'required|same:password',
                    'level' => 'required'
                ];
                $data = $request->only(['name', 'email', 'password', 'confirm_password', 'level']);
                $validator = Validator::make($data, $rules);
                $data['password'] = Hash::make($data['password']);
                unset($data['confirm_password']);
                if($validator->passes())
                {

                    $user_details = User::create($data);
                    return response()->json(['id' => $user_details->id, 'name' => $user_details->name, 'email' => $user_details->email, 'level' => $user_details->level, 'success' => 'The new user has been added.']);

                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function edit(Request $request, $id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            if($user->level == 10){

                $get_user = User::findOrFail($id);

                return view('authentication.team.edit', compact('user', 'get_user'));

            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function update(Request $request, $id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            if($user->level == 10){
                $get_user = User::findOrFail($id);

                $rules = [
                    'name' => 'required|min:5|max:40',
                    'email' => 'required|email|unique:users,email,'.$id,
                    'password' => 'same:confirm_password',
                    'confirm_password' => 'same:password',
                    'level' => 'required'
                ];

                $data = $request->only(['name', 'email', 'password', 'confirm_password', 'level']);
                $validator = Validator::make($data, $rules);

                if(!empty($data['password']) || $data['password'] !== null){
                    $data['password'] = Hash::make($data['password']);
                }else{
                    $data = array_except($data,array('password'));
                    unset($data['password']);
                }

                unset($data['confirm_password']);

                if($validator->passes())
                {

                    $get_user->update($data);
                    $user_details = User::findOrFail($id);

                    return response()->json(['id' => $user_details->id, 'name' => $user_details->name, 'email' => $user_details->email, 'level' => $user_details->level, 'success' => 'The new user has been updated.']);

                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function destroy(Request $request, $id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            if($user->level == 10){
                $get_user = User::findOrFail($id);
                if($user->id == $get_user->id){
                    return response()->json(['id' => $get_user->id, 'warning' => 'Did you tried to delete your own user?'], 405);
                    }
                elseif ($get_user->id == 1) {
                    return response()->json(['id' => $get_user->id, 'warning' => 'You cannot remove the first Admin user.'], 405);
                    }
                else
                    {

                    $get_user->delete();
                    return response()->json(['id' => $get_user->id, 'success' => 'Great! The user has been deleted']);
                    }

            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

}
