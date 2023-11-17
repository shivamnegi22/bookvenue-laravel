<?php

namespace App\Http\Controllers\web\Management;


use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
use App\Models\Facility_service;
use App\Models\Court;
use App\Models\Amenities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Service_category;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {

        $approovedFacility = facility::where('verified','1')->count();
        $pendingFacility = facility::where('status','Pending')->count();
        $activeFacility = facility::where('status','Active')->count();
        $deactiveFacility = facility::where('status','Deactive')->count();
        $facility = facility::orderBy('created_at','desc')->take(5)->get();
        return view('Management.dashboard',compact('approovedFacility','pendingFacility','activeFacility','deactiveFacility','facility'));
    }


    public function CategoryView()
    {
        $category = Service_category::get();
        return view('serviceManagement.category',compact('category'));
    }

    public function createServicesCategoryView()
    {
        return view('facility.createServicesCategory');
    }

    public function createServicesCategory(Request $request)
    {

        // $this->validate($request,[
        
        //     'featured_image'      =>  'mimes:png,svg|max:500',
        //     'icon'                =>  'mimes:png,svg|max:200',

        //     ]);

            // dd($request);
        $service_cat = new Service_category;

        $service_cat->name = $request->name;
        if ($request->hasFile('featured_image')) { 
        $url = $request->featured_image->store('public/category');
        $service_cat->featured_image =  str_replace('public','storage',$url);
        }
        if ($request->hasFile('icon')) {
        $url = $request->icon->store('public/category');
        $service_cat->icon = str_replace('public','storage',$url);
        }
        $service_cat->description = $request->description;
        
        $service_cat->created_by = Auth::user()->id;
        // $service_cat->verified_by = Auth::user()->id;
        $service_cat->save();

        return redirect()->back();
    }


    public function serviceView(){

        $service = Service::get();
        return view('serviceManagement.service',compact('service'));
    }

    public function addServicesView(){

        $service_category = Service_category::get();
        $service = Service::get();
        $facility = facility::get();
        return view('facility.addServices',compact('service_category','service','facility'));
    }

    public function addServices(Request $request)
    {
        $facility_service = new Facility_service;

        $facility_service->facility_id = $request->facility_id;
        $facility_service->service_id = $request->service_id;
        if ($request->hasFile('images')) {
            $images = [];
        
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/facility');
                $cleanedString = str_replace(['\\', '"'], '', $path);
                $images[] = str_replace('public','storage',$cleanedString);
            }
        
            $facility_service->images = json_encode($images);
        }

        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $facility_service->featured_image = str_replace('public','storage',$url);
         }

        $facility_service->upcoming_holiday = $request->holiday;
        $facility_service->description = $request->description;
        $facility_service->created_by = Auth::user()->id;

        if($facility_service->save())
        {

            if($request->courtName && sizeof($request->courtName ) > 0){
                foreach($request->courtName as $key=>$courtValue){
                    $court = new Court;
                    $court->facility_service_id = $facility_service->id;
                    $court->court_name = $courtValue;
                    $court->start_time = $request->startTime[$key];
                    $court->end_time = $request->endTime[$key];
                    $court->description = $request->court_description[$key];
                    $court->slot_price = $request->price[$key];
                    $court->duration = $request->duration[$key];
                    $courtBreaks = array();
                    if($request->break_start[$key] && sizeof($request->break_start[$key]) > 0){
                        foreach($request->break_start[$key] as $breakKey=>$break){
                            $breaks = new \stdClass();
                            $breaks->start_time = $break;
                            $breaks->end_time = $request->break_end[$key][$breakKey];
                            array_push($courtBreaks,$breaks );
                        }
                    }
                    $court->breaks = json_encode($courtBreaks);
                    $court->created_by = Auth::user()->id;
                    $court->save();
                }
            }

            return redirect()->back();
            
        }
    }

    public function createServicesView()
    {
        $service_category = Service_category::get();
        return view('facility.createServices',compact('service_category'));
    }

    public function createServices(Request $request)
    {
            $service = new Service;

            $service->service_category_id = $request->service_category_id;
            $service->name = $request->name;
            if ($request->hasFile('featured_image')) {
                $url = $request->featured_image->store('public/facility');
                $service->featured_image = str_replace('public','storage',$url);
            }
            if ($request->hasFile('icon')) {
                $url = $request->icon->store('public/facility');
                $service->icon = str_replace('public','storage',$url);
            }
            $service->description = $request->description;
            
            $service->created_by = Auth::user()->id;
            // $service->verified_by = Auth::user()->id;
            $service->save();

            return redirect()->back();
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


    public function facilityImage($facility_id)
    {
        $image = facility::where('id', $facility_id)->value('featured_image');

        return $image;   
    }

    public function createAmenitiesView()
    {
        return view('configuration.amenities');
    }

    public function createAmenities(Request $request)
    {
      $amenity = new Amenities;

      $amenity->name = $request->name;
      
      if ($request->hasFile('icon')) {
        $url = $request->icon->store('public/facility');
        $amenity->icon = str_replace('public','storage',$url);
    }
     
      $amenity->description = $request->description;
      $amenity->created_by = Auth::user()->id;

      $amenity->save();

      return redirect()->back();
    }


    public function getServiceCategory($facility_id)
    {
        $facility = facility::where('id',$facility_id)->get();

        if(!empty($facility))
        {
            foreach($facility as $item)
            {
                $service_category = Service_category::where('id',$item->service_category_id)->pluck('id','name');
            }

            return $service_category;
        }
    }

    public function getService($facility_id)
    {
        $services_category_id = facility::where('id',$facility_id)->select('id','name')->value('service_category_id');

        $services = Service::where('service_category_id',$services_category_id)->select('id','name')->get();

        return $services;
    }

    public function deleteServiceCategory($id)
    {
        $category = Service_category::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $category->delete();

        return redirect()->back()->with('delete', 'Service category have been deleted successfully.');
    }

    public function updateServiceCategoryView($id)
    {
        $category = Service_category::where('id',$id)->first();
        return view('serviceManagement.updateCategory',compact('category'));
    }

    public function updateServiceCategory($id, Request $request)
    {
        $service_cat = Service_category::where('id',$id)->first();

        $service_cat->name = $request->name;
        if ($request->hasFile('featured_image')) { 
        $url = $request->featured_image->store('public/category');
        $service_cat->featured_image =  str_replace('public','storage',$url);
        }
        if ($request->hasFile('icon')) {
        $url = $request->icon->store('public/category');
        $service_cat->icon = str_replace('public','storage',$url);
        }
        $service_cat->description = $request->description;
        
        $service_cat->created_by = Auth::user()->id;
        // $service_cat->verified_by = Auth::user()->id;
        $service_cat->update();

        return redirect()->back()->with('update','Service category have been updated successfully');
    }

    public function deleteServices($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found');
        }

        // Check if there are related records in the related tables

        $service->delete();

        return redirect()->back()->with('delete', 'Service have been deleted successfully.');
    }

    public function updateServiceView($id)
    {
        $service_category = Service_category::get();
        $service = Service::where('id',$id)->first();
        return view('serviceManagement.updateService',compact('service_category','service'));
    }

    public function updateService($id,Request $request)
    {
        $service = Service::where('id',$id)->first();

        $service->service_category_id = $request->service_category_id;
        $service->name = $request->name;
        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $service->featured_image = str_replace('public','storage',$url);
        }
        if ($request->hasFile('icon')) {
            $url = $request->icon->store('public/facility');
            $service->icon = str_replace('public','storage',$url);
        }
        $service->description = $request->description;
        
        $service->created_by = Auth::user()->id;
        // $service->verified_by = Auth::user()->id;
        $service->update();

        return redirect()->back()->with('update','Service updated successfully.');
    }

    public function deleteService($id)
    {
        
    }
}
