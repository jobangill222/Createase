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
use App\Models\Filter;

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

    public function getTemplate(Request $request)
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
        $current_state_leaders = StateParties::where(['party_id' => $user_details->current_party, 'state_id' => $user_details->state_id])->first();


        $where = [
            'party_id' => $user_details->current_party,
            'state_id' => $user_details->state_id,
            'deleted_at' => null
        ];


        $inputArray = explode(',', $request->filter_ids);

        // $template = Template::where($where)->whereJsonContains('filter_ids', explode(',', $request->filter_ids))->get();

        if ($request->filter_ids) {
            $template = Template::where($where)
                ->where(function ($query) use ($inputArray) {
                    foreach ($inputArray as $value) {
                        $query->orWhereJsonContains('filter_ids', $value);
                    }
                })
                ->get();
        } else {
            $template = Template::where($where)->get();
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Templates get successfully.',
            'data' => [
                'party_details' => $party_details,
                'current_state_leaders' => $current_state_leaders,
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


    public function getFilterList()
    {
        $data = Filter::get();
        return response()->json([
            'status' => 'success',
            'message' => 'Filter get successfully.',
            'data' => $data,
        ]);
    }

}