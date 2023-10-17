<?php

namespace App\Http\Controllers\web\Management;


use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
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

        $this->validate($request,[
        
            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

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
        return view('facility.addServices');
    }

    public function createServicesView()
    {
        $service_category = Service_category::get();
        return view('facility.createServices',compact('service_category'));
    }

    public function createServices(Request $request)
    {
            $facility_sports = new Service;

            $facility_sports->service_category_id = $request->service_category_id;
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



}
