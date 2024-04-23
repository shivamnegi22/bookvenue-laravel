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
use App\Models\Profile;
use Exception;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;

class bookingController extends Controller
{
    public function Booking(Request $request)
    {
        // try{

            $validator = Validator::make($request->all(), [
                'facility_id' => 'required',
                'court_id' => 'required',
                'date' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); 
            }

            $bearerToken = $request->header('Authorization');

            if (!$bearerToken || strpos($bearerToken, 'Bearer ') !== 0) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        
            $token = substr($bearerToken, 7); 
        
            $tokenParts = explode('|', $token);
        
            if (count($tokenParts) !== 2) {
                return response()->json(['error' => 'Invalid token format'], 400);
            }
        
            $userId = $tokenParts[0]; 
       
            $booking = new Booking;

            $booking->user_id = $userId;
            $booking->facility_id = $request->facility_id;

            $booking->court_id = $request->court_id;
            $booking->start_time = $request->start_time;
            $booking->end_time = $request->end_time;
            $booking->duration = $request->duration;
            $booking->total_price = $request->total_price;
            $booking->date = $request->date;
            $booking->booked_by = $userId;
            $booking->payment_type = '';
            $booking->status = 'Success';

            $email = Profile::where('user_id',$userId)->value('email');
            $name = Profile::where('user_id',$userId)->value('name');
            $court_name = Court::where('id',$request->court_id)->value('court_name');
            $facility_name = facility::where('id',$booking->facility_id)->value('official_name');

            if($booking->save())
            {
                if($email)

                {

                $mailData = [

                    'recipient'=>$email,

                    'fromMail'=>'info@bookvenue.app',

                    'fromName'=>'Bookvenue',

                    'subject'=>'Booking Update',

                    'bookingDate'=>$request->date,

                    'facility'=>$facility_name,

                    'start_time'=> $request->start_time,

                    'end_time'=> $request->end_time,

                    'name'=>$name,

                    'court_name' => $court_name,

                 

                    ];
                    

                Mail::send('mail_templates/user_booking_template',$mailData, function($message) use ($mailData){

                    $message->to($mailData['recipient'])

                    ->from($mailData['fromMail'],$mailData['fromName'])

                    ->subject($mailData['subject']);

                  });

                }

                return response([
                    'message' => "Slot is booked successfully.",
                ],200); 
            }

        // } catch(\Exception $e){
        //     return response([
        //             'error' => $e,
        //             'message' => "something went wrong please try again.",
        //         ],500); 
        // }
    }
}
