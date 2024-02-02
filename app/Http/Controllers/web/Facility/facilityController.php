<?php

namespace App\Http\Controllers\web\Facility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\facility;
use App\Models\Facility_service;
use App\Models\Service;
use App\Models\Amenities;
use App\Models\Booking;
use App\Models\Court;
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

       $facility->service_category_id = json_encode($request->service_category_id);
       
       $facility->official_name = $request->name;
       $facility->alias = $request->alias;
       $facility->amenities = json_encode($request->amenities);
       $slug = Str::slug($request->name);
       $randomString = Str::random(5);
       $facility->slug =  $randomString. '-' . $slug;
       $facility->address = $request->address;
       $facility->status = 'Active';
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
       $facility->verified = '1';
       $facility->created_by = Auth::user()->id;
       $facility->verified_by = Auth::user()->id;
       $facility->save();

        return redirect()->back();
    }


    public function allFacility()
    {
        $facility = facility::where('status','Active')->get();
        return view('facility.allFacility',compact('facility'));
    }

    public function pendingFacility()
    {
        $facility = facility::where('status','Pending')->get();
        return view('facility.pendingFacility',compact('facility'));
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

        $facility->service_category_id = json_encode($request->service_category_id);
        $facility->official_name = $request->name;
        $facility->alias = $request->alias;
        $facility->amenities = json_encode($request->amenities);
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

    public function aprovedFacility($id)
    {
        $facility = facility::where('id',$id)->first();

        $facility->status = 'active';
        $facility->verified_by = Auth::user()->id;

        $facility->update();

        return redirect('app/pending/facility');
    }

    public function unaprovedFacility($id)
    {
        $facility = facility::where('id',$id)->first();

        $facility->status = 'Pending';
        $facility->verified_by = Auth::user()->id;

        $facility->update();

        return redirect('app/aprooved/facility');
    }

    public function deleteFacility($id)
    {
        $facility = facility::find($id);

        if (!$facility) {
            return redirect()->back()->with('error', 'Facility not found');
        }

        $facility->delete();

        return redirect()->back()->with('delete', 'Facility have been deleted successfully.');

    }

    public function allCourts()
    {
        $courts = Court::where('status','1')->get();

        $courtData = [];

        if($courts)
        {
            
            foreach($courts as $value)
            {
                
                $obj = new \stdClass();
                $facility_id =  Facility_service::where('id',$value->facility_service_id)->value('facility_id');

                $obj->facility_name = facility::where('id',$facility_id)->value('official_name');

                $service_id = Facility_service::where('id',$value->facility_service_id)->value('service_id');
                $obj->service_name = Service::where('id',$service_id)->value('name');
                $obj->court_id = $value->id;
                $obj->court = $value->court_name;
                $obj->start_time = $value->start_time;
                $obj->end_time = $value->end_time;
                $obj->duration = $value->duration;
                $obj->price = $value->slot_price;

                $courtData[] = $obj;
            
            }

        }
        return view('facility.allCourts',compact('courts','courtData'));
    }

    public function desableCourts($court_id)
    {
        $court = Court::where('id',$court_id)->first();

        $court->status = '0';

        $court->update();

        return back()->with('disable','The court have been dactivated.');
    }

    public function providerData()
    {
        $facility = facility::where('created_by','6')->get();

        $provider = [];

        foreach($facility as  $value)
        {
            
            $obj = new \stdClass();

            $obj->facility_name = $value->offcial_name;
            $obj->alias = $value->alias;
            $obj->address = $value->address;
            $obj->featured_image = $value->featured_image;
            $obj->status = $value->status;
            $obj->service = array();
            
            $service_id= Facility_service::where('facility_id',$value->id)->value('service_id');
            $facility_service_id= Facility_service::where('facility_id',$value->id)->value('id');
            $service = Service::where('id',$service_id)->get();

            foreach($service as $serviceData)
            {
                  $service_data = new \stdClass();
                  $service_data->service_name = $serviceData->name;
                  $service_data->service_category = Service_category::where('id',$serviceData->service_category_id)->value('name');
                  $service_data->icon = $serviceData->icon;
                  $service_data->featured_image = $serviceData->featured_image;
                  $service_data->description = $serviceData->description;
                  $service_data->courtData = array();

                  $court = Court::where('facility_service_id',$facility_service_id)->get();

                  foreach($court as $courtData)
                  {
                    $court_data = new \stdClass();

                    $court_data->court_name = $courtData->court_name;
                    $court_data->start_time = $courtData->start_time;
                    $court_data->end_time = $courtData->end_time;
                    $court_data->slot_price = $courtData->slot_price;
                    $court_data->duration = $courtData->duration;
                    $court_data->breaks = $courtData->breaks;
                    $court_data->description = $courtData->description;

                    array_push($service_data->courtData,   $court_data);
                  }

                  array_push($obj->service,$service_data);

            }

            $provider[] = $obj;
        }

        // dd($provider);
        
    }
    
}
