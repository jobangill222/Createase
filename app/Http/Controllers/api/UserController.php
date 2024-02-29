<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\DownloadPoster;
use App\Models\Parties;
use App\Models\State;
use App\Models\StateParties;
use App\Models\Template;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getState(Request $request)
    {
        $data = State::orderBy('english_name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'State get successfully.',
            'data' => $data,
        ]);
    }

    public function getCity(Request $request, $state_id)
    {
        $data = City::where('state_id', $state_id)->orderBy('english_name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'City get successfully.',
            'data' => $data,
        ]);
    }

    public function getParty(Request $request)
    {
        $data = Parties::orderBy('english_party_name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Party get successfully.',
            'data' => $data,
        ]);
        //check
    }

    public function getPartyTemplate(Request $request)
    {
        $user = Auth::user();

        $user_details = User::where("id", $user->id)->first();

        if (!$user_details->current_party) {
            return response()->json(['status' => 'error', 'message' => 'Please select party first']);
        }

        if (!$user_details->state_id) {
            return response()->json(['status' => 'error', 'message' => 'Please select state first']);
        }

        // return $user;
        $party_details = Parties::where('id', $user_details->current_party)->first();
        $state_images_details = StateParties::where(['party_id' => $user_details->current_party, 'state_id' => $user_details->state_id])->first();


        $template = Template::where('party_id', $user_details->current_party)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Templates get successfully.',
            'data' => [
                'party_details' => $party_details,
                'state_images' => $state_images_details,
                'templates' => $template
            ],
        ]);
    }


    public function downloadPartyPoster(Request $request)
    {
        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'party_id' => $request->party_id,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/posters', $imageName); // Store the image in the storage directory
            // Save the image path or other relevant information to the database
            $data['image'] = $imageName;
        }

        $create = DownloadPoster::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Save successfully.',
            'data' => $create,
        ]);
    }

}