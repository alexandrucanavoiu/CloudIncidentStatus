<?php

namespace App\Http\Controllers;

use App\Jobs\IncidentNewAlert;
use App\Jobs\IncidentUpdateAlert;
use App\Models\Components;
use App\Models\ComponentStatus;
use App\Models\IncidentComponents;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\IncidentUpdate;
use App\Models\IncidentStatus;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Navigation;
use App\Models\IncidentTemplates;

class IncidentsController extends Controller
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
         $incidents = Incident::with('incident_status')->with('incident_components')->OrderBy('incident_statuses_id', 'ASC')->orderby('updated_at', 'desc')->get();
        return view('authentication.incidents.index', compact('user', 'incidents'));
    }

    public function create(Request $request)
    {
        $user = \Auth::user();
        if( $request->ajax() )
        {
            $component_count = Components::get()->count();
            if($component_count > 0){
                $user = \Auth::user();
                $components = Components::with('component_group')->get();
                $components_status = ComponentStatus::orderby('id', 'asc')->get();
                $incident_statuses_id = IncidentStatus::OrderBy('id', 'asc')->get();
                $incident_templates = IncidentTemplates::get();
                return view('authentication.incidents.new', compact('user','components', 'components_status', 'incident_statuses_id', 'incident_templates'));
            } else {
                return Response::json(['warning' => 'To add a incident, please first add a component.'], 404);
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function store(Request $request, IncidentComponents $incidentComponents)
    {

        $user = \Auth::user();

        // create array for components_id
        $incidents_array = [];
        $incidents_split = $request->input('components_id');
        $incidents_split = explode(",", $incidents_split);
        foreach ($incidents_split as $key => $a){
            $incidents_array[$key] =  $a;
        }
        $request->merge(['components_id' => $incidents_array]);

        $body_description = $request->input('incidents_description');
        $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
        $request->merge(['incidents_description' => $body]);
        $request->merge(['user_id' => $user->id]);
        $request->merge(['created_at' => date('Y-m-d H:i:s')]);
        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
        $rules = [
            'incident_title' => 'required|max:255|min:3',
            'components_id' => 'required|array|min:1|max:5',
            'components_id.*' => 'required|numeric|exists:components,id',
            'incident_statuses_id' => 'required|exists:incident_status,id',
            'component_statuses_id' => 'required|exists:component_statuses,id',
            'incidents_status' => 'required|numeric|digits_between::0,1',
            'incidents_description' => 'required|min:10',
        ];
        $data = $request->only(['user_id', 'incident_title', 'components_id', 'incident_components_id', 'incident_statuses_id', 'component_statuses_id', 'incidents_status', 'incidents_description', 'created_at', 'updated_at']);
        $validator = Validator::make($data, $rules);

        $code = Navigation::generateRandomString();
        $incident_title = $request->input('incident_title');
        $components_id = $request->input('components_id');
        $incident_statuses_id = $request->input('incident_statuses_id');
        $component_statuses_id = $request->input('component_statuses_id');
        $incidents_status = $request->input('incidents_status');
        $incidents_description = $request->input('incidents_description');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        if( $request->ajax() )
        {
            if($validator->passes())

            {
                $incident_id = Incident::insertGetId(
                    ['user_id' => $user->id, 'code' => $code, 'incident_title' => $incident_title, 'incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'incidents_status' => $incidents_status, 'created_at' => $created_at, 'updated_at' => $updated_at]
                );

                $incident_updated_id = IncidentUpdate::insertGetId(
                    ['user_id' => $user->id, 'incidents_id' => $incident_id, 'incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'incidents_description' => $incidents_description, 'created_at' => $created_at, 'updated_at' => $updated_at]
                );

                // Array from ajax components_id
                $IncidentComponentsArray = [];

                foreach ($components_id as $component_insert)
                {
                    $IncidentComponentsArray[] = [
                        'incidents_id' => $incident_id,
                        'components_id'=> $component_insert,
                        'component_statuses_id' => $component_statuses_id
                    ];
                }

                // Insert components in db
                $incidentComponents->create($IncidentComponentsArray);
                $incident_inserted = Incident::where('id', $incident_id)->get()->first();
                $incidents_count = Incident::get()->count();
                $get_the_incident_components_inserted = IncidentComponents::with('component_name')->where('incidents_id', $incident_id)->get();

                $component_name_list = [];

                foreach ($get_the_incident_components_inserted as $item){
                    $component_name_list[] = $item->component_name->component_name;
                    $get_the_biggest_status_of_component = IncidentComponents::where('components_id', $item->components_id)->OrderBy('component_statuses_id', 'DESC')->get()->first();
                    Components::where('id', $item->components_id)->update(['component_statuses_id' => $get_the_biggest_status_of_component->component_statuses_id]);
                }

                $component_name = implode(', ', $component_name_list);
                $incident_status_name = $incident_inserted->incident_status->incident_name;
                $incident_date_update = $incident_inserted->updated_at->format('d/m/Y H:i:s');

                // Get Settings
                $settings = Settings::where('id', 1)->get()->first();

                // pass data in dispatch
                $data_pass = [];
                $data_pass['queue_name'] = $settings->queue_name_incidents;
                $data_pass['bulk_emails'] = $settings->bulk_emails;
                $data_pass['bulk_emails_sleep'] = $settings->bulk_emails_sleep;
                $data_pass['from_address'] = $settings->from_address;
                $data_pass['from_name'] = $settings->from_name;
                $data_pass['title_app'] = $settings->title_app;
                $data_pass['code'] = $code;
                $data_pass['date_of_incident'] = $incident_date_update;
                $data_pass['incident_status_name'] = $incident_status_name;
                $data_pass['incidents_description'] = $incidents_description;
                $data_pass['incident_title'] = $incident_title;
                $data_pass['components_name'] = $component_name;

                dispatch(new IncidentNewAlert($incident_id, $incident_updated_id, $components_id, $data_pass))->onQueue($data_pass['queue_name']);

                return response()->json(['id' => $incident_id, 'incident_title' => $incident_title, 'incident_statuses_id' => $incident_statuses_id,  'component_statuses_id' =>  $component_statuses_id, 'incidents_count' => $incidents_count, 'component_name' => $component_name, 'incident_status_name' => $incident_status_name, 'incident_date_update' => $incident_date_update, 'incidents_status' => $incidents_status,  'success' => 'The new incident  been added.']);


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
        $user = \Auth::user();
        if( $request->ajax() )
        {
        $incident = Incident::findOrFail($id);
        $components = Components::with('component_group')->get();
        $component_statuses_id = ComponentStatus::orderby('id', 'asc')->get();

        $components_selected = IncidentComponents::where('incidents_id', $id)->get();

            $collection = collect([0]);
            foreach ($components_selected as $component){
                $collection->push($component->components_id);
            }

            $searchcomponents = $collection->all();
            $searchcomponents = collect($searchcomponents);


        return view('authentication.incidents.edit', compact('user','incident', 'components', 'component_statuses_id', 'searchcomponents'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function update(Request $request, $id, IncidentComponents $IncidentComponents)
    {
        $user = \Auth::user();
        $incident = Incident::findOrFail($id);


        // create array for components_id
        $incidents_array = [];
        $incidents_split = $request->input('components_id');
        $incidents_split = explode(",", $incidents_split);
        foreach ($incidents_split as $key => $a){
            $incidents_array[$key] =  $a;
        }
        $request->merge(['components_id' => $incidents_array]);

        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
        $rules = [
            'incident_title' => 'required|max:255|min:3',
            'components_id' => 'required|array|min:1|max:5',
            'components_id.*' => 'required|numeric|exists:components,id',
            'component_statuses_id' => 'required|numeric|exists:component_statuses,id',
            'incidents_status' => 'required|numeric|digits_between::0,1',
        ];
        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);

        $data = $request->only(['incident_title', 'components_id', 'component_statuses_id', 'incidents_status', 'updated_at']);
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {

            $incident_title = $request->input('incident_title');
            $incident_statuses_id = $incident->incident_statuses_id;
            $components_id = $request->input('components_id');
            $component_statuses_id = $request->input('component_statuses_id');

            $incident->update(['incident_title' => $incident_title, 'component_statuses_id' => $component_statuses_id, 'incidents_status' => $incident_statuses_id]);

            // Array from ajax components_id
            $IncidentComponentsArray = [];

            foreach ($components_id as $component_insert)
            {
                $IncidentComponentsArray[] = [
                    'incidents_id' => $incident->id,
                    'components_id'=> $component_insert,
                    'component_statuses_id' => $component_statuses_id
                ];
            }

            $IncidentComponents->where('incidents_id', $id)->delete();

            // Insert components in db
            $IncidentComponents->create($IncidentComponentsArray);


            $get_the_incident_components_inserted = IncidentComponents::with('component_name')->where('incidents_id', $id)->get();
            $incident_date_update = $incident->updated_at->format('d/m/Y H:i:s');
            $incident_status_name = $incident->incident_status->incident_name;
            $incidents_status = $incident->incidents_status;

            $component_name = [];

            foreach ($get_the_incident_components_inserted as $item){
                $get_last_incident_with_same_component = IncidentComponents::where('components_id', $item->components_id)->OrderBy('component_statuses_id', 'DESC')->get()->first();
                Components::where('id', $get_last_incident_with_same_component->components_id)->update(['component_statuses_id' => $get_last_incident_with_same_component->component_statuses_id]);
                $component_name[] = $item->component_name->component_name;
            }

            $component_name = implode(', ', $component_name);


            return response()->json(['id' => $incident->id, 'incident_title' => $incident_title, 'incident_statuses_id' => $incident_statuses_id, 'component_name' => $component_name, 'incident_status_name' => $incident_status_name, 'incident_date_update' => $incident_date_update, 'incidents_status' => $incidents_status, 'success' => 'The new incident been updated.']);

        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }


    }

    public function destroy($id, Request $request)
    {
        $user = \Auth::user();
        $incident = Incident::findOrFail($id);

        if ( $request->ajax() ) {

            $get_the_list_of_component = IncidentComponents::where('incidents_id', $incident->id)->get();

            Incident::where('id', $id)->delete();
            IncidentComponents::where('incidents_id', $id)->delete();
            $check_count_incidents_list = Incident::get()->count();

            foreach ($get_the_list_of_component as $item){
                $component_id = $item->components_id;
                $check_the_component_in_incident_components = IncidentComponents::where('components_id', $component_id)->OrderBy('component_statuses_id', 'DESC')->get()->first();
                if(!empty($check_the_component_in_incident_components)){
                    if($check_the_component_in_incident_components->count() > 0){
                        Components::where('id', $component_id)->update(['component_statuses_id' => $check_the_component_in_incident_components->component_statuses_id]);
                    } else {
                        Components::where('id', $component_id)->update(['component_statuses_id' => 1]);
                    }
                } else {
                    Components::where('id', $component_id)->update(['component_statuses_id' => 1]);
                }
            }
            return response()->json(['check_count_incidents_list' => $check_count_incidents_list, 'success' => 'Great! The incident has been removed!']);
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }


    }

    public function use_template(Request $request, $id)
{
        $user = \Auth::user();
        $request->merge(['id' => $id]);

        $rules = [
        'id' => 'required|exists:incident_templates,id',
        ];

        $data = $request->only(['id']);
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
        $incident = IncidentTemplates::findOrFail($id);

        return response()->json(['id' => $incident->id, 'incident_template_title' => $incident->incident_template_title, 'incident_template_body' => $incident->incident_template_body]);

        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        }

    public function update_view(Request $request, $id)
    {
        $user = \Auth::user();
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $incident = Incident::with('author')->with('incident_status')->with('update_incident')->findOrFail($id);

            $component_affected = IncidentComponents::with('component_name')->where('incidents_id', $id)->get();

            $component_name = [];

            foreach ($component_affected as $item){
                $component_name[] = $item->component_name->component_name;
            }

            $component_name = implode(', ', $component_name);

            return view('authentication.incidents.update_view', compact('user','incident', 'component_name'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function update_index($id)
    {
        $user = \Auth::user();
        $incident = Incident::with('component_name')->with('incident_status')->with('component_status')->findOrFail($id);

        $last_incident_status = IncidentUpdate::where('incidents_id', $id)->whereNotIn('incident_statuses_id', [5])->OrderBy('id', 'DESC')->get()->first();
        $last_incident_status = $last_incident_status->incident_statuses_id;

        $get_the_incident_components = IncidentComponents::with('component_name')->where('incidents_id', $id)->get();

        $components_name = [];

        foreach ($get_the_incident_components as $item){
            $components_name[] = $item->component_name->component_name;
        }

        $components_name = implode(', ', $components_name);

        return view('authentication.incidents.update_index', compact('user', 'incident', 'components_name', 'last_incident_status'));
    }

    public function update_create(Request $request, $id)
    {
        $user = \Auth::user();
        if( $request->ajax() )
        {
            $incident = Incident::with('incident_status')->with('component_status')->findOrFail($id);

            $count_incident_with_status_resolved = IncidentUpdate::where('incidents_id', $id)->where('incident_statuses_id', 4)->get()->count();

            if($count_incident_with_status_resolved == 1){
                return response()->json(['warning' => 'You cannot add another update. The status for this incident is Resolved.'], 405);
            }

            $user = \Auth::user();
            $components_status = ComponentStatus::orderby('id', 'asc')->get();
            $incident_statuses_id = IncidentStatus::OrderBy('id', 'asc')->get();
            $incident_templates = IncidentTemplates::get();
            return view('authentication.incidents.update_new', compact('user','incident', 'components_status', 'incident_statuses_id', 'incident_templates'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function update_store(Request $request, $id)
    {
        $user = \Auth::user();

        $incident = Incident::findOrFail($id);

        $body_description = $request->input('incidents_description');
        $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
        $request->merge(['incidents_description' => $body]);

        $request->merge(['user_id' => $user->id]);
        $request->merge(['created_at' => date('Y-m-d H:i:s')]);
        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
        $request->merge(['incidents_id' => 'required|exists:incidents,id']);
        $rules = [
            'incident_statuses_id' => 'required|exists:incident_status,id',
            'component_statuses_id' => 'required|exists:component_statuses,id',
            'incidents_description' => 'required|min:10',
        ];
        $data = $request->only(['user_id', 'incidents_id', 'incident_statuses_id', 'component_statuses_id', 'incidents_description', 'created_at', 'updated_at']);
        $validator = Validator::make($data, $rules);

        if( $request->ajax() )
        {
            if($validator->passes())

            {
                $incidents_id = $id;
                $incident_statuses_id = $request->input('incident_statuses_id');
                $component_statuses_id = $request->input('component_statuses_id');
                $incidents_description = $request->input('incidents_description');
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');

                $count_incident_with_the_same_status = IncidentUpdate::where('incidents_id', $id)->where('incident_statuses_id', $request->input('incident_statuses_id'))->get()->count();

                if($incident_statuses_id !== "5") {
                    if ($count_incident_with_the_same_status == 1 && $request->input('incident_statuses_id') !== "5") {
                        return response()->json(['warning' => 'You cannot add another update with an existent incident status. '], 405);
                    }

                    $get_the_last_incident_status = IncidentUpdate::where('incidents_id', $id)->OrderBy('incident_statuses_id', 'DESC')->get()->first();

                    if ($get_the_last_incident_status !== null && $get_the_last_incident_status->incident_statuses_id !== 5) {
                        if ($incident_statuses_id < $get_the_last_incident_status->incident_statuses_id) {
                            return response()->json(['warning' => 'You cannot add an update with an inferior incident status. '], 405);
                        }
                    }
                }

                $get_incident_update_id = IncidentUpdate::insertGetId(
                    ['user_id' => $user->id, 'incidents_id' => $incidents_id, 'incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'incidents_description' => $incidents_description, 'created_at' => $created_at, 'updated_at' => $updated_at]
                );

                Incident::where('id', $incidents_id)->update(['incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id]);

                $get_the_record = IncidentUpdate::where('id', $get_incident_update_id)->get()->first();
                $incident_date_update = $get_the_record->updated_at->format('d/m/Y H:i:s');
                $component_status_update = $get_the_record->component_status->component_status_name;

                IncidentComponents::where('incidents_id', $incidents_id)->update(['component_statuses_id' => $component_statuses_id, 'updated_at' => $updated_at]);

                $get_components_incident = IncidentComponents::with('component_name')->where('incidents_id', $incident->id)->get();

                // add components in an array for dispatch & update status of components
                $components_for_incident_id = [];
                $components_for_incident_name = [];

                foreach ($get_components_incident as $get_component){
                    $components_for_incident_id[] = $get_component->components_id;
                    $components_for_incident_name[] = $get_component->component_name->component_name;

                    $get_last_incident_with_same_component = IncidentComponents::where('components_id', $get_component->components_id)->OrderBy('component_statuses_id', 'DESC')->get()->first();
                    Components::where('id', $get_last_incident_with_same_component->components_id)->update(['component_statuses_id' => $get_last_incident_with_same_component->component_statuses_id]);
                }

                $components_for_incident_name = implode(', ', $components_for_incident_name);

                // Get Settings
                $settings = Settings::where('id', 1)->get()->first();


                // pass data in dispatch
                $data_pass = [];
                $data_pass['queue_name'] = $settings->queue_name_incidents;
                $data_pass['bulk_emails'] = $settings->bulk_emails;
                $data_pass['bulk_emails_sleep'] = $settings->bulk_emails_sleep;
                $data_pass['from_address'] = $settings->from_address;
                $data_pass['from_name'] = $settings->from_name;
                $data_pass['title_app'] = $settings->title_app;
                $data_pass['code'] = $incident->code;
                $data_pass['date_of_incident'] = $incident_date_update;
                $data_pass['incident_status_name'] = $get_the_record->incident_status->incident_name;
                $data_pass['incidents_description'] = $get_the_record->incidents_description;
                $data_pass['incident_title'] = $incident->incident_title;
                $data_pass['components_name'] = $components_for_incident_name;


                dispatch(new IncidentUpdateAlert($incident->id, $get_incident_update_id, $components_for_incident_id, $data_pass))->onQueue($data_pass['queue_name']);


                return response()->json(['id' => $get_incident_update_id, 'incident_id' => $id, 'incident_statuses_id' => $incident_statuses_id,  'component_status_update' => $component_status_update, 'incident_status_name' => $get_the_record->incident_status->incident_name, 'component_statuses_id' =>  $component_statuses_id, 'incidents_description' => $get_the_record->incidents_description, 'incident_date_update' => $incident_date_update, 'success' => 'The new incident update has been added.']);

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

    public function update_edit(Request $request, $id_incident, $id_update)
    {
        $user = \Auth::user();
        if( $request->ajax() )
        {
            $incident = IncidentUpdate::with('incident')->with('incident_status')->with('component_status')->findOrFail($id_update);
            $user = \Auth::user();
            $components_status = ComponentStatus::orderby('id', 'asc')->get();
            $incident_statuses_id = IncidentStatus::OrderBy('id', 'asc')->get();
            $incident_templates = IncidentTemplates::get();

            $last_incident = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('id', 'DESC')->get()->first();

            if($last_incident->incident_statuses_id == 4 && $incident->incident_statuses_id !== 4){
                return response()->json(['warning' => 'You cannot update an incident with status Rezolved. '], 405);
            }

            return view('authentication.incidents.update_edit', compact('user','incident', 'components_status', 'incident_statuses_id', 'incident_templates'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }

    }

    public function update_update(Request $request, $id_incident, $id)
    {
        if( $request->ajax() )
        {

            $get_the_record = IncidentUpdate::findOrFail($id);
            $user = \Auth::user();
            $body_description = $request->input('incidents_description');
            $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
            $request->merge(['incidents_description' => $body]);
            $request->merge(['user_id' => $user->id]);
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'incident_statuses_id' => 'required|exists:incident_status,id',
                'component_statuses_id' => 'required|exists:component_statuses,id',
                'incidents_description' => 'required|min:10',
            ];
            $data = $request->only(['user_id', 'incident_statuses_id', 'component_statuses_id', 'incidents_description', 'updated_at']);
            $validator = Validator::make($data, $rules);

            $incident_statuses_id = (int)$request->input('incident_statuses_id');
            $component_statuses_id = $request->input('component_statuses_id');
            $incidents_description = $request->input('incidents_description');

            $updated_at = date('Y-m-d H:i:s');
            $updated_at_act = date('d/m/Y H:i:s');

            $last_id_incident_updated = "";

            if($incident_statuses_id !== $get_the_record->incident_statuses_id && $incident_statuses_id !== 5) {
                // to check if the ID is the last one in db, to apply different rules.
                $last_id_incident_updated = 0;


                // check if
                $last_incident = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('id', 'DESC')->get()->first();


                if($last_incident->id !== (int)$id) {
                    if ($incident_statuses_id > $last_incident->incident_statuses_id) {
                        return response()->json(['warning' => 'You cannot update this incident with this Resolved status. '], 405);
                    }
                }


                $count_incident_with_the_same_status = IncidentUpdate::where('incidents_id', $id_incident)->where('incident_statuses_id', $request->input('incident_statuses_id'))->whereNotIn('id', [$id])->get()->count();

                if ($count_incident_with_the_same_status == 1) {
                    return response()->json(['warning' => 'You cannot update with an existent incident status. '], 405);
                }

                $get_the_last_incident_status = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('incident_statuses_id', 'DESC')->whereNotIn('incident_statuses_id', [5, $get_the_record->incident_statuses_id])->get()->first();

                if ($get_the_last_incident_status !== null) {
                    if ($incident_statuses_id < $get_the_last_incident_status->incident_statuses_id && $incident_statuses_id !== 5) {
                        return response()->json(['warning' => 'You cannot update an incident with an inferior incident status. '], 405);
                    }
                }
            }


            if($validator->passes())

            {

                $last_incident_status = "";
                $last_incident_status_progress = "";

                $check_the_past_record = IncidentUpdate::where('incidents_id', $id_incident)->with('incident_status')->with('component_status')->OrderBy('id', 'desc')->get()->first();

                if($check_the_past_record->id == $id){

                    // last id add 1 to validate in js
                    $last_id_incident_updated = 1;

                    Incident::where('id', $get_the_record->incidents_id)->update(['incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id]);
                    IncidentUpdate::where('id', $id)->update(['incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'incidents_description' => $incidents_description, 'updated_at' => $updated_at]);

                    // get new record Incident Updated
                    $get_new_record_incident_update = IncidentUpdate::with('incident_status')->with('component_status')->where('id', $id)->get()->first();

                    $incident_date_update = $updated_at_act;
                    $component_status_update = $get_new_record_incident_update->component_status->component_status_name;

                    // Get the components for this incident
                    $get_components_incident = IncidentComponents::where('incidents_id', $id_incident)->get();

                    // update incident_components with the new status
                    foreach ($get_components_incident as $get_component){
                        IncidentComponents::where('id', $get_component->id)->update(['component_statuses_id' => $component_statuses_id]);
                    }

                    // update components with the new status
                    foreach ($get_components_incident as $get_component){
                        $get_last_incident_with_same_component = IncidentComponents::where('components_id', $get_component->components_id)->OrderBy('component_statuses_id', 'desc')->get()->first();
                        Components::where('id',  $get_component->components_id)->update(['component_statuses_id' => $get_last_incident_with_same_component->component_statuses_id]);
                    }

                    $get_the_last_incident_status = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('id', 'desc')->whereNotIn('incident_statuses_id', [5])->get()->first();


                    if($get_the_last_incident_status->incident_statuses_id == 1){
                        $last_incident_status = "bg-yellow";
                        $last_incident_status_update = "label-warning";
                        $last_incident_status_progress = "25%";
                    }
                    elseif ($get_the_last_incident_status->incident_statuses_id == 2){
                        $last_incident_status = "bg-primary";
                        $last_incident_status_update = "label-primary";
                        $last_incident_status_progress = "50%";
                    }
                    elseif ($get_the_last_incident_status->incident_statuses_id == 3) {
                        $last_incident_status = "bg-blue";
                        $last_incident_status_update = "label-primary";
                        $last_incident_status_progress = "75%";
                    }
                    else{
                        $last_incident_status = "bg-green";
                        $last_incident_status_update = "label-success";
                        $last_incident_status_progress = "100%";
                    }


                    return response()->json(['last_id_incident_updated' => $last_id_incident_updated, 'id' => $id, 'incident_id' => $id_incident, 'incident_statuses_id' => $incident_statuses_id,  'component_status_update' => $component_status_update, 'incident_status_name' => $get_new_record_incident_update->incident_status->incident_name, 'component_statuses_id' =>  $component_statuses_id, 'incidents_description' => $get_new_record_incident_update->incidents_description, 'incident_date_update' => $incident_date_update, 'last_incident_status' => $last_incident_status, 'last_incident_status_progress' => $last_incident_status_progress, 'last_incident_status_update' => $last_incident_status_update, 'success' => 'The new incident update has been edited.']);
                } else {

                    IncidentUpdate::where('id', $id)->update(['incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'incidents_description' => $incidents_description, 'updated_at' => $updated_at]);

                    $incident_date_update = $updated_at_act;
                    $component_status_update = $check_the_past_record->component_status->component_status_name;

                    $get_the_last_incident_status = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('id', 'desc')->whereNotIn('incident_statuses_id', [5])->get()->first();

                    if($get_the_last_incident_status->incident_statuses_id == 1){
                        $last_incident_status = "bg-yellow";
                        $last_incident_status_update = "label-warning";
                        $last_incident_status_progress = "25%";
                    }
                    elseif ($get_the_last_incident_status->incident_statuses_id == 2){
                        $last_incident_status = "bg-primary";
                        $last_incident_status_update = "label-primary";
                        $last_incident_status_progress = "50%";
                    }
                    elseif ($get_the_last_incident_status->incident_statuses_id == 3) {
                        $last_incident_status = "bg-blue";
                        $last_incident_status_update = "label-primary";
                        $last_incident_status_progress = "75%";
                    }
                    else{
                        $last_incident_status = "bg-green";
                        $last_incident_status_update = "label-success";
                        $last_incident_status_progress = "100%";
                    }


                    return response()->json(['last_id_incident_updated' => $last_id_incident_updated,'id' => $id, 'incident_id' => $id_incident, 'incident_statuses_id' => $incident_statuses_id,  'component_status_update' => $component_status_update, 'incident_status_name' => $check_the_past_record->incident_status->incident_name, 'component_statuses_id' =>  $component_statuses_id, 'incidents_description' => $check_the_past_record->incidents_description, 'incident_date_update' => $incident_date_update, 'last_incident_status' => $last_incident_status, 'last_incident_status_progress' => $last_incident_status_progress, 'last_incident_status_update' => $last_incident_status_update, 'success' => 'The new incident update has been edited.']);

                }
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

    public function update_delete(Request $request, $id_incident, $id)
    {
        $user = \Auth::user();
        IncidentUpdate::findOrFail($id);

        if ( $request->ajax() ) {

            $count = IncidentUpdate::where('incidents_id', $id_incident)->get()->count();

            if($count > 1){
                IncidentUpdate::where('id', $id)->delete();

                $incident_update = IncidentUpdate::with('incident')->where('incidents_id', $id_incident)->OrderBy('id', 'DESC')->get()->first();

                Incident::where('id', $id_incident)->update(['incident_statuses_id' => $incident_update->incident_statuses_id, 'component_statuses_id' => $incident_update->component_statuses_id]);

                $get_components_incident = IncidentComponents::where('incidents_id', $id_incident)->get();

                foreach ($get_components_incident as $get_component){
                    IncidentComponents::where('incidents_id', $id_incident)->update(['component_statuses_id' => $incident_update->component_statuses_id]);
                }

                foreach ($get_components_incident as $get_component){
                    $get_last_incident_with_same_component = IncidentComponents::where('components_id', $get_component->components_id)->OrderBy('component_statuses_id', 'DESC')->get()->first();
                    Components::where('id', $get_last_incident_with_same_component->components_id)->update(['component_statuses_id' => $get_last_incident_with_same_component->component_statuses_id]);
                }

                return response()->json(['success' => 'Great! The incident update has been removed!']);
            } else {
                return response()->json(['warning' => 'Error! The incident cannot be removed. You cannot remove all records.']);
            }

        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }


    }

    public function update_delete_recheck(Request $request, $id_incident, $id)
    {
        $user = \Auth::user();


        if ( $request->ajax() ) {

            $get_new_record_incident_update = IncidentUpdate::with('incident_status')->with('component_status')->where('incidents_id', $id_incident)->OrderBy('id', 'desc')->get()->first();

            $component_status_update = $get_new_record_incident_update->component_status->component_status_name;
            $incident_status_name = $get_new_record_incident_update->incident_status->incident_name;

            $incident_statuses_id = $get_new_record_incident_update->incident_statuses_id;
            $component_statuses_id = $get_new_record_incident_update->component_statuses_id;


            $get_the_last_incident_status = IncidentUpdate::where('incidents_id', $id_incident)->OrderBy('id', 'desc')->whereNotIn('incident_statuses_id', [5])->get()->first();

            $last_incident_status = "";
            $last_incident_status_progress = "";
            if($get_the_last_incident_status->incident_statuses_id == 1){
                $last_incident_status = "label-warning";
                $last_incident_status_progress = "25%";
                }
            elseif ($get_the_last_incident_status->incident_statuses_id == 2){
                $last_incident_status = "label-blue";
                $last_incident_status_progress = "50%";
                }
            elseif ($get_the_last_incident_status->incident_statuses_id == 3) {
                $last_incident_status = "label-blue";
                $last_incident_status_progress = "75%";
                }
             else{
                 $last_incident_status = "label-green";
                 $last_incident_status_progress = "100%";
                }


            return response()->json(['component_status_update' => $component_status_update, 'incident_status_name' => $incident_status_name, 'incident_statuses_id' => $incident_statuses_id, 'component_statuses_id' => $component_statuses_id, 'last_incident_status' => $last_incident_status, 'last_incident_status_progress' => $last_incident_status_progress]);
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }


    }

}
