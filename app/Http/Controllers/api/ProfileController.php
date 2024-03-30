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

        $data = User::where('id', $user->id)->with(['userImages', 'stateDetails', 'cityDetails'])->first();
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


        $users_existing_image_count = UserImage::where('user_id', $user->id)->count();
        if ($users_existing_image_count == 6) {
            $image = UserImage::where('user_id', $user->id)->where('is_active', '!=', 1)->first();
            if ($image) {
                $image->delete();
            }
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

        $user_details = User::where('id', $user->id)->first();
        $data = [
            'designation' => $request->designation ?? $user_details->designation,
            'state_id' => $request->state_id ?? $user_details->state_id,
            'city_id' => $request->city_id ?? $user_details->city_id,
            'name' => $request->name ?? $user_details->name,
        ];

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/users', $imageName); // Store the image in the storage directory
            // Save the image path or other relevant information to the database
            $data['profile_pic'] = $imageName;
            
            if($user->profile_pic){


                $users_existing_image_count = UserImage::where('user_id', $user->id)->count();
                if ($users_existing_image_count == 6) {
                    $image = UserImage::where('user_id', $user->id)->first();
                    if ($image) {
                        $image->delete();
                        UserImage::where('user_id', $user->id)->update(['is_active' => 0]);
                    }
                }

                $image_data = [
                    'user_id' => $user->id,
                    'image' => $imageName = basename($user->profile_pic),
                    'is_active' => 1
                ];
                UserImage::create($image_data);
            }
        }

        User::where('id', $user->id)->update($data);

        $user_details = User::where('id', $user->id)->with(['userImages', 'stateDetails', 'cityDetails'])->first();

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

    public function switchActiveImage(Request $request)
    {
        $user = Auth::user();

        UserImage::where('user_id', $user->id)->update(['is_active' => 0]);
        UserImage::where('id', $request->image_id)->update(['is_active' => 1]);

        return response()->json([
            'status' => 'success',
            'message' => 'Active image change successfully.',
        ]);
    }


    public function deleteDraftImage(Request $request, $image_id)
    {
        UserImage::where('id', $image_id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Draft image deleted successfully.',
        ]);
    }


    public function setDraftImageAsProfile(Request $request, $image_id){

        $user = auth()->user();
        
        UserImage::where('user_id', $user->id)->update(['is_active' => 0]);

        UserImage::where('id', $image_id)->update(['is_active' => 1]);

        $selected_image_detail = UserImage::where('id', $image_id)->first();

        User::where('id' , $user->id)->update(['profile_pic' => basename($selected_image_detail->image)]);

        return response()->json(['status' => 'success' , 'message' => 'Image changed successfully.']);
    }


}