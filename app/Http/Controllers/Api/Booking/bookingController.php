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
use App\Models\Payment;
use App\Models\Profile;
use Exception;
use Sabre\VObject;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class bookingController extends Controller
{
    public function Booking(Request $request)
    {
        try{

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

            $token = PersonalAccessToken::findToken($request->bearerToken());
            $userId = $token->tokenable->id;

            
            $api = new Api('rzp_test_tf2mO3FgjeZLXI', 'HKZZPCqcj9BA1aE5xRlFPr4W');
            $order = $api->order->create(array(
                'receipt' => '12345',
                'amount' => $request->total_price * 100,
                'currency' => 'INR',
                'payment_capture' => 1
            ));

            $orderId = $order['id'];

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 

            $payment = new Payment();
            $payment->user_id = $userId;
            $payment->name = $request->name;
            $payment->amount = $request->total_price;
            $payment->orderId = $orderId;
            $payment->status = 'Pending';

            if($payment->save())
            {

            $booking = new Booking;

            $booking->user_id = $userId;
            $booking->facility_id = $request->facility_id;

            $booking->payment_id = $payment->id;
            $booking->court_id = $request->court_id;
            $booking->start_time = $request->start_time;
            $booking->end_time = $request->end_time;
            $booking->duration = $request->duration;
            $booking->total_price = $request->total_price;
            $booking->date = $request->date;
            $booking->booked_by = $userId;
            $booking->payment_type = '';
            $booking->status = 'Pending';



            if($booking->save())
            {
                $profile = Profile::where('user_id',$userId)->first();

                $profile->name = $request->name;
                $profile->email = $request->email;
                $profile->contact = $request->contact;
                $profile->address = $request->address;

                $profile->update();
            }

                return response([
                    'order' => $order->toArray(),
                    'message' => "Order Created Successfully.",
                ],200); 
            }

        } catch(\Exception $e){
            return response([
                    'error' => $e,
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

    public function myBooking(Request $request)
    {
        // try{

            $token = PersonalAccessToken::findToken($request->bearerToken());
            $userId = $token->tokenable->id;

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 


            $bookings = Booking::where('user_id',$userId)->get();


            $data = [];

            if($bookings)
            {

            foreach($bookings as $booking)
            {
                $obj = new \stdClass();

                $obj->name = Profile::where('user_id',$booking->user_id)->value('name');
                $obj->facility = facility::where('id',$booking->facility_id)->value('official_name');
                $obj->court = Court::where('id',$booking->court_id)->value('court_name');
                $obj->date = $booking->date;
                $obj->start_time = $booking->start_time;
                $obj->end_time = $booking->end_time;
                $obj->price = $booking->total_price;
                $obj->status = $booking->status;


                $data[] = $obj;

            }

            return response([
                'bookings' => $data,
            ],200); 
       

        }else{

            return response([
                'message' => 'No data found.',
            ],200); 
       
        }

       
        // } catch(Exception $e){

        //     return response([
        //         'errors' => $e->message(),
        //         'message' => "Internal Server Error.",
        //     ],500);
        // }
    }

    public function paymentSuccess(Request $request)
    {
        // try{

            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); 
            }

            
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $userId = $token->tokenable->id;

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 


            $payment = Payment::where('user_id',$userId)->where('orderId',$request->order_id)->first();
            $payment_id = Payment::where('user_id',$userId)->where('orderId',$request->order_id)->value('id');

            $email = Profile::where('user_id',$userId)->value('email');
            $name = Profile::where('user_id',$userId)->value('name');
            $date = Booking::where('payment_id',$payment_id)->value('date');
            $start_time = Booking::where('payment_id',$payment_id)->value('start_time');
            $end_time = Booking::where('payment_id',$payment_id)->value('end_time');
            $court_id = Booking::where('payment_id',$payment_id)->value('court_id');
            $court_name = Court::where('id',$court_id)->value('court_name');
            $facility_id = Booking::where('payment_id',$payment_id)->value('facility_id');
            $amount = Booking::where('payment_id',$payment_id)->value('total_price');
            $facility_name = facility::where('id',$facility_id)->value('official_name');

          
            $payment->status = 'Success';
            if($payment->update())
            {
                $booking = Booking::where('payment_id',$payment_id)->first();

                $booking->status = "Success";

                if($booking->update())
                {
                    if($email)
                    {

                    $mailData = [

                        'recipient'=>$email,
    
                        'fromMail'=>'info@bookvenue.app',
    
                        'fromName'=>'Bookvenue',
    
                        'subject'=>'Booking Update',
    
                        'bookingDate'=>$date,
    
                        'facility'=>$facility_name,
    
                        'start_time'=> $start_time,
    
                        'end_time'=> $end_time,
    
                        'name'=>$name,
    
                        'court_name' => $court_name,

                        'amount' => $amount
    
                     
    
                        ];
                        
    
                    Mail::send('mail_templates/user_booking_template',$mailData, function($message) use ($mailData){
    
                        $message->to($mailData['recipient'])
    
                        ->from($mailData['fromMail'],$mailData['fromName'])
    
                        ->subject($mailData['subject']);
    
                      });

                    }
    
                }

            }

            
            return response([
                'message' => "Booking have been Successfull.",
            ],200); 

        // }catch(Exception $e){

        //     return response([
        //         'errors' => $e->message(),
        //         'message' => "Internal Server Error.",
        //     ],500);
        // }
    }


    public function paymentFailure(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); 
            }

            
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $userId = $token->tokenable->id;

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 

            $payment = Payment::where('user_id',$userId)->where('orderId',$request->order_id)->first();
            $payment_id = Payment::where('user_id',$userId)->where('orderId',$request->order_id)->value('id');

            // $email = Profile::where('user_id',$userId)->value('email');
            // $name = Profile::where('user_id',$userId)->value('name');
            // $date = Booking::where('payment_id',$payment_id)->value('date');
            // $start_time = Booking::where('payment_id',$payment_id)->value('start_time');
            // $end_time = Booking::where('payment_id',$payment_id)->value('end_time');
            // $court_id = Booking::where('payment_id',$payment_id)->value('court_id');
            // $court_name = Court::where('id',$court_id)->value('court_name');
            // $facility_id = Booking::where('payment_id',$payment_id)->value('facility_id');
            // $facility_name = facility::where('id',$facility_id)->value('official_name');


            $payment->status = "Failure";
            if($payment->update())
            {
                $booking = Booking::where('payment_id',$payment_id)->first();

                $booking->status = "Failure";

                if($booking->update())
                {
                    // if($email)
                    // {

                    // $mailData = [

                    //     'recipient'=>$email,
    
                    //     'fromMail'=>'info@bookvenue.app',
    
                    //     'fromName'=>'Bookvenue',
    
                    //     'subject'=>'Booking Update',
    
                    //     'bookingDate'=>$date,
    
                    //     'facility'=>$facility_name,
    
                    //     'start_time'=> $start_time,
    
                    //     'end_time'=> $end_time,
    
                    //     'name'=>$name,
    
                    //     'court_name' => $court_name,
    
                     
    
                    //     ];
                        
    
                    // Mail::send('mail_templates/user_booking_template',$mailData, function($message) use ($mailData){
    
                    //     $message->to($mailData['recipient'])
    
                    //     ->from($mailData['fromMail'],$mailData['fromName'])
    
                    //     ->subject($mailData['subject']);
    
                    //   });

                    // }
    
                }

            }

            
            return response([
                'message' => "Booking have been Failed.",
            ],200); 

        }catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }
}
