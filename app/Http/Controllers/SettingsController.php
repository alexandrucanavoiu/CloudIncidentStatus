<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Settings;
use App\User;
use Illuminate\Http\Request;
use Response;
use DB;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use DateTimeZone;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use App\Helpers\Navigation;

class SettingsController extends Controller
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
            $settings = Settings::where('id', 1)->get()->first();
            $links = Footer::OrderBy('position', 'ASC')->get();
            return view('authentication.settings.index', compact('user', 'settings', 'links'));
        } else {
            $notification = array(
                'message' => 'You don\'t have permission to access this area.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function edit(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $id = 1;
            if($user->level == 10){
                $setting = Settings::findOrFail($id);
                $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

                return view('authentication.settings.edit', compact('user', 'setting', 'timezonelist'));
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

    public function update(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();

            if($user->level == 10){
                $setting = Settings::findOrFail(1);

                $rules = [
                    'time_zone_interface' => 'required|min:3|max:50',
                    'title_app' => 'required|min:5|max:255',
                    'settings_logo' => '',
                    'days_of_incidents' => 'required|integer|digits_between:1,14',
                    'google_analytics_code' => 'max:20',
                    'bulk_emails' => 'required|integer|min:1|max:1000',
                    'bulk_emails_sleep' => 'required|integer|min:1|max:1000',
                    'queue_name_incidents' => 'required|min:5|max:255',
                    'queue_name_maintenance' => 'required|min:5|max:255',
                    'from_address' => 'required|min:5|max:255',
                    'from_name' => 'required|min:5|max:255',
                    'allow_subscribers' => 'required|integer|digits_between::0,1'
                ];

                $data = $request->only(['time_zone_interface', 'title_app', 'settings_logo', 'days_of_incidents', 'bulk_emails', 'bulk_emails_sleep', 'queue_name_incidents', 'queue_name_maintenance', 'from_address', 'from_name', 'google_analytics_code', 'allow_subscribers']);
                $validator = Validator::make($data, $rules);


                if($validator->passes())
                {

                    if ($request->hasFile('settings_logo')) {
                        $image = $request->file('settings_logo');

                            // remove img
                        $location = "images/";
                        if (file_exists($location . $setting->settings_logo)) {
                            unlink($location . $setting->settings_logo);
                        }

                        // add image

                        $folder = "images/";

                        $filename = $image->getClientOriginalName();
                        $filename = substr("$filename", 0, -strlen($image->getClientOriginalExtension()) - 1);
                        $filename = Str::slug($filename, '_') . '.' . $image->getClientOriginalExtension();
                        $locationupload = $folder . $filename;

                        if (file_exists($locationupload)) {
                            $random = Navigation::generateRandomString();
                            $filename = $image->getClientOriginalName();
                            $filename = substr("$filename", 0, -strlen($image->getClientOriginalExtension()) - 1);
                            $filename = Str::slug($filename, '_') . '_' . $random . '.' . $image->getClientOriginalExtension();
                            $locationupload = $locationupload = $folder . $filename;
                        }

                        $locationdb = "{$filename}";


                        $data['settings_logo'] = $locationdb;

                        $image_full = Image::make($image);
                        $image_full->orientate();
                        $image_full->resize(200, null, function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        });
                        $image_full->save(public_path($locationupload), 80);

                    } else {
                        unset($data['settings_logo']);
                    }
                    $setting->update($data);

                    $new_settings = Settings::findOrFail(1);

                    $site_name = $new_settings->title_app;
                    $site_timezone = $new_settings->time_zone_interface;
                    $days_of_incident = $new_settings->days_of_incidents;
                    $bulk_emails = $new_settings->bulk_emails;
                    $bulk_emails_sleep = $new_settings->bulk_emails_sleep;
                    $queue_name_incidents = $new_settings->queue_name_incidents;
                    $queue_name_maintenance = $new_settings->queue_name_maintenance;
                    $from_address = $new_settings->from_address;
                    $from_name = $new_settings->from_name;
                    $google_code = $new_settings->google_analytics_code;
                    $allow_signup = $new_settings->allow_subscribers;
                    $logo = $new_settings->settings_logo;

                    return response()->json(['site_name' => $site_name, 'site_timezone' => $site_timezone, 'days_of_incident' => $days_of_incident, 'bulk_emails' => $bulk_emails, 'bulk_emails_sleep' => $bulk_emails_sleep, 'queue_name_incidents' => $queue_name_incidents, 'queue_name_maintenance' => $queue_name_maintenance, 'from_address' => $from_address, 'from_name' => $from_name, 'google_code' => $google_code, 'allow_signup' => $allow_signup, 'logo' => $logo, 'success' => 'The settings has been updated.']);

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

    public function links_index_update(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $rules = [
                'results' => 'required',
            ];
            $data = $request->only(['results']);
            $validator = Validator::make($data, $rules);

            if($validator->passes())

            {
                if($user->level == 10){

                $results = $request->get('results');
                $results = json_decode($results,true);


                foreach ($results as $result){
                    $res = Footer::where('id', $result['id'])->get()->first();
                    if(!($res)){
                        return response()->json(['warning' => 'Error!  The links has been compromised.']);
                    }
                }

                foreach ($results as $result){
                    Footer::where('id', $result['id'])->update(['position' => $result['position']]);
                }

                return response()->json(['success' => 'Great! The footer links list has been updated.']);

                } else {
                    return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
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

    public function links_create(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            if($user->level == 10){
                return view('authentication.settings.footer-new', compact('user'));
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

    public function links_store(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $request->merge(['user_id' => $user->id]);
            $request->merge(['created_at' => date('Y-m-d H:i:s')]);
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'footer_title' => 'required|max:255|min:3',
                'footer_url' => 'required|url',
                'target_url' => 'required|numeric|digits_between::0,1',
            ];
            $last_position = Footer::OrderBy('position', 'desc')->get()->first();
            if($last_position == null){
                $last_position =  0;
            } else {
                $last_position =  $last_position->position + 1;
            }
            $request->merge(['position' => $last_position]);


            $messages = [
                'footer_url.required' => 'Please enter a valid URL.',
                'footer_url.regex' => 'your url have to be a valid url' . "<br/>" . "<span class='val_error_small'>". '(try putting http:// or https:// or another prefix at the beginning)'. "</span>",
            ];

            $data = $request->only(['user_id', 'footer_title', 'footer_url', 'target_url', 'position', 'created_at', 'updated_at']);
            $validator = Validator::make($data, $rules, $messages);

            if($validator->passes())

            {
                $footer_title = $data['footer_title'];
                $footer_url = $data['footer_url'];
                $target_url = $data['target_url'];
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');

                $save = Footer::insertGetId(
                    ['user_id' => $user->id, 'footer_title' => $footer_title, 'footer_url' => $footer_url, 'target_url' => $target_url, 'position' => $last_position, 'created_at' => $created_at, 'updated_at' => $updated_at]
                );

                $check_count_footer_links = Footer::get()->count();


                return response()->json(['id' => $save, 'footer_title' => $data['footer_title'], 'footer_url' => $data['footer_url'], 'target_url' => $target_url, 'check_count_footer_links' => $check_count_footer_links,'success' => 'The new footer link has been added.']);


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

    public function links_delete(Request $request, $id)  {
        $user = \Auth::user();
        Footer::findOrFail($id);

        if ( $request->ajax() ) {
            if($user->level == 10){
            $count = Footer::where('id', $id)->get()->count();
                    if($count >= 1){
                        Footer::where('id', $id)->delete();
                        return response()->json(['success' => 'Great! The footer link has been removed!']);
                    } else {
                        $notification = array(
                            'message' => 'Ilegal operation. The administrator was notified.',
                            'alert-type' => 'error'
                        );
                        return redirect()->route('authenticated.dashboard')->with($notification);
                    }
            } else {
                return Response::json(['warning' => 'You don\'t have permission to access this area.'], 405);
            }

        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }


    }

    public function links_edit(Request $request, $id) {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            if($user->level == 10){
                $link = Footer::findOrFail($id);

                return view('authentication.settings.footer-edit', compact('user', 'link'));
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

    public function links_update(Request $request, $id)
    {
        if( $request->ajax() )
        {

            $link = Footer::findOrFail($id);

            $regex = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]\i';

            $user = \Auth::user();
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'footer_title' => 'required|max:255|min:3',
//                'footer_url' => 'required|regex:'.$regex,
                'footer_url' => 'required',
                'target_url' => 'required|numeric|digits_between::0,1',
            ];

//            $messages = [
//                'footer_url.required' => 'Please enter a valid URL.',
//                'footer_url.regex' => 'your url have to be a valid url' . "<br/>" . "<span class='val_error_small'>". '(try putting http:// or https:// or another prefix at the beginning)'. "</span>",
//            ];

            $data = $request->only(['footer_title', 'footer_url', 'target_url', 'updated_at']);
            $validator = Validator::make($data, $rules);

            if($validator->passes())

            {
                $footer_title = $data['footer_title'];
                $footer_url = $data['footer_url'];
                $target_url = $data['target_url'];


                Footer::where('id', $id)->update($data);

                $check_count_footer_links = Footer::get()->count();

                return response()->json(['id' => $link->id, 'footer_title' => $footer_title, 'footer_url' => $footer_url, 'target_url' => $target_url, 'check_count_footer_links' => $check_count_footer_links,'success' => 'The new footer link has been added.']);


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

}
