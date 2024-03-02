<?php

namespace App\Http\Controllers;

use App\Models\Filter;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    //

    public function filterList(Request $request)
    {
        $data = Filter::get();
        return view('filter.filter_list')->with('data', $data);
    }

    public function addFilter(Request $request)
    {
        if ($request->isMethod(('GET'))) {
            return view('filter.add_filter');
        }
        if ($request->isMethod('POST')) {

            $request->validate([
                'english_name' => 'required',
                'hindi_name' => 'required',
            ]);

            $data = [
                "english_name" => $request->english_name,
                "hindi_name" => $request->hindi_name
            ];

            Filter::create($data);

            return redirect('filter-list')->with('success', 'Filter added successfully.');

        }

    }

    public function editFilter(Request $request, $id)
    {
        if ($request->isMethod(('GET'))) {
            $filter_details = Filter::where('id', $id)->first();
            return view('filter.edit_filter')->with('filter_details', $filter_details);
        }
        if ($request->isMethod('POST')) {
            $request->validate([
                'english_name' => 'required',
                'hindi_name' => 'required',
            ]);

            $data = [
                "english_name" => $request->english_name,
                "hindi_name" => $request->hindi_name
            ];

            Filter::where('id', $id)->update($data);

            return redirect('filter-list')->with('success', 'Filter edited successfully.');
        }
    }

    public function deleteFilter(Request $request, $id)
    {
        Filter::where('id', $id)->delete();
        return back()->with('success', 'Filter deleted successfully');
    }

}