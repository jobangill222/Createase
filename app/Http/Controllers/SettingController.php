<?php

namespace App\Http\Controllers;

use App\Base\Model\BaseModel;
use App\Components\Helper;
use App\Constants\CommonConstants;
use App\Constants\UserConstants;
use App\Models\CryptoCurrency;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('setting.index');
        $setting = new Setting();
        return view('setting.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = new Setting();
        return $this->save($request, $setting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return redirect()->route('setting.index');
        return view('setting.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        return $this->save($request, $setting);
    }

    /**
     * responsible to manage update and create
     */
    private function save(Request $request, Setting $setting)
    {
        $isNewRecord = true;
        if ($setting->id != null) {
            $isNewRecord = false;
        }

        $rules = [
            'value' => ['required','string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($isNewRecord) {
                return redirect()->route('setting.create')->withErrors($validator)->withInput();
            } else {
                return redirect()->route('setting.edit', $setting->id)->withErrors($validator)->withInput();
            }
        }

        $ip = request()->ip();
        $ipDetails = Helper::fetchIpDetails($ip, true);

        $setting->value = $request->input('value');
        if($setting->update()) {
            
        }
        return redirect()->route('setting.index')->with('success', 'Global setting saved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //$setting->delete();
        return redirect()->route('setting.index')->with('error', 'Cannot delete global settings');
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $identity = Auth::user();

            $query = Setting::query();
            //$query = Keyword::where('Keyword_role_id',KeywordConstants::ROLE_ADMIN);
            BaseModel::buildFilterQuery($query, [
                'q' => ['name','value'],
            ]);

            return Datatables::eloquent($query)
                ->addColumn('checkboxes', function ($row) {
                    return '<input type="checkbox" name="pdr_checkbox[]" class="pdr_checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('created_at', function ($row) {
                    return Helper::displayTime($row->created_at);
                })
                ->addColumn('value', function ($row) {
                    return $row->actualValue;
                })
                ->addColumn('updated_at', function ($row) {
                    return Helper::displayTime($row->updated_at);
                })
                ->addColumn('actions', function ($row) {
                    return Helper::getActionButtons([
                        //'view' => ['url' => route('setting.show', $row->id)],
                        'edit' => ['url' => route('setting.edit', $row->id)],
                    ]);
                })
                ->rawColumns(['checkboxes', 'actions','value'])
                ->make(true);
        }
    }
}
