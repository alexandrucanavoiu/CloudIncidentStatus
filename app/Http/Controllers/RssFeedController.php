<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Carbon\Carbon;
use App\Models\Incident;
use App\Models\Components;
use App\Models\Settings;
use Illuminate\Support\Facades\URL;


class RssFeedController extends Controller
{

    public function index()
    {
        $feed = \App::make("feed");
        $feed->setCache(5, 'laravelFeedKey');

        if (!$feed->isCached())
        {
            // creating rss feed with our most recent 20 posts
            $posts = Incident::with('component_name')->with('incident_status')->with('component_status')->with('update_incident_sort_by_id')->orderBy('created_at', 'desc')->take(20)->get();

            if($posts->count() > 0) {

                $settings = Settings::where('id', 1)->get()->first();

                // set your feed's title, description, link, pubdate and language
                $feed->title = $settings->title_app . "- Incident Status";
                $feed->logo = url("/images/" . $settings->settings_logo);
                $feed->link = url('history.atom');
                $feed->description = " CloudIncidentStatus";
                $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
                $feed->pubdate = $posts[0]->updated_at;
                $feed->lang = 'en';


                foreach ($posts as $post)
                {
                    $date = Carbon::parse($post->updated_at)->format('Y-m-d\TH:i:s.uP');

                    // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                    $feed->add($post->incident_title, $settings->title_app ,URL::to('incidents/' . $post->code), $date, $post->update_incident_sort_by_id[0]->incidents_description, $post->update_incident_sort_by_id[0]->incidents_description);
                }
            } else {

                $settings = Settings::where('id', 1)->get()->first();

                // set your feed's title, description, link, pubdate and language
                $feed->title = $settings->title_app . "- Incident Status";
                $feed->logo = url("/images/" . $settings->settings_logo);
                $feed->link = url('history.atom');
                $feed->description = " CloudIncidentStatus";
                $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
                $feed->pubdate = "";
                $feed->lang = 'en';
            }
        }

        $feed->ctype = "text/xml";

        return $feed->render('atom');



    }

}
