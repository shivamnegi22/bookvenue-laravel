<?php

namespace App\Http\Controllers\Management;


use App\Http\Controllers\Controller;
use App\Models\facility;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        return view('Management.dashboard');
    }

    public function createFacilityView()
    {
        return view('createFacility');
    }

    public function createFacility(Request $request)
    {
       $facility = new facility;

       $facility->facility_type = $request->facility_type;
       $facility->official_name = $request->name;
       $facility->alias = $request->alias;
       $facility->address = $request->address;
       $facility->location = $request->location;
       if ($request->hasFile('images')) {
        $images = [];
    
        foreach ($request->file('images') as $image) {
            $path = $image->store('public/facility');
            $images[] = str_replace('public','storage',$path);
        }
    
        // Encode the entire array as JSON without escaping slashes
        $facility->images = json_encode($images, JSON_UNESCAPED_SLASHES);
    }
    
       if ($request->hasFile('featured_image')) {

        $url = $request->featured_image->store('public/facility');
        $facility->featured_image = str_replace('public','storage',$url);
        }
      
       $facility->description = $request->description;
        $facility->save();

        return redirect()->back();
    }
}
