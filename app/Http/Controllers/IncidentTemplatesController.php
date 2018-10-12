<?php

namespace App\Http\Controllers;

use App\Models\IncidentTemplates;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\User;
use Carbon\Carbon;

class IncidentTemplatesController extends Controller
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
        $templates = IncidentTemplates::with('author')->OrderBy('created_at', 'DESC')->paginate(12);
        return view('authentication.incidents.template', compact('user', 'templates'));
    }

    public function create(Request $request)
    {

        if( $request->ajax() )
        {
        $user = \Auth::user();
        return view('authentication.incidents.template_new', compact('user'));
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

            $request->merge(['user_id' => $user->id]);
            $request->merge(['created_at' => date('Y-m-d H:i:s')]);
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'incident_template_title' => 'required|max:255|min:3',
                'incident_template_body' => 'required|min:10',
            ];
            $data = $request->only(['user_id', 'incident_template_title', 'incident_template_body', 'created_at', 'updated_at']);
            $validator = Validator::make($data, $rules);

            if($validator->passes())
            {
                $save = IncidentTemplates::create($data);
                $check_count_incident_templates = IncidentTemplates::get()->count();
                return response()->json(['id' => $save->id, 'incident_template_title' => $save->incident_template_title,  'incident_template_body' => $save->incident_template_body, 'check_count_incident_templates' => $check_count_incident_templates,  'success' => 'The new component has been added.']);


            } else {
                return response()->json(['error' => $validator->errors()->all()]);
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
        $component = IncidentTemplates::findOrFail($id);

        return view('authentication.incidents.template_edit', compact('user', 'component'));
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
                $component = IncidentTemplates::findOrFail($id);
                $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
                $rules = [
                    'incident_template_title' => 'required|max:255|min:3',
                    'incident_template_body' => 'required|min:10',
                ];
                $data = $request->only(['user_id', 'incident_template_title', 'incident_template_body', 'created_at', 'updated_at']);
                $validator = Validator::make($data, $rules);

                if ($validator->passes()) {
                    $component->update($data);
                    return response()->json(['success' => 'Great! The Incident Template has been updated.', 'id' => $component->id, 'incident_template_title' => $component->incident_template_title]);

                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function destroy($id, Request $request)
    {
        $user = \Auth::user();
        IncidentTemplates::findOrFail($id);

        if ( $request->ajax() ) {
            IncidentTemplates::where('id', $id)->delete();
            $check_count_incident_templates = IncidentTemplates::get()->count();
            return response()->json(['check_count_incident_templates' => $check_count_incident_templates, 'success' => 'Great! The Incident Template has been removed!']);
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }


    }

}
