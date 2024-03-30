<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function payment(Request $request){
        $user = auth()->user();

        $data  = [
            "user_id"=> $user->id,
            "subscription_type"=> $request->subscription_type,
            "subscription_id"=> $request->subscription_id,
            "plan_id"=> $request->plan_id,
            "customer_id"=> $request->customer_id,
            "payment_status"=> $request->payment_status,
        ];

        $is_created = Payment::create($data);

        return response()->json(['status' => 'success' , 'message' => 'Payment record successfully.' , 'data' => $is_created]);

    }


    public function paymentDetails($user_id){
        $data = Payment::where('user_id', $user_id)->orderBy('id','desc')->get();    
        return view('payment/users_transaction_list')->with('data' , $data);
    }

}
