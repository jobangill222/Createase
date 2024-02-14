<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserImage;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function getProfile(Request $request)
    {
        $user = Auth::user();

        $data = User::where('id', $user->id)->with('userImages')->first();
        return response()->json([
            'status' => 'success',
            'message' => 'User details get successfully.',
            'data' => $data,
        ]);
    }


    public function uploadImage(Request $request)
    {
        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'is_active' => $request->is_active === 'true' ? true : false
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/users', $imageName); // Store the image in the storage directory
            // Save the image path or other relevant information to the database
            $data['image'] = $imageName;
        }

        $create = UserImage::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Image upload successfully.',
            'data' => $create,
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        User::where('id', $user->id)->update($data);

        $user_details = User::where('id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile update successfully.',
            'data' => $user_details,
        ]);
    }


    public function switchParty(Request $request)
    {
        $user = Auth::user();

        User::where('id', $user->id)->update(['current_party' => $request->party_id]);
        $user_details = User::where('id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Party changed successfully.',
            'data' => $user_details,
        ]);
    }

}
