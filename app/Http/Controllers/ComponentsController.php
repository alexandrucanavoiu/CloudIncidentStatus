<?php

namespace App\Http\Controllers;

use App\Models\IncidentComponents;
use App\Models\IncidentUpdate;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\ComponentsGroup;
use App\Models\Components;
use App\Models\ComponentStatus;
use App\Models\Incident;

class ComponentsController extends Controller
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

    public function groups_index()
    {
        $user = \Auth::user();
        $components_groups = ComponentsGroup::OrderBy('position', 'ASC')->get();
        return view('authentication.components.groups', compact('user', 'components_groups'));
    }

    public function groups_create(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            return view('authentication.components.groups_new', compact('user'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function groups_store(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $request->merge(['user_id' => $user->id]);
            $body_description = $request->input('component_description');
            $body =  strip_tags($body_description, '<div><p><strong><b><i><u>');
            $request->merge(['component_description' => $body]);
            $request->merge(['created_at' => date('Y-m-d H:i:s')]);
            $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
            $rules = [
                'component_groups_name' => 'required|max:255|min:3',
                'visibility_group' => 'required|numeric|required_with:1,2,3',
                'status' => 'required|numeric|digits_between::0,1',
            ];
            $last_position = ComponentsGroup::OrderBy('position', 'desc')->get()->first();
            if($last_position == null){
                $last_position =  0;
            } else {
                $last_position =  $last_position->position + 1;
            }
            $request->merge(['position' => $last_position]);

            $data = $request->only(['user_id', 'component_groups_name', 'visibility_group', 'position', 'status', 'created_at', 'updated_at']);
            $validator = Validator::make($data, $rules);

            if($validator->passes())

            {
                $save = ComponentsGroup::create($data);
                $check_count_component_groups = ComponentsGroup::get()->count();
                return response()->json(['id' => $save->id, 'component_groups_name' => $save->component_groups_name, 'check_count_component_groups' => $check_count_component_groups, 'success' => 'The new component group has been added.']);


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

    public function groups_edit(Request $request, $id)
    {
        if( $request->ajax() )
        {
        $user = \Auth::user();
        $component = ComponentsGroup::findOrFail($id);
        return view('authentication.components.groups_edit', compact('user', 'component'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function groups_update(Request $request, $id)
    {
        if( $request->ajax() )
        {
                $user = \Auth::user();
                $component = ComponentsGroup::findOrFail($id);
                $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
                $rules = [
                    'component_groups_name' => 'required|max:255|min:3',
                    'visibility_group' => 'required|numeric|digits_between:1,3',
                    'status' => 'required|numeric|digits_between::0,1',
                ];
                $data = $request->only(['component_groups_name', 'visibility_group', 'status', 'updated_at']);
                $validator = Validator::make($data, $rules);

                if ($validator->passes()) {
                    $component->update($data);
                    return response()->json(['success' => 'Great! The component group has been updated.', 'id' => $component->id]);

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

    public function groups_destroy($id, Request $request)
    {
        if ( $request->ajax() ) {
            $user = \Auth::user();
            ComponentsGroup::findOrFail($id);
            $components = Components::where('component_groups_id', $id)->get()->count();
            if($components == 0){
                ComponentsGroup::where('id', $id)->delete();
                $check_count_component_groups = ComponentsGroup::get()->count();
                return response()->json(['check_count_component_groups' => $check_count_component_groups, 'success' => 'Great! The component group has been removed!']);
            } else {
                return response()->json(['warning' => 'This Group has components assigned, please remove them first.'], 405);
            }
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function groups_index_update(Request $request)
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
                $results = $request->get('results');
                $results = json_decode($results,true);


                foreach ($results as $result){
                    $res = ComponentsGroup::where('id', $result['id'])->get()->first();
                    if(!($res)){
                        return response()->json(['warning' => 'Error!  The component groups has been compromised.']);
                    }
                }

                foreach ($results as $result){
                    ComponentsGroup::where('id', $result['id'])->update(['position' => $result['position']]);
                }

                return response()->json(['success' => 'Great! The component groups list has been updated.']);

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

    public function components_index()
    {
        $user = \Auth::user();
        $components = Components::with('component_group')->OrderBy('position', 'ASC')->get();
        return view('authentication.components.components', compact('user', 'components'));
    }

    public function components_create(Request $request)
    {
        if( $request->ajax() )
            {
                $user = \Auth::user();
                $check_component_groups = ComponentsGroup::get()->count();
                if($check_component_groups > 0){
                    $component_groups = ComponentsGroup::OrderBy('position', 'ASC')->get();
                    $component_statues = ComponentStatus::OrderBy('id', 'ASC')->get();
                    return view('authentication.components.components_new', compact('user', 'component_groups', 'component_statues'));
                } else {
                    return Response::json(['warning' => 'To add a component, please first add a component groups.'], 405);
                }
            }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function components_store(Request $request)
{
    if( $request->ajax() )
    {
        $user = \Auth::user();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['created_at' => date('Y-m-d H:i:s')]);
        $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
        $rules = [
            'component_name' => 'required|max:255|min:3',
            'component_groups_id' => 'required',
            'component_statuses_id' => 'required',
            'component_description' => 'max:1600',
            'status' => 'required|numeric|digits_between::0,1',
        ];

        $last_position = Components::OrderBy('position', 'desc')->get()->first();

        if($last_position == null){
            $last_position =  0;
        } else {
            $last_position =  $last_position->position + 1;
        }

        $request->merge(['position' => $last_position]);

        $data = $request->only(['user_id', 'component_name', 'component_groups_id', 'component_statuses_id', 'component_description', 'position', 'status', 'created_at', 'updated_at']);
        $validator = Validator::make($data, $rules);


        if($validator->passes())
        {
            $save = Components::create($data);
            $component_group_name = ComponentsGroup::where('id', $save->component_groups_id)->first();
            $check_count_components_list = Components::get()->count();
            return response()->json(['id' => $save->id, 'component_name' => $save->component_name,  'component_group_name' => $component_group_name->component_groups_name, 'status_data' => $save->status, 'check_count_components_list' => $check_count_components_list,  'success' => 'The new componenthas been added.']);


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

    public function components_edit(Request $request ,$id)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $component = Components::findOrFail($id);
            $component_groups = ComponentsGroup::OrderBy('position', 'ASC')->get();
            $component_statues = ComponentStatus::OrderBy('id', 'ASC')->get();
            return view('authentication.components.components_edit', compact('user', 'component', 'component_groups', 'component_statues'));
        }  else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function components_update(Request $request, $id)
    {
        if( $request->ajax() )
            {
                $user = \Auth::user();
                $component = Components::findOrFail($id);
                $request->merge(['updated_at' => date('Y-m-d H:i:s')]);
                $rules = [
                    'component_name' => 'required|max:255|min:3',
                    'component_groups_id' => 'required',
                    'component_statuses_id' => 'required',
                    'component_description' => 'max:1600',
                    'status' => 'required|numeric|digits_between::0,1',
                ];
                $data = $request->only(['component_name', 'component_groups_id', 'component_statuses_id', 'component_description', 'status', 'updated_at']);
                $validator = Validator::make($data, $rules);
                if ($validator->passes()) {
                    $component->update($data);
                    $component_group_name = ComponentsGroup::where('id', $component->component_groups_id)->first();
                    return response()->json(['component_name' => $component->component_name, 'component_group_name' => $component_group_name->component_groups_name, 'success' => 'Great! The componenthas been updated.', 'id' => $component->id]);

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

    public function components_destroy($id, Request $request)
    {
        if ( $request->ajax() ) {
            $user = \Auth::user();
            $component = Components::findOrFail($id);
            $count = IncidentComponents::where('components_id', $component->id)->get()->count();
            if($count == 0){
                Components::where('id', $id)->delete();
                $check_count_components_list = Components::get()->count();
                return response()->json(['check_count_components_list' => $check_count_components_list, 'success' => 'Great! The component has been removed!']);
            } else {
                return response()->json(['warning' => 'Error! The component cannot be removed because it has incidents linked.'], 405);
            }
        } else {
            $notification = array(
                'message' => 'Ilegal operation. The administrator was notified.',
                'alert-type' => 'error'
            );
            return redirect()->route('authenticated.dashboard')->with($notification);
        }
    }

    public function components_index_update(Request $request)
    {
        if( $request->ajax() )
        {
            $user = \Auth::user();
            $request->merge(['user_id' => $user->id]);
            $rules = [
                'results' => 'required',
            ];
            $data = $request->only(['results']);
            $validator = Validator::make($data, $rules);
            if($validator->passes())

            {
                $results = $request->get('results');
                $results = json_decode($results,true);

                foreach ($results as $result){
                    $res = Components::where('id', $result['id'])->get()->first();
                    if(!($res)){
                        return response()->json(['warning' => 'Error!  The components list has been compromised.']);
                    }
                }

                foreach ($results as $result){
                    Components::where('id', $result['id'])->update(['position' => $result['position']]);
                }

                return response()->json(['success' => 'Great! The components list has been updated.']);

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
