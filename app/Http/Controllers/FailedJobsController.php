<?php

namespace App\Http\Controllers;

use App\Models\FailedJobs;
use Illuminate\Http\Request;
use Response;
use Carbon\Carbon;


class FailedJobsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $user = \Auth::user();

        if($user->level == 10) {

            $faild_jobs = FailedJobs::get();

            return view('authentication.failedjobs.index', compact('user', 'faild_jobs'));

        } else
            {
                $notification = array(
                    'message' => 'You don\'t have permission to access this area.',
                    'alert-type' => 'error'
                );
                return redirect()->route('authenticated.dashboard')->with($notification);
            }
    }

    public function view_playload(Request $request, $id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            if($user->level == 10){

                $playload_failed_view = FailedJobs::findOrFail($id);

                return view('authentication.failedjobs.playload-view', compact('user', 'playload_failed_view'));
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

    public function view_exception(Request $request, $id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            if($user->level == 10){

                $exception_failed_view = FailedJobs::findOrFail($id);

                return view('authentication.failedjobs.exception-view', compact('user', 'exception_failed_view', json_decode($exception_failed_view, true)));
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