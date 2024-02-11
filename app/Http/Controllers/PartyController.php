<?php

namespace App\Http\Controllers;

use App\Models\Parties;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    //

    public function index(Request $request)
    {
        $data = Parties::orderBy('id', 'desc')->get();
        return view('parties.index')->With('data', $data);
    }


    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('parties.create');

        }
        if ($request->isMethod('POST')) {
            // return $request->all();
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
                'english_party_name' => 'required|string|max:255',
                'english_party_description' => 'required|string|max:255',
                'hindi_party_name' => 'required|string|max:255',
                'hindi_party_description' => 'required|string|max:255',

            ]);

            $data = [
                'english_party_name' => $request->english_party_name,
                'english_party_description' => $request->english_party_description,
                'hindi_party_name' => $request->hindi_party_name,
                'hindi_party_description' => $request->hindi_party_description

            ];

            // Handle file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/parties', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['party_image'] = $imageName;
            }

            Parties::create($data);

            return redirect('parties')->with('success', 'Party has  been added successfully.');

        }

    }

}
