<?php

namespace App\Http\Controllers\Api\Facility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\facility;

class facilityController extends Controller
{
    public function createFacility(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'facility_type' => 'required',
            ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); // 422 is the HTTP status code for unprocessable entity
    }
        $facility = new facility;

        $facility->facility_type = $request->facility_type;
        $facility->name = $request->name;
        $facility->alias = $request->alias;
        $facility->address = $request->address;
        $facility->location = $request->location;
        if ($request->hasFile('images')) {
         $images = [];
     
         foreach ($request->file('images') as $image) {
             $path = $image->store('public/facility');
             $images[] = $path;
         }
     
         // Encode the entire array as JSON without escaping slashes
         $facility->images = json_encode($images, JSON_UNESCAPED_SLASHES);
     }
     
        if ($request->hasFile('featured_image')) {
         $facility->featured_image = $request->featured_image->store('public/facility');
         }
       
        $facility->time = json_encode($request->time);
        $facility->description = $request->description;
         if($facility->save())
         {
            $response = [
                'message' => 'Facility have been created successfully.',
            ];
        
            return response([
                'data' => $response,
            ],200);
         }

         return response([
            'error' => "Unable to create facility.",
        ],400);
         
    }
    catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }
}
}
