<?php

namespace App\Http\Controllers;

use App\Jobs\MaintenanceNewAlert;
use App\Models\Components;
use App\Models\MaintenanceSent;
use App\Models\Schedule;
use App\Models\ScheduleComponents;
use App\Models\Settings;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\User;
use Carbon\Carbon;

class ScheduleController extends Controller
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
        $scheduleds = Schedule::with('author')->OrderBy('created_at', 'DESC')->where('scheduled_start', '>=', \Carbon\Carbon::now())->paginate(6);
        $scheduleds_archived = Schedule::with('author')->OrderBy('created_at', 'DESC')->where('scheduled_start', '<', \Carbon\Carbon::now())->paginate(6);

        return view('authentication.scheduled.index', compact('user', 'scheduleds', 'scheduleds_archived'));
    }

    public function create(Request $request)
    {
        if( $request->ajax() )
        {

            $count_components = Components::get()->count();

            if($count_components == 0){
                return response()->json(['warning' => 'To add a component, please first add a component.'], 405);
            } else {
                $user = \Auth::user();
                $current_date_time = \Carbon\Carbon::now();
                $components = Components::with('component_group')->get();
                return view('authentication.scheduled.new', compact('user', 'current_date_time', 'components'));
            }
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function store(Request $request, ScheduleComponents $ScheduleComponents)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            // create array for components_id
            $components_array = [];
            $components_array = $request->input('components_id');
            $components_array = explode(",", $components_array);
            foreach ($components_array as $key => $a){
                $components_array[$key] =  $a;
            }
            $request->merge(['components_id' => $components_array]);
            $body_description = $request->input('scheduled_description');
            $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
            $request->merge(['scheduled_description' => $body]);
            $request->merge(['user_id' => $user->id]);
            $request->merge(['created_at' => date('Y-m-d H:i:s')]);
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'scheduled_title' => 'required|max:255|min:3',
                'components_id' => 'required|array|min:1|max:5',
                'components_id.*' => 'required|numeric|exists:components,id',
                'scheduled_description' => 'required|min:10',
                'scheduled_start' => 'required|date_format:Y-m-d H:i:s|before:scheduled_end',
                'scheduled_end' => 'required|date_format:Y-m-d H:i:s|after:scheduled_start',
                'archived' => 'required|numeric|digits_between::0,1'
            ];
            $data = $request->only(['user_id', 'scheduled_title', 'components_id', 'scheduled_description', 'scheduled_start', 'scheduled_end', 'archived', 'created_at', 'updated_at']);
            $validator = Validator::make($data, $rules);
            if($validator->passes())
            {

                $scheduled_title = $request->input('scheduled_title');
                $components_id = $request->input('components_id');
                $scheduled_description = $request->input('scheduled_description');
                $scheduled_start = $request->input('scheduled_start');
                $scheduled_end = $request->input('scheduled_end');
                $archived = $request->input('archived');
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');

                $schedule_id = Schedule::insertGetId(
                    ['user_id' => $user->id, 'scheduled_title' => $scheduled_title, 'scheduled_description' => $scheduled_description, 'scheduled_start' => $scheduled_start, 'scheduled_end' => $scheduled_end, 'archived' => $archived, 'created_at' => $created_at, 'updated_at' => $updated_at]
                );

                // Array from ajax components_id
                $IncidentComponentsArray = [];


                foreach ($components_id as $component_insert)
                {
                    $IncidentComponentsArray[] = [
                        'scheduled_id' => $schedule_id,
                        'components_id'=> $component_insert,
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ];

                }


                // Insert components in db
                $ScheduleComponents->create($IncidentComponentsArray);

                if($archived == 0){
                    // create a string from components_id array
                    $get_records_from_scheduled_manintenances = $ScheduleComponents->with('component_name')->where('scheduled_id', $schedule_id)->get();;
                    $component_name_list = [];

                    foreach ($get_records_from_scheduled_manintenances as $item){
                        $component_name_list[] = $item->component_name->component_name;
                    }

                    $component_name = implode(', ', $component_name_list);

                    // Get Settings
                    $settings = Settings::where('id', 1)->get()->first();

                    // pass data in dispatch
                    $data_pass = [];
                    $data_pass['queue_name'] = $settings->queue_name_maintenance;
                    $data_pass['bulk_emails'] = $settings->bulk_emails;
                    $data_pass['bulk_emails_sleep'] = $settings->bulk_emails_sleep;
                    $data_pass['from_address'] = $settings->from_address;
                    $data_pass['from_name'] = $settings->from_name;
                    $data_pass['title_app'] = $settings->title_app;
                    $data_pass['components_id'] = $components_id;
                    $data_pass['components_name'] = $component_name;

                    $data_pass['scheduled_title'] = $scheduled_title;
                    $data_pass['scheduled_description'] = $scheduled_description;
                    $data_pass['scheduled_start'] = $scheduled_start;
                    $data_pass['scheduled_end'] = $scheduled_end;
                    $data_pass['updated_at'] = $updated_at;

                    dispatch(new MaintenanceNewAlert($schedule_id, $components_id, $data_pass))->onQueue($data_pass['queue_name']);
                }

                $check_count_schedule = Schedule::get()->count();
                return response()->json(['id' => $schedule_id, 'scheduled_title' => $scheduled_title,  'scheduled_start' => $scheduled_start, 'scheduled_end' => $scheduled_end, 'archived' => $archived, 'check_count_schedule' => $check_count_schedule, 'success' => 'The new schedule has been added.']);

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
            $schedule = Schedule::findOrFail($id);
            $components = Components::with('component_group')->get();

            $components_selected = ScheduleComponents::where('scheduled_id', $id)->get();

            $collection = collect([0]);
            foreach ($components_selected as $component){
                $collection->push($component->components_id);
            }

            $searchcomponents = $collection->all();
            $searchcomponents = collect($searchcomponents);

            return view('authentication.scheduled.edit', compact('user', 'schedule', 'components', 'searchcomponents'));
        }  else {
           $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
           return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @param ScheduleComponents $scheduleComponents
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id, ScheduleComponents $scheduleComponents)
    {
        if( $request->ajax() )
        {
                $user = \Auth::user();
                $schedule = Schedule::findOrFail($id);

                // fi archived will be 1 and 0 to the new archived input will do dispatch
            $archived_status = $schedule->archived;

            // create array for components_id
            $components_array = [];
            $components_array = $request->input('components_id');
            $components_array = explode(",", $components_array);
            foreach ($components_array as $key => $a){
                $components_array[$key] =  $a;
            }

            $request->merge(['components_id' => $components_array]);
            $body_description = $request->input('scheduled_description');
            $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
            $request->merge(['scheduled_description' => $body]);
                $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
                $rules = [
                    'scheduled_title' => 'required|max:255|min:3',
                    'components_id' => 'required|array|min:1|max:5',
                    'components_id.*' => 'required|numeric|exists:components,id',
                    'scheduled_description' => 'required|min:10',
                    'scheduled_start' => 'required|date_format:Y-m-d H:i:s|before:scheduled_end',
                    'scheduled_end' => 'required|date_format:Y-m-d H:i:s|after:scheduled_start',
                    'archived' => 'required|numeric|digits_between::0,1'
                ];
                $data = $request->only(['user_id', 'scheduled_title', 'components_id', 'scheduled_description', 'scheduled_start', 'scheduled_end', 'archived', 'updated_at']);
                $validator = Validator::make($data, $rules);

                if ($validator->passes()) {

                    $scheduled_title = $request->input('scheduled_title');
                    $components_id = $request->input('components_id');
                    $scheduled_description = $request->input('scheduled_description');
                    $scheduled_start = $request->input('scheduled_start');
                    $scheduled_end = $request->input('scheduled_end');
                    $archived = $request->input('archived');
                    $updated_at = date('Y-m-d H:i:s');

                    $schedule->update(['scheduled_title' => $scheduled_title, 'scheduled_description' => $scheduled_description, 'scheduled_start' => $scheduled_start, 'scheduled_end' => $scheduled_end, 'archived' => $archived, 'updated_at' => $updated_at]);

                    // Array from ajax components_id
                    $IncidentComponentsArray = [];

                    foreach ($components_id as $component_insert)
                    {
                        $IncidentComponentsArray[] = [
                            'scheduled_id' => $schedule->id,
                            'components_id'=> $component_insert,
                            'created_at' => $updated_at,
                            'updated_at' => $updated_at
                        ];
                    }

                    $scheduleComponents->where('scheduled_id', $id)->delete();

                    // Insert components in db
                    $scheduleComponents->create($IncidentComponentsArray);

                    // check if the emails were sent
                    $check_subscribe_maintenance_sent = MaintenanceSent::where('scheduled_id', $schedule->id)->get()->count();

                    if($archived == 0 && $archived_status == 1 && $check_subscribe_maintenance_sent == 0){

                        // create a string from components_id array
                        $get_records_from_scheduled_manintenances = $scheduleComponents->with('component_name')->where('scheduled_id', $schedule->id)->get();;
                        $component_name_list = [];

                        foreach ($get_records_from_scheduled_manintenances as $item){
                            $component_name_list[] = $item->component_name->component_name;
                        }

                        $component_name = implode(', ', $component_name_list);

                        // Get Settings
                        $settings = Settings::where('id', 1)->get()->first();

                        // pass data in dispatch
                        $data_pass = [];
                        $data_pass['bulk_emails'] = $settings->bulk_emails;
                        $data_pass['bulk_emails_sleep'] = $settings->bulk_emails_sleep;
                        $data_pass['from_address'] = $settings->from_address;
                        $data_pass['from_name'] = $settings->from_name;
                        $data_pass['title_app'] = $settings->title_app;
                        $data_pass['components_id'] = $components_id;
                        $data_pass['components_name'] = $component_name;

                        $data_pass['scheduled_title'] = $scheduled_title;
                        $data_pass['scheduled_description'] = $scheduled_description;
                        $data_pass['scheduled_start'] = $scheduled_start;
                        $data_pass['scheduled_end'] = $scheduled_end;
                        $data_pass['updated_at'] = $updated_at;

                        dispatch(new MaintenanceNewAlert($schedule->id, $components_id, $data_pass))->onQueue('Maintenance');
                    }

                    return response()->json(['success' => 'Great! The Schedule has been updated.', 'id' => $schedule->id, 'scheduled_title' => $schedule->scheduled_title, 'scheduled_start' => $schedule->scheduled_start, 'scheduled_end' => $schedule->scheduled_end, 'archived' => $schedule->archived]);

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
        $check_if_the_schedule_exist= Schedule::where('id', $id)->get()->count();
        if ( $request->ajax()) {
            if( $check_if_the_schedule_exist == 1){
                $user = \Auth::user();
                Schedule::findOrFail($id);
                Schedule::where('id', $id)->delete();
                $check_count_schedule= Schedule::get()->count();
                return response()->json(['check_count_schedule' => $check_count_schedule, 'success' => 'Great! The Schedule has been removed!']);
            } else {
                return response()->json(['warning' => 'Great! You try to modify something by hand... it is ilegal...']);
            }
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }
}
