<?php

namespace App\Http\Controllers\Management;


use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\sports;
use App\Models\venues;
use App\Models\facility_venue;
use App\Models\facility_sports;
use App\Models\facility_sports_court;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        return view('Management.dashboard');
    }

    public function createFacilityView()
    {
        return view('facility.createFacility');
    }

    public function createFacility(Request $request)
    {
       $facility = new facility;

       $facility->facility_type = $request->facility_type;
       $facility->official_name = $request->name;
       $facility->alias = $request->alias;
       $slug = Str::slug($request->name);
       $randomString = Str::random(5);

       $facility->slug = $slug . '-' . $randomString;
       $facility->address = $request->address;
       $facility->lat = $request->lat;
       $facility->long = $request->long;
       if ($request->hasFile('images')) {
        $images = [];
    
        foreach ($request->file('images') as $image) {
            $path = $image->store('public/facility');
            $images[] = json_encode(str_replace('public','storage',$path));
        }
    
        // Encode the entire array as JSON without escaping slashes
        $facility->images = json_encode($images, JSON_UNESCAPED_SLASHES);
    }
    
       if ($request->hasFile('featured_image')) {

        $url = $request->featured_image->store('public/facility');
        $facility->featured_image = json_encode(str_replace('public','storage',$url));
        }
      
       $facility->description = $request->description;
        $facility->save();

        return redirect()->back();
    }

    public function viewSports()
    {
        return view('facility.createSports');
    }

    public function Sports(Request $request)
    {

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

        $sport = new sports;

        $sport->name = $request->name;
        if ($request->hasFile('featured_image')) {
        $sport->featured_image = $request->featured_image;
        }
        if ($request->hasFile('icon')) {
        $sport->featured_image = $request->icon;
        }
        $sport->description = $request->description;
        $sport->save();

        return redirect()->back();
    }

    public function viewVenue()
    {
        return view('facility.createVenues');
    }

    public function Venues(Request $request)
    {

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

        $venue = new venues;

        $venue->name = $request->name;
        if ($request->hasFile('featured_image')) {
        $venue->featured_image = $request->featured_image;
        }
        if ($request->hasFile('icon')) {
        $venue->featured_image = $request->icon;
        }
        $venue->description = $request->description;
        $venue->save();

        return redirect()->back();
    }

    public function facilitySportsView()
    {
        $facility = facility::get();
        $sports = sports::get();
        return view('facility.facilitySport',compact('facility','sports'));
    }

    public function facilitySports(Request $request)
    {
            $facility_sports = new facility_sports;

            $facility_sports->facility_id = $request->facility_id;
            $facility_sports->sports_id = $request->sports_id;
            $facility_sports->amenities = $request->amenities;
            $facility_sports->start_time = $request->start_time;
            $facility_sports->close_time = $request->close_time;
            $facility_sports->slot_time = $request->slot_time;
            $facility_sports->holiday = json_encode($request->holiday);
            $facility_sports->description = $request->description;

            $facility_sports->save();

            return redirect()->back();
    }

    public function facilityVenueView()
    {
        $facility = facility::get();
        $venues = venues::get();
        return view('facility.facilityVenue',compact('facility','venues'));
    }

    public function facilityVenue(Request $request)
    {
        $facilty_venue = new facility_venue;

        $facilty_venue->facility_id = $request->facility_id;
        $facilty_venue->venue_id = $request->venue_id;
        $facilty_venue->amenities = $request->amenities;
        $facilty_venue->start_time = $request->start_time;
        $facilty_venue->close_time = $request->close_time;
        $facilty_venue->slot_time = $request->slot_time;
        $facilty_venue->slot_price = $request->slot_price;
        $facilty_venue->court_count = $request->court_count;
        $facilty_venue->breaktime_start = $request->breaktime_start;
        $facilty_venue->breaktime_end = $request->breaktime_end;
        $facilty_venue->holiday = json_encode($request->holiday);
        $facilty_venue->description = $request->description;

        $facilty_venue->save();

        return redirect()->back();

    }

    public function allSports()
    {
        return view('facility.allSports');
    }


}
