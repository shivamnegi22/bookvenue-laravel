<?php

namespace App\Http\Controllers\Management;


use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\sports;
use App\Models\venues;
use App\Models\facility_venue;
use App\Models\facility_sports;
use App\Models\BookFacility;
use App\Models\facility_sports_court;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Service_type;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {

        return view('Management.dashboard');
    }

    public function createFacilityView()
    {
        $service_type = Service_type::get();
        return view('facility.createFacility',compact('service_type'));
    }

    public function createFacility(Request $request)
    {
       $facility = new facility;

       $facility->service_type_id = $request->service_type;
       $facility->official_name = $request->name;
       $facility->alias = $request->alias;
       $facility->amenities = $request->amenities;
       $slug = Str::slug($request->name);
       $randomString = Str::random(5);

       $facility->slug =  $randomString. '-' . $slug;
       $facility->address = $request->address;
       $facility->lat = $request->lat;
       $facility->lng = $request->lng;
    //    if ($request->hasFile('images')) {
    //     $images = [];
    
    //     foreach ($request->file('images') as $image) {
    //         $path = $image->store('public/facility');
    //         $images[] = json_encode(str_replace('public','storage',$path));
    //     }
    
    //     // Encode the entire array as JSON without escaping slashes
    //     $facility->images = json_encode($images, JSON_UNESCAPED_SLASHES);
    // }
    
       if ($request->hasFile('featured_image')) {

        $url = $request->featured_image->store('public/facility');
        $facility->featured_image = str_replace('public','storage',$url);
        }
      
       $facility->description = $request->description;
       $facility->created_by = Auth::user()->id;
       $facility->verified_by = Auth::user()->id;
       $facility->save();

        return redirect()->back();
    }

    public function CategoryView()
    {
        return view('serviceManagement.category');
    }

    public function createServicesCategoryView()
    {
        return view('facility.createServicesCategory');
    }

    public function createServicesCategory(Request $request)
    {

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

            // dd($request);
        $sport = new Service_type;

        $sport->name = $request->name;
        if ($request->hasFile('featured_image')) { 
        $url = $request->featured_image->store('public/category');
        $sport->featured_image =  str_replace('public','storage',$url);
        }
        if ($request->hasFile('icon')) {
        $url = $request->icon->store('public/category');
        $sport->icon = str_replace('public','storage',$url);
        }
        $sport->description = $request->description;
        
        $sport->created_by = Auth::user()->id;
        // $sport->verified_by = Auth::user()->id;
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

    public function serviceView(){
        return view('serviceManagement.service');
    }

    public function addServicesView(){
        return view('facility.addServices');
    }

    public function createServicesView()
    {
        $service_type = Service_type::get();
        return view('facility.createServices',compact('service_type'));
    }

    public function createServices(Request $request)
    {
            $facility_sports = new Service;

            $facility_sports->service_type_id = $request->service_type;
            $facility_sports->name = $request->name;
            if ($request->hasFile('featured_image')) {
                $url = $request->featured_image->store('public/facility');
                $facility_sports->featured_image = str_replace('public','storage',$url);
            }
            if ($request->hasFile('icon')) {
                $url = $request->icon->store('public/facility');
                $facility_sports->icon = str_replace('public','storage',$url);
            }
            $facility_sports->description = $request->description;
            
            $facility_sports->created_by = Auth::user()->id;
            // $facility_sports->verified_by = Auth::user()->id;
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
        $sport = sports::get();
        return view('facility.allSports',compact('sport'));
    }

    public function uploadsView()
    {
        return view('uploadImage');
    }

    public function uploads(Request $request)
    {
        
            $currentYear = date('Y');
            $currentMonth = date('m');
            $imageUrls = [];
    
            // Check if the request contains multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Store each image and get its URL
                    $url = $image->store("public/uploads/$currentYear/$currentMonth");
                    $imageUrls[] = asset(str_replace('public/', 'storage/', $url));
                }
            }
    
            return redirect()->back();

    }

    public function allFacility()
    {
        $facility = facility::where('status','1')->get();
        return view('facility.allFacility',compact('facility'));
    }

    public function updateFacilityView($id)
    {
        $facility = facility::where('id',$id)->first();
        return view('facility.updateFacility',compact('facility'));
    }

    public function updateFacility($id,Request $request)
    {
        $facility = facility::where('id',$id)->first();

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
         $facility->featured_image = str_replace('public','storage',$url);
         }
       
        $facility->description = $request->description;
         $facility->update();
 
         return redirect()->back();
    }

    public function deleteFacility($id)
    {
        $facility = facility::find($id);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        // Check if there are related records in the related tables

        $facilityVenuCount = facility_venue::where('facility_id', $id)->count();
        $facilitySportCount = facility_sports::where('facility_id', $id)->count();
        $facilitySportCourtCount = facility_sports_court::where('facility_id', $id)->count();

        if ($facilityVenuCount > 0 || $facilitySportCount > 0 || $facilitySportCourtCount > 0) {
            return redirect()->back()->with('error', 'Facility has related records and cannot be deleted');
        }

        $facility->delete();

        return redirect()->back();

    }

    public function updateSportsView($id)
    {
        $sport = sports::where('id',$id)->first();
        return view('facility.updateSport',compact('sport'));
    }

    public function updateSports($id, Request $request)
    {
       

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

        $sport = sports::where('id',$id)->first();

        $sport->name = $request->name;
        if ($request->hasFile('featured_image')) {
        $sport->featured_image = $request->featured_image;
        }
        if ($request->hasFile('icon')) {
        $sport->featured_image = $request->icon;
        }
        $sport->description = $request->description;
        $sport->update();

        return redirect()->back();
    }

    public function deleteSport($id)
    {
        $sport = sports::find($id);

        if (!$sport) {
            return redirect()->back()->with('error', 'Sports not found');
        }

        // Check if there are related records in the related tables

        $facilitySportCount = facility_sports::where('sports_id', $id)->count();
        $facilitySportCourtCount = facility_sports_court::where('sports_id', $id)->count();

        if ( $facilitySportCount > 0 || $facilitySportCourtCount > 0) {
            return redirect()->back()->with('error', 'Sport has related records and cannot be deleted');
        }

        $sport->delete();

        return redirect()->back();

    }

    public function allVenue()
    {
        $venue = venues::get();
        return view('facility.allVenue',compact('venue'));
    }

    public function updateVenueView($id)
    {
        $venue = venues::where('id',$id)->first();
        return view('facility.allVenue',compact('venue'));
    }

    public function updateVenue($id, Request $request)
    {

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

        $venue = venues::where('id',$id)->first();

        $venue->name = $request->name;
        if ($request->hasFile('featured_image')) {
        $venue->featured_image = $request->featured_image;
        }
        if ($request->hasFile('icon')) {
        $venue->featured_image = $request->icon;
        }
        $venue->description = $request->description;
        $venue->update();

        return redirect()->back();
        
    }

    public function deleteVenue($id)
    {
        $venue = venues::find($id);

        if (!$venue) {
            return redirect()->back()->with('error', 'Venue not found');
        }

        // Check if there are related records in the related tables

        $facilityVenuCount = facility_venue::where('venue_id', $id)->count();

        if ($facilityVenuCount > 0) {
            return redirect()->back()->with('error', 'Venue has related records and cannot be deleted');
        }

        $venue->delete();

        return redirect()->back();

    }

    public function bookFacilityView()
    {
        $facility = facility::get();
        $venue = venues::get();
        $sport = sports::get();
        return view('facility.bookFacility',compact('facility','venue','sport'));
    }

    public function bookFacility(Request $request)
    {
        $obj = new BookFacility;

        $obj->facility_id = $request->facility_id;
        $obj->user_id = Auth::user()->id;
        $obj->facility_type = $request->facility_type;
        $obj->sport_court_id = $request->sports_court_id;
        $obj->sport_id = $request->sports;
        $obj->venue_id = $request->venues;
        $obj->date = $request->date;
        $obj->start_time = $request->start_time;
        $obj->duration = $request->duration;

        $obj->save();

        return redirect()->back();
    }

    public function facilityImage($facility_id)
    {
        $image = facility::where('id', $facility_id)->value('featured_image');

        return $image;
        
    }

    public function sport_court($facility_id,$sport_id)
    {
        // return $sport_id;
        $courts = facility_sports_court::where('facility_id',$facility_id)->where('sports_id',$sport_id)->get();

        return $courts;
    }

    public function allBooking()
    {
        $booking = BookFacility::orderBy('created_at','desc')->get();
        return view('facility.allBooking',compact('booking'));
    }
}
