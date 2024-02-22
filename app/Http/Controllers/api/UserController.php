<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DownloadPoster;
use App\Models\Parties;
use App\Models\PartyCity;
use App\Models\PartyState;
use App\Models\Template;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getState(Request $request)
    {
        $data = PartyState::orderBy('english_name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'State get successfully.',
            'data' => $data,
        ]);
    }

    public function getCity(Request $request, $state_id)
    {
        $data = PartyCity::where('party_state_id', $state_id)->orderBy('english_name', 'asc')->get();
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
    }

    public function getPartyTemplate(Request $request, $party_id)
    {
        $data = Template::where('party_id', $party_id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Templates get successfully.',
            'data' => $data,
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
