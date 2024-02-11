<?php

namespace App\Http\Controllers;

use App\Models\PartyCity;
use App\Models\PartyState;
use Illuminate\Http\Request;

class StateCityController extends Controller
{
    //

    public function index(Request $request)
    {
        $data = PartyState::orderBy('english_name', 'asc')->get();
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

            PartyState::create($data);

            return redirect('state')->with('success', 'State has  been added successfully.');

        }

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
                'party_state_id' => $id
            ];

            PartyCity::create($data);

            return redirect('/city-list' . '/' . $id);
        }
    }

    public function cityList(Request $request, $id)
    {
        $data = PartyCity::where('party_state_id', $id)->orderBy('english_name', 'asc')->get();
        return view('state_city.city_list')->With('data', $data);

    }



}
