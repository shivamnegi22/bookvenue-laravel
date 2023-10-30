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

        return view('Management.dashboard');
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
        return view('serviceManagement.service');
    }

    public function addServicesView(){

        $service_category = Service_category::get();
        $service = Service::get();
        $facility = facility::get();
        return view('facility.addServices',compact('service_category','service','facility'));
    }

    public function addServices(Request $request)
    {
        // dd($request);
        $courtsDataJSON = $request->input('courts_data');
        $courtsData = json_decode($courtsDataJSON, true);
    
        // return $courtData;

        $facility_service = new Facility_service;

        $facility_service->facility_id = $request->facility_id;
        $facility_service->service_id = $request->services_id;
        if ($request->hasFile('images')) {
            $images = [];
        
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/facility');
                $cleanedString = str_replace(['\\', '"'], '', $path);
                $images[] = str_replace('public','storage',$cleanedString);
            }
        
            // Encode the entire array as JSON without escaping slashes
            $facility_service->images = json_encode($images);
        }

        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $facility_service->featured_image = str_replace('public','storage',$url);
         }

                $dates = $request->holiday;
                $individualDates = [];

                foreach ($dates as $date) {
                    $individualDates[] = $date;
                }

        $facility_service->upcoming_holiday = json_encode($individualDates);
        $facility_service->description = $request->description;
        $facility_service->created_by = Auth::user()->id;

        if($facility_service->save())
        {

            foreach ($courtsData as $data) {

                $court = new Court;
            
                // Set the attributes based on the data from the array
                $court->facility_service_id = $facility_service->id;
                $court->court_name = $data['name'];
                $court->start_time = $data['startTime'];
                $court->end_time = $data['endTime'];
                $court->slot_price = $data['prize']; // You might want to adjust this based on your data.
                $court->duration = $data['duration'];
            
                // The 'breaks' attribute might need some custom handling
                $breaks = [];
                foreach ($data['breaks'] as $break) {
                    $breaks[] = [
                        'start' => $break['start_Time'],
                        'end' => $break['end_Time'],
                    ];
                }
                $court->breaks = json_encode($breaks);
                $court->created_by = Auth::user()->id;
            
                // Save the court
                $court->save();
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

    public function getService($service_category_id)
    {

        $services = Service::where('service_category_id',$service_category_id)->select('id','name')->get();

        return $services;
    }
}
