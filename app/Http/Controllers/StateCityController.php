<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Parties;
use App\Models\PartyCity;
use App\Models\PartyState;
use App\Models\State;
use App\Models\StateParties;
use Illuminate\Http\Request;

class StateCityController extends Controller
{
    //

    public function index(Request $request)
    {
        $data = State::orderBy('english_name', 'asc')->where('is_deleted', null)->get();
        return view('state_city.state_list')->With('data', $data);
    }


    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('state_city.create_state');

        }
        if ($request->isMethod('POST')) {
            // return $request->all();
            $request->validate([
                'english_name' => 'required|string|max:255',
                'hindi_name' => 'required|string|max:255',
            ]);

            $data = [
                'english_name' => $request->english_name,
                'hindi_name' => $request->hindi_name,
            ];

            State::create($data);

            return redirect('state')->with('success', 'State has  been added successfully.');

        }

    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $state_details = State::where('id', $id)->first();
            return view('state_city.edit_state')->with('state_details', $state_details);

        }
        if ($request->isMethod('POST')) {
            // return $request->all();
            $request->validate([
                'english_name' => 'required|string|max:255',
                'hindi_name' => 'required|string|max:255',
            ]);

            $data = [
                'english_name' => $request->english_name,
                'hindi_name' => $request->hindi_name,
            ];

            State::where('id', $id)->update($data);

            return redirect('state')->with('success', 'State has  been updated successfully.');

        }
    }

    public function delete(Request $request, $id)
    {
        State::where('id', $id)->update(['is_deleted' => 'true']);
        return redirect('state')->with('success', 'State deleted successfully.');

    }

    public function addCity(Request $request, $id)
    {
        if ($request->isMethod("GET")) {
            return view('state_city.create_city');
        }
        if ($request->isMethod("POST")) {

            $request->validate([
                'english_name' => 'required|string|max:255',
                'hindi_name' => 'required|string|max:255',
            ]);

            $data = [
                'english_name' => $request->english_name,
                'hindi_name' => $request->hindi_name,
                'state_id' => $id
            ];

            City::create($data);

            return redirect('/city-list' . '/' . $id);
        }
    }


    public function editCity(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $city_details = City::where('id', $id)->first();
            return view('state_city.edit_city')->with('city_details', $city_details);

        }
        if ($request->isMethod('POST')) {
            // return $request->all();
            $request->validate([
                'english_name' => 'required|string|max:255',
                'hindi_name' => 'required|string|max:255',
            ]);

            $data = [
                'english_name' => $request->english_name,
                'hindi_name' => $request->hindi_name,
            ];

            City::where('id', $id)->update($data);

            $city_details = City::where('id', $id)->first();

            return redirect('/city-list' . '/' . $city_details->state_id)->with('success', 'City has  been updated successfully.');

        }
    }

    public function deleteCity(Request $request, $id)
    {
        City::where('id', $id)->update(['is_deleted' => 'true']);
        return back()->with('success', 'City deleted successfully.');

    }

    public function cityList(Request $request, $id)
    {
        $data = City::where('state_id', $id)->orderBy('english_name', 'asc')->where('is_deleted', null)->get();
        return view('state_city.city_list')->With('data', $data);

    }


    public function linkStateParties(Request $request, $state_id)
    {
        if ($request->isMethod('GET')) {
            $all_parties = Parties::where('is_deleted', null)->orderBy('id', 'asc')->get();
            $already_linked_parties = StateParties::where('state_id', $state_id)->where('is_deleted', null)->orderBy('id', 'desc')->with('partyDetails')->get();

            return view('state_city.link_state_parties')
                ->with('all_parties', $all_parties)
                ->with('already_linked_parties', $already_linked_parties);
        }
        if ($request->isMethod('POST')) {

            $request->validate([
                'party_id' => 'required',
                // 'state_image_first' => 'required|image|mimes:jpeg,png,jpg',
                // 'state_image_second' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            $check_party_already_linked = StateParties::where('state_id', $state_id)->where('party_id', $request->party_id)->where('is_deleted', null)->first();
            if ($check_party_already_linked) {
                return back()->with('error', 'Party already linked');
            }

            $data = [
                'state_id' => $state_id,
                'party_id' => $request->party_id,
            ];

            // Handle file upload
            if ($request->hasFile('state_image_first')) {
                $state_image_first = $request->file('state_image_first');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $state_image_first->getClientOriginalExtension();
                $state_image_first->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['state_leader_first'] = $imageName;
            }

            if ($request->hasFile('state_image_second')) {
                $state_image_second = $request->file('state_image_second');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $state_image_second->getClientOriginalExtension();
                $state_image_second->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['state_leader_second'] = $imageName;
            }

            StateParties::create($data);

            return back()->with('success', 'party linked successfully.');

        }
    }


    public function unLinkStateparty(Request $request, $id)
    {
        StateParties::where('id', $id)->delete();
        return back()->with('success', 'party unlink successfully.');
    }




}