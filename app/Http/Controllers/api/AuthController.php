<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //

    public function signin(Request $request)
    {
        // Validate the request data
        // $request->validate([
        //     'phone_number' => 'required|max:10',
        // ]);


        if ($request->facebook_id) {
            $user = User::where('facebook_id', $request->facebook_id)->first();
            if (!$user) {
                if (!$request->phone_number) {
                    return response()->json(['status' => 'error', 'message' => 'Enter phone number']);
                } else {
                    $is_phone_already_exist = User::where('phone_number', $request->phone_number)->first();
                    if ($is_phone_already_exist) {
                        $is_phone_already_exist->facebook_id = $request->facebook_id;
                        $is_phone_already_exist->save();
                        $user_details = User::where('id', $is_phone_already_exist->id)->first();
                    } else {
                        $data = [
                            'facebook_id' => $request->facebook_id,
                            'phone_number' => $request->phone_number,
                        ];
                        $user_details = User::create($data);
                    }

                }
            } else {
                $user_details = User::where('id', $user->id)->first();
            }

        } else if ($request->phone_number) {
            $is_phone_already_exist = User::where('phone_number', $request->phone_number)->first();
            if (!$is_phone_already_exist) {
                $data = [
                    'phone_number' => $request->phone_number,
                ];
                $user_details = User::create($data);
            } else {
                $user_details = User::where('id', $is_phone_already_exist->id)->first();
            }
        }

        // Check if the user with the given phone number exists
        // $user = User::where('phone_number', $request->phone_number)->first();

        // // If user exists, update their details
        // if ($user) {
        //     // Assuming you have other fields to update, you can update them here

        //     if ($request->facebook_id) {
        //         $user->update([
        //             // Update other fields as needed
        //             'facebook_id' => $request->facebook_id
        //         ]);
        //     }
        // } else {
        //     // If user does not exist, create a new user
        //     $user = User::create([
        //         'phone_number' => $request->phone_number,
        //         // Other fields can be filled here
        //     ]);
        // }

        // Generate token for the user 
        Auth::login($user_details);
        $token = JWTAuth::fromUser($user_details);

        // Return user details along with token
        return response()->json([
            'status' => 'success',
            'message' => 'Signin successfully.',
            'data' => $user_details,
            'token' => $token,
        ]);
    }



}