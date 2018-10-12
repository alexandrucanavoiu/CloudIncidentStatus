<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailSubscrie;
use App\Mail\SubscribeMail;
use App\Mailers\AppMailer;
use App\Models\Incident;
use App\Models\Schedule;
use App\Models\SubscribesSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use App\Models\Components;
use App\Models\ComponentsGroup;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\IncidentUpdate;
use App\Models\Footer;
use App\Models\Subscribe;
use App\Helpers\Navigation;
use App\Models\SubscribeComponents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $schedule = Schedule::with('schedule_components')->where('scheduled_end', '>=', \Carbon\Carbon::now())->where('archived', 0)->first();

        $components_status = Components::OrderBy('component_statuses_id', 'DESC')->first();;
        $components_count = Components::get()->count();

        $settings = Settings::where('id', 1)->get()->first();
        $footer_url = Footer::OrderBy('position', 'ASC')->get();

        $curent_date_today = Carbon::now()->format('Y-m-d H:i:s');
        $subs_days_need =  Carbon::now()->subDays($settings->days_of_incidents)->format('Y-m-d H:i:s');

        $components = ComponentsGroup::with('components')->OrderBy('position', 'ASC')->get();
        $get_incidents = Incident::with('update_incident_sort_by_id')->with('incident_status')->whereBetween('created_at', array($subs_days_need, $curent_date_today))->get();

        $get_incidents_not_resolved = Incident::with('update_incident_sort_by_id')->with('incident_status')->whereNotIn('incident_statuses_id', ['4'])->whereBetween('updated_at', array($subs_days_need, $curent_date_today))->get();

        $incidents = $get_incidents->groupBy(function($data) {
            return Carbon::parse($data->updated_at)->format('d M Y');
        });


        $curent_date = Carbon::now();
        $start_date = Carbon::now()->format('d M Y');
        $end_date = $curent_date->subDays($settings->days_of_incidents)->format('d M Y');
        $a = \Carbon\CarbonPeriod::since($end_date)->until($start_date);

        $all_incidents = [];
        foreach ($a as $date)
        {
            $all_incidents[$date->format('d M Y')] = [];
        }


        foreach($incidents as $key => $single_incident)
        {
            $all_incidents[$key] = $single_incident;
        }

        $all_incidents = array_reverse($all_incidents);


        return view('index', compact('components', 'settings', 'all_incidents', 'footer_url', 'schedule', 'components_status', 'get_incidents_not_resolved', 'components_count'));
    }

    public function full_history($date_id)
    {


        $components_status = Components::OrderBy('component_statuses_id', 'DESC')->first();;

        $regex = '/^[0-9]{4}-[0-9]{2}$/';

        if (preg_match($regex, $date_id)) {
        } else {
            return redirect()->route('history', Carbon::now()->format('Y-m'));
        }


        // check if is a date
        $check = $date_id .'-01';
        list($y, $m, $d) = explode("-", $check);
        if(checkdate($m, $d, $y)){
        } else {
            return redirect()->route('history', Carbon::now()->format('Y-m'));
        }

        $footer_url = Footer::OrderBy('position', 'ASC')->get();

        //check if the date is bigger then current date
        $chosen_date = \Carbon\Carbon::parse($date_id);
        $whitelist_date = Carbon::now();

        if ($chosen_date->greaterThan($whitelist_date)) {
            return redirect()->route('history', Carbon::now()->format('Y-m'));
        }


        $settings = Settings::where('id', 1)->first();
        $get_date = $date_id . "00:00:00";




        // old with 3 months
        $forward_date = $date_id;
        $forward_date = \Carbon\Carbon::parse($forward_date)->startOfMonth();
        $forward_date = $forward_date->subMonth(3)->format('Y-m');

        // new with 3 months
        $next_date = $date_id;
        $next_date = \Carbon\Carbon::parse($next_date)->startOfMonth();
        $next_date = $next_date->addMonths(3)->format('Y-m');


        // date start
        $subs_days_need = \Carbon\Carbon::parse($get_date)->startOfMonth();
        $subs_days_need =  $subs_days_need->subMonths(2)->format('Y-m-d H:i:s');

        // date end
        $get_date2 = \Carbon\Carbon::parse($get_date)->endOfMonth()->format('Y-m-d H:i:s');;


        $components = ComponentsGroup::with('components')->OrderBy('position', 'ASC')->get();

        $get_incidents = Incident::with('update_incident_sort_by_id', 'incident_status')
            ->whereBetween('updated_at', array($subs_days_need, $get_date2))
            ->get();


        $incidents = $get_incidents->groupBy(function($data) {
            return Carbon::parse($data->updated_at)->format('F Y');
        });


        $a = \Carbon\CarbonPeriod::since($subs_days_need)->until($get_date2);



        $all_incidents = [];
        foreach ($a as $date)
        {
            $all_incidents[$date->format('F Y')] = [];
        }

        foreach($incidents as $key => $single_incident)
        {
            $all_incidents[$key] = $single_incident;
        }

        $all_incidents = array_reverse($all_incidents);


        return view('history', compact('components', 'settings', 'all_incidents', 'forward_date', 'next_date', 'date_id', 'footer_url', 'today', 'components_status'));
    }

    public function incident($code)
    {

        $components_status = Components::OrderBy('component_statuses_id', 'DESC')->first();;


        $incident = Incident::with('incident_status')->with('update_incident')->with('incident_components')->where('code', $code)->get()->first();

        if($incident == null){
            return redirect()->route('history', Carbon::now()->format('Y-m'));
        }

        $components = ComponentsGroup::with('components')->OrderBy('position', 'ASC')->get();
        $settings = Settings::where('id', 1)->get()->first();
        $footer_url = Footer::OrderBy('position', 'ASC')->get();



        return view('incident', compact('settings',  'footer_url', 'components', 'incident', 'components_status'));
    }

    public function get_subscribe(Request $request)
    {
        $user = \Auth::user();
        if( $request->ajax() )
        {

            $settings = Settings::where('id', 1)->get()->first();

            if($settings->allow_subscribers === 0){
                $notification = array(
                    'message' => 'Sorry, but right now you cannot subscribe.',
                    'title' => 'Subscribe',
                    'type' => 'warning'
                );
                return \Response::json($notification, 404);
            } else {
                return view('subscribe.new', compact('allow'));
            }

        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'title' => 'Error',
                'type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }

    }

    public function post_subscribe(Request $request, AppMailer $mailer)
    {

        $code = Navigation::generateRandomStringSubscribe();
        $code_security = Navigation::generateRandomStringSubscribe();
        $request->merge(['created_at' => date('Y-m-d H:i:s')]);
        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
        $request->merge(['status' => 0]);
        $request->merge(['code' => $code]);
        $request->merge(['code_security' => $code_security]);
        $rules = [
            'email' => 'required|email',
        ];

        $data = $request->only(['email', 'code', 'code_security', 'status', 'created_at', 'updated_at']);
        $validator = Validator::make($data, $rules);

        if( $request->ajax() )
        {
            if($validator->passes())
            {

                $check_if_email_exist = Subscribe::where('email', $request->input('email'))->get()->first();

                if($check_if_email_exist !== null){

                    return response()->json(['code' => $check_if_email_exist->code]);

                } else {
                    Subscribe::create($data);
                    $settings = Settings::where('id', 1)->get()->first();
                    $title_app = $settings->title_app;
                    $from_address = $settings->from_address;
                    $from_name = $settings->from_name;
                    $mailer->sendConfirmationSubscribe($code, $request->input('email'), $from_address, $from_name, $title_app, $code_security);

                    return response()->json(['code' => $code]);
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

    public function manage_subscribe($code)
    {

        $subscribe = Subscribe::where('code', $code)->get()->first();

        if($subscribe !== null ){

            $settings = Settings::where('id', 1)->get()->first();
            $footer_url = Footer::OrderBy('position', 'ASC')->get();
            $components = ComponentsGroup::with('components')->OrderBy('position', 'ASC')->get();

            $components_selected = SubscribeComponents::where('subscribes_id', $subscribe->id)->get();

            $collection = collect([0]);
            foreach ($components_selected as $component){
                $collection->push($component->components_id);
            }

            $searchcomponents = $collection->all();
            $searchcomponents = collect($searchcomponents);



            return view('manage_subscribe', compact('subscribe', 'settings', 'footer_url', 'components', 'searchcomponents'));

        } else {
            return redirect()->route('index');
        }

    }

    public function manage_subscribe_update($code, Request $request, SubscribeComponents $subscribeComponents)
    {

        $subscribe = Subscribe::where('code', $code)->get()->first();

        $rules = [
            'components_id' => 'required',
        ];

        $data = $request->only(['components_id', 'created_at', 'updated_at']);
        $validator = Validator::make($data, $rules);


        if($subscribe !== null ){

            SubscribeComponents::where('subscribes_id', '=', $subscribe->id)->delete();
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $subscribes_selected = [];

            foreach ($request->get('components_id') as $entity)
            {
                $subscribes_selected[] = [
                    'subscribes_id' => $subscribe->id,
                    'components_id'=> $entity,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ];
            }

            $subscribeComponents->create($subscribes_selected);

            $notification = array(
                'message' => 'Awesome! Your subscription preferences have been updated.',
                'title' => 'Update Preferences',
                'type' => 'success'
            );
            return redirect()->route('manage-subscribe-store', $code)->with($notification);

        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'title' => 'Error',
                'type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }

    }

    public function manage_subscribe_reconfirm($code, AppMailer $mailer)
    {
        $subscribe = Subscribe::where('code', $code)->get()->first();
        if($subscribe !== null ){

            $settings = Settings::where('id', 1)->get()->first();
            $title_app = $settings->title_app;
            $from_address = $settings->from_address;
            $from_name = $settings->from_name;
            $mailer->sendConfirmationSubscribe($code, $subscribe->email, $from_address, $from_name, $title_app, $subscribe->code_security);

            $notification = array(
                'message' => 'Sent confirmation link to your email. Please confirm it.',
                'title' => 'Re-send Confirmation',
                'type' => 'success'
            );
            return redirect()->route('manage-subscribe', $code)->with($notification);

        } else {
            return redirect()->route('index');
        }

    }

    public function manage_subscribe_confirm($code, $code_security)
    {
        $subscribe = Subscribe::where('code', $code)->where('code_security', $code_security)->get()->first();
        if($subscribe !== null ){

            if($subscribe->status === 1){
                $notification = array(
                    'message' => 'You already  confirmed this subscription.',
                    'title' => 'Subscription',
                    'type' => 'warning'
                );
                return redirect()->route('manage-subscribe', $code)->with($notification);
            } else {
                $subscribe->update(['status' => 1]);
                $components = Components::get();
                $updated_at = $created_at = date('Y-m-d H:i:s');
                foreach ($components as $component){
                    SubscribeComponents::insert(['subscribes_id' => $subscribe->id, 'components_id' => $component->id, 'created_at' => $created_at, 'updated_at' =>  $updated_at]);
                }

                $notification = array(
                    'message' => 'Thank you for the confirmation.',
                    'title' => 'Confirmation Completed',
                    'type' => 'success'
                );
                return redirect()->route('manage-subscribe', $code)->with($notification);
            }

        } else {
            return redirect()->route('index');
        }

    }

    public function manage_subscribe_cancel($code, Request $request)
    {
        if( $request->ajax() )
        {
            $subscribe = Subscribe::where('code', $code)->get()->first();
            if($subscribe !== null ){
                $settings = Settings::where('id', 1)->get()->first();
                $title_app = $settings->title_app;
                $email = $subscribe->email;
                return view('subscribe.cancel', compact('title_app','code', 'email'));

            } else {
                return redirect()->route('index');
            }

        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'title' => 'Error',
                'type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }

    }

    public function manage_subscribe_cancel_confirm($code, Request $request, AppMailer $mailer)
    {
        if( $request->ajax() )
        {
            $subscribe = Subscribe::where('code', $code)->get()->first();

            $code = $request->input('code');

            $rules = [
                'code' => 'required|exists:subscribes,code',
            ];
            $data = $request->only(['code']);
            $validator = Validator::make($data, $rules);


            if($validator->passes()) {

                if ($subscribe !== null) {
                    $settings = Settings::where('id', 1)->get()->first();
                    $title_app = $settings->title_app;
                    $email = $subscribe->email;
                    $code_security = $subscribe->code_security;
                    $from_address = $settings->from_address;
                    $from_name = $settings->from_name;
                    $mailer->sendConfirmationUnSubscribe($code, $email, $from_address, $from_name, $title_app, $code_security);

                    return response()->json(['message' => 'We sent you an email. Please confirm it.', 'title' => 'Cancel Subscription', 'type' => 'success'], 200);
                } else {
                    return redirect()->route('index');
                }

            } else {

                $notification = array(
                    'message' => 'Ilegal operation',
                    'title' => 'Error',
                    'type' => 'error'
                );
                return redirect()->route('index')->with($notification);
            }

        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'title' => 'Error',
                'type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }

    }

    public function manage_subscribe_cancel_confirm_code($code, $code_security)
    {
        $subscribe = Subscribe::where('code', $code)->where('code_security', $code_security)->get()->first();
        if($subscribe !== null ){

            $subscribe->delete();
            SubscribeComponents::where('subscribes_id', $subscribe->id)->delete();

            Session::flash('message', 'Thank you for the confirmation.');
            Session::flash('title', 'Confirmation Unsubscribe');
            Session::flash('type', 'success');

            return redirect()->route('index');


        } else {
            return redirect()->route('index');
        }

    }

}
