<?php

namespace App\Http\Controllers\web\Facility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\facility;
use App\Models\Facility_service;
use App\Models\Service;
use App\Models\Amenities;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Service_category;

class facilityController extends Controller
{
    public function createFacilityView()
    {
        $service_category = Service_category::get();
        $amenities = Amenities::get();
        return view('facility.createFacility',compact('service_category','amenities'));
    }

    public function createFacility(Request $request)
    {
       $facility = new facility;

       $facility->service_category_id = $request->service_category_id;
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


    public function allFacility()
    {
        $facility = facility::where('status','1')->get();
        return view('facility.allFacility',compact('facility'));
    }

    public function updateFacilityView($id)
    {
        $service_category = Service_category::get();
        $amenities = Amenities::get();
        $facility = facility::where('id',$id)->first();
        return view('facility.updateFacility',compact('service_category','amenities','facility'));
    }

    public function updateFacility($id,Request $request)
    {
        $facility = facility::where('id',$id)->first();

        $facility->service_category_id = $request->Service_category_id;
        $facility->official_name = $request->name;
        $facility->alias = $request->alias;
        $facility->amenities = $request->amenities;
        $slug = Str::slug($request->name);
        $randomString = Str::random(5);
        $facility->slug = $slug . '-' . $randomString;
        $facility->address = $request->address;
        $facility->lat = $request->lat;
        $facility->lng = $request->lng;
        if ($request->hasFile('featured_image')) {
        $url = $request->featured_image->store('public/facility');
        $facility->featured_image = str_replace('public','storage',$url);
        }
        $facility->description = $request->description;
        $facility->created_by = Auth::user()->id;
        $facility->verified_by = Auth::user()->id;
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

        $facility_service = Facility_service::where('facility_id', $id)->count();
        $BookingCount = Booking::where('facility_id', $id)->count();
        $facilitySportCourtCount = facility_sports_court::where('facility_id', $id)->count();

        if ($facility_service > 0 || $BookingCount > 0 ) {
            return redirect()->back()->with('error', 'Facility has related records and cannot be deleted');
        }

        $facility->delete();

        return redirect()->back()->with('delete', 'Facility have been deleted successfully.');

    }
}
