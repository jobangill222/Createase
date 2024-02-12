<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function signin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'phone_number' => 'required|max:10',
        ]);

        // Check if the user with the given phone number exists
        $user = User::where('phone_number', $request->phone_number)->first();

        // If user exists, update their details
        if ($user) {
            // Assuming you have other fields to update, you can update them here
            $user->update([
                // Update other fields as needed
            ]);
        } else {
            // If user does not exist, create a new user
            $user = User::create([
                'phone_number' => $request->phone_number,
                // Other fields can be filled here
            ]);
        }

        // Generate token for the user 
        // Auth::login($user);
        // $user = Auth::user();


        // $token = $user->createToken('admin -api-skeleton')->plainTextToken;

        // Return user details along with token
        return response()->json([
            'status' => 'success',
            'message' => 'Signin successfully.',
            'data' => $user,
            // 'token' => $token,
        ]);
    }



}
