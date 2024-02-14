<?php

namespace App\Http\Controllers;

use App\Models\Parties;
use App\Models\Template;
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


    public function createTemplate(Request $request, $party_id)
    {
        if ($request->isMethod('GET')) {
            return view('parties.create_template');
        }
        if ($request->isMethod('POST')) {

            $request->validate([
                'background_image' => 'required|image|mimes:jpeg,png,jpg',
                'centre_image_1' => 'required|image|mimes:jpeg,png,jpg',
                'centre_image_2' => 'required|image|mimes:jpeg,png,jpg',
                'state_image_1' => 'required|image|mimes:jpeg,png,jpg',
                'state_image_2' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            $data = [
                'party_id' => $party_id,
            ];

            // Handle file upload
            if ($request->hasFile('background_image')) {
                $background_image = $request->file('background_image');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $background_image->getClientOriginalExtension();
                $background_image->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['background_image'] = $imageName;
            }
            if ($request->hasFile('centre_image_1')) {
                $centre_image_1 = $request->file('centre_image_1');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $centre_image_1->getClientOriginalExtension();
                $centre_image_1->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['centre_image_1'] = $imageName;
            }
            if ($request->hasFile('centre_image_2')) {
                $centre_image_2 = $request->file('centre_image_2');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $centre_image_2->getClientOriginalExtension();
                $centre_image_2->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['centre_image_2'] = $imageName;
            }
            if ($request->hasFile('state_image_1')) {
                $state_image_1 = $request->file('state_image_1');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $state_image_1->getClientOriginalExtension();
                $state_image_1->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['state_image_1'] = $imageName;
            }
            if ($request->hasFile('state_image_2')) {
                $state_image_2 = $request->file('state_image_2');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $state_image_2->getClientOriginalExtension();
                $state_image_2->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['state_image_2'] = $imageName;
            }

            Template::create($data);

            return redirect('parties')->with('success', 'Template created successfully.');

        }
    }



    public function viewTemplate(Request $request, $party_id)
    {
        $data = Template::where('party_id', $party_id)->where('deleted_at', null)->orderBy('id', 'desc')->get();
        return view('parties.party_tempaltes')->with('data', $data);
    }

    public function deleteTemplate(Request $request, $id)
    {
        Template::where('id', $id)->update(['deleted_at' => Date('Y-m-d h:i:s')]);
        return back()->with('success', 'Template deleted successfully.');
    }

}