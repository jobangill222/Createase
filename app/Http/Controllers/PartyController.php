<?php

namespace App\Http\Controllers;

use App\Models\Parties;
use App\Models\State;
use App\Models\StateParties;
use App\Models\Template;
use App\Models\Filter;

use Illuminate\Http\Request;

class PartyController extends Controller
{
    //

    public function index(Request $request)
    {
        $data = Parties::orderBy('id', 'desc')->where('is_deleted', null)->get();
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
                'party_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
                'english_party_name' => 'required|string|max:255',
                'english_party_description' => 'required|string|max:255',
                'hindi_party_name' => 'required|string|max:255',
                'hindi_party_description' => 'required|string|max:255',
                // 'centre_image_first' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
                // 'centre_image_second' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
            ]);

            $data = [
                'english_party_name' => $request->english_party_name,
                'english_party_description' => $request->english_party_description,
                'hindi_party_name' => $request->hindi_party_name,
                'hindi_party_description' => $request->hindi_party_description
            ];

            // Handle file upload
            if ($request->hasFile('party_image')) {
                $image = $request->file('party_image');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/parties', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['party_image'] = $imageName;
            }

            if ($request->hasFile('centre_image_first')) {
                $image = $request->file('centre_image_first');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['centre_image_first'] = $imageName;
            }

            if ($request->hasFile('centre_image_second')) {
                $image = $request->file('centre_image_second');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['centre_image_second'] = $imageName;
            }



            Parties::create($data);

            return redirect('parties')->with('success', 'Party has  been added successfully.');

        }

    }


    public function edit(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $party_details = Parties::where('id', $id)->first();
            return view('parties.edit')->with('party_details', $party_details);

        }
        if ($request->isMethod('POST')) {

            $request->validate([
                // 'party_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
                'english_party_name' => 'required|string|max:255',
                'english_party_description' => 'required|string|max:255',
                'hindi_party_name' => 'required|string|max:255',
                'hindi_party_description' => 'required|string|max:255',
                // 'centre_image_first' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
                // 'centre_image_second' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for the image field
            ]);

            $data = [
                'english_party_name' => $request->english_party_name,
                'english_party_description' => $request->english_party_description,
                'hindi_party_name' => $request->hindi_party_name,
                'hindi_party_description' => $request->hindi_party_description
            ];

            // Handle file upload
            if ($request->hasFile('party_image')) {
                $image = $request->file('party_image');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/parties', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['party_image'] = $imageName;
            }

            if ($request->hasFile('centre_image_first')) {
                $image = $request->file('centre_image_first');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['centre_image_first'] = $imageName;
            }

            if ($request->hasFile('centre_image_second')) {
                $image = $request->file('centre_image_second');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/leaders', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database

                $data['centre_image_second'] = $imageName;
            }

            Parties::where('id', $id)->update($data);

            return redirect('parties')->with('success', 'Party has  been edited successfully.');

        }

    }


    public function deleteparty(Request $request, $id)
    {
        Parties::where('id', $id)->update(['is_deleted' => 'true']);
        return back()->with('success', 'Paty deleted successfully.');
    }


    public function createTemplate(Request $request, $party_id)
    {
        if ($request->isMethod('GET')) {
            $parties_linked_states = StateParties::where('party_id', $party_id)->where('is_deleted', null)->pluck('state_id');
            $states = State::whereIn('id', $parties_linked_states)->where('is_deleted', null)->get();
            $filters = Filter::get();
            return view('parties.create_template')->with('states', $states)->with('filters', $filters);
        }
        if ($request->isMethod('POST')) {

            // return $request->all();

            $request->validate([
                'background_image' => 'required|image|mimes:jpeg,png,jpg',
                'state_id' => 'required',
                'filter' => 'required',
            ]);

            $states  = $request->state_id;


            
            // Handle file upload
            if ($request->hasFile('background_image')) {
                $background_image = $request->file('background_image');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $background_image->getClientOriginalExtension();
                $background_image->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['background_image'] = $imageName;
            }

            foreach($states as $item){

                    $data['party_id'] = $party_id;
                    $data['state_id'] = $item;
                    $data['filter_ids'] = json_encode($request->filter);

                    Template::create($data);

            }


            return redirect('view-template' . '/' . $party_id)->with('success', 'Template created successfully.');

        }
    }



    public function viewTemplate(Request $request, $party_id)
    {
        $data = Template::where('party_id', $party_id)->where('deleted_at', null)->orderBy('id', 'desc')->with('stateDetails')->get();
        return view('parties.template_list')->with('data', $data)->with('party_id', $party_id);
    }

    public function deleteTemplate(Request $request, $id)
    {
        Template::where('id', $id)->update(['deleted_at' => Date('Y-m-d h:i:s')]);
        return back()->with('success', 'Template deleted successfully.');
    }


    public function editTemplate(Request $request, $id)
    {
        $template_details = Template::where('id', $id)->first();

        if ($request->isMethod('GET')) {

            $parties_linked_states = StateParties::where('party_id', $template_details->party_id)->where('is_deleted', null)->pluck('state_id');
            $states = State::whereIn('id', $parties_linked_states)->where('is_deleted', null)->get();
            $filters = Filter::get();
            return view('parties.edit_template')->with('states', $states)->with('filters', $filters)->with('template_details', $template_details);
        }
        if ($request->isMethod('POST')) {

            // return $request->all();

            $request->validate([
                'state_id' => 'required',
                'filter' => 'required',
            ]);

            $data = [
                'state_id' => $request->state_id,
                'filter_ids' => json_encode($request->filter)
            ];

            // Handle file upload
            if ($request->hasFile('background_image')) {
                $background_image = $request->file('background_image');
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $background_image->getClientOriginalExtension();
                $background_image->storeAs('public/uploads/template', $imageName); // Store the image in the storage directory
                // Save the image path or other relevant information to the database
                $data['background_image'] = $imageName;
            }

            Template::where('id', $id)->update($data);

            return redirect('view-template' . '/' . $template_details->party_id)->with('success', 'Template edited successfully.');

        }
    }


}