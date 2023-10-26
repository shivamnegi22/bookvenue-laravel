<?php

namespace App\Http\Controllers\Api\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Facility_service;
use App\Models\Service_category;
use App\Models\Court;
use Exception;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class bookingController extends Controller
{
    public function Booking(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'facility_id' => 'required',
                'court_id' => 'required',
                'slot_time' => 'required',
                'date' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $userId = $token->tokenable->id;

            $booking = new Booking;

            $booking->user_id = $userId;
            $booking->facility_id = $request->facility_id;
            $booking->court_id = $request->court_id;
            $booking->slot_time = $request->slot_time;
            $booking->duration = $request->duration;
            $booking->total_price = $request->total_price;
            $booking->date = $request->date;
            $booking->booked_by = $userId;
            $booking->payment_type = $request->payment_type;
            $booking->status = 'Pending';

            if($booking->save())
            {
                return response([
                    'message' => "Slot is booked successfully.",
                ],200); 
            }

        } catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }
}
