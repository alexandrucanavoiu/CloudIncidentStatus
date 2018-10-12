<?php

namespace App\Http\Controllers;

use App\Models\Components;
use App\Models\ComponentsGroup;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
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

        $count_incidents = Incident::get()->count();
        $count_components = Components::get()->count();
        $next_scheduled_maintenance = Schedule::where('scheduled_end', '>=', \Carbon\Carbon::now())->first();


        $component_groups = ComponentsGroup::with('components')->get();
        $incidents = Incident::with('component_name')->with('incident_status')->OrderBy('updated_at', 'DESC')->limit(5)->get();

        $currently_year = Carbon::now();
        $currently_year = $currently_year->year;

        $one_year_ago = Carbon::now();
        $one_year_ago = $one_year_ago->subYear()->year;

        $two_years_ago = Carbon::now();
        $two_years_ago = $two_years_ago->subYears(2)->year;

        $three_years_ago = Carbon::now();
        $three_years_ago = $three_years_ago->subYears(3)->year;

        $four_years_ago = Carbon::now();
        $four_years_ago = $four_years_ago->subYears(4)->year;

        $incidents_this_year = Incident::whereYear('created_at', $currently_year)->get()->count();
        $incidents_one_year_ago = Incident::whereYear('created_at', $one_year_ago)->get()->count();
        $incidents_two_year_ago  = Incident::whereYear('created_at', $two_years_ago)->get()->count();
        $incidents_three_years_ago = Incident::whereYear('created_at', $three_years_ago)->get()->count();
        $incidents_four_years_ago = Incident::whereYear('created_at', $four_years_ago)->get()->count();

        return view('authentication.dashboard', compact('user', 'count_incidents', 'count_components', 'next_scheduled_maintenance', 'component_groups', 'incidents', 'incidents_this_year', 'incidents_one_year_ago', 'incidents_two_year_ago', 'incidents_three_years_ago', 'incidents_four_years_ago', 'currently_year', 'one_year_ago', 'two_years_ago', 'three_years_ago', 'four_years_ago'));
    }
}
