<?php

namespace App\Http\Controllers;

use App\Models\Components;
use App\Models\MaintenanceSent;
use App\Models\Subscribe;
use App\Models\SubscribeComponents;
use App\Models\SubscribesSent;
use App\User;
use Illuminate\Http\Request;
use Response;
use DB;
use Hash;
use Illuminate\Support\Facades\Validator;

class SubscribesController extends Controller
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

        $subscribes = Subscribe::paginate(10);
            $subscribes_total = Subscribe::get()->count();
            $subscribes_total_unconfirmed = Subscribe::where('status', 0)->get()->count();

            $components = Components::OrderBy('position', 'ASC')->get();

            $lists = [];
            foreach ($components as $key => $component){
                $lists[$key]['name'] = $component->component_name;
                $lists[$key]['count'] = SubscribeComponents::where('components_id', $component->id)->get()->count();
            }

            return view('authentication.subscribe.index', compact('user', 'users', 'subscribes', 'subscribes_total', 'subscribes_total_unconfirmed', 'lists'));
        } else {
            $notification = array(
                'message' => 'You don\'t have permission to access this area.',
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
                $get_user = Subscribe::findOrFail($id);
                    $get_user->delete();
                    SubscribesSent::where('subscribes_id', $id)->delete();
                    SubscribeComponents::where('subscribes_id', $id)->delete();
                    MaintenanceSent::where('subscribes_id', $id)->delete();

                    return response()->json(['id' => $get_user->id, 'success' => 'Great! The subscribe user has been deleted']);

            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.subscribe')->with($notification);
        }

    }

    public function index_subscribes_sent()
    {
        $user = \Auth::user();

        if($user->level == 10){



            return view('authentication.subscribe.index', compact('user'));
        } else {
            $notification = array(
                'message' => 'You don\'t have permission to access this area.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

}
