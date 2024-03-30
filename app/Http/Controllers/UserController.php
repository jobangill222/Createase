<?php

namespace App\Http\Controllers;

use App\Base\Model\BaseModel;
use App\Components\Helper;
use App\Constants\CommonConstants;
use App\Constants\UserConstants;
use App\Models\user;
use App\Models\UserImage;
use App\Models\UserLoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        return $this->save($request, $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with(['userImages', 'partyDetails', 'stateDetails', 'cityDetails'])->first();
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        return $this->save($request, $user);
    }

    /**
     * responsible to manage update and create
     */
    private function save(Request $request, User $user)
    {
        $isNewRecord = true;
        if ($user->id != null) {
            $isNewRecord = false;
        }

        $rules = [
            'status' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];

        if ($isNewRecord) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($isNewRecord) {
                return redirect()->route('user.create')->withErrors($validator)->withInput();
            } else {
                return redirect()->route('user.edit', $user->id)->withErrors($validator)->withInput();
            }
        }

        $ip = request()->ip();
        $ipDetails = Helper::fetchIpDetails($ip, true);

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->user_role_id = CommonConstants::DEFAULT_USER_ROLE;

        if ($isNewRecord) {
            $user->password = $request->input('password');
            $user->user_agent = request()->userAgent();
            $user->email_verified_at = date(CommonConstants::PHP_DATE_FORMAT);
            $user->save();
        } else {
            $user->update();
        }

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return view('user.change-password', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword($id, Request $request)
    {
        /**
         * @var User $user
         */
        $user = User::where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('user.changePassword', ['id' => $user->id]))->withErrors($validator)->withInput();
        }

        $user->updatePassword($request->input('password'), false);
        return redirect(route('user.changePassword', ['id' => $user->id]))->with('success', 'Password has been updated');
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $identity = Auth::user();

            $query = User::where('user_role_id', '!=', UserConstants::ROLE_ADMIN);
            //$query = User::where('user_role_id',UserConstants::ROLE_ADMIN);
            BaseModel::buildFilterQuery($query, [
                'q' => ['name', 'email', 'phone_number'],
                'status',
                'role' => 'user_role_id'
            ]);

            return Datatables::eloquent($query)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('phonenumber', function ($row) {
                    return $row->phone_number;
                })
                ->addColumn('created_at', function ($row) {
                    return Helper::displayTime($row->created_at);
                })
                ->addColumn('emailVerified', function ($row) {
                    return Helper::printYesNoBadge(!($row->email_verified_at == null));
                })
                ->addColumn('actions', function ($row) {
                    return Helper::getActionButtons([
                        // 'Login' => ['url' => route('user.loginAs', $row->id), 'icon' => 'las la-sign-in-alt'],
                        'view' => ['url' => route('user.show', $row->id)],
                        'payment' => ['url' => route('payment.show', $row->id)],

                        // 'edit' => ['url' => route('user.edit', $row->id)],
                        // 'markActive' => ['url' => route('user.markEmailVerified', $row->id), 'icon' => 'la la-check', 'visible' => ($row->email_verified_at == null)],
                    ]);
                })
                ->rawColumns(['checkboxes', 'actions', 'status', 'emailVerified'])
                ->make(true);
        }
    }

    public function markEmailVerified($id, Request $request)
    {
        /**
         * @var User $user
         */
        $user = User::where('id', $id)->firstOrFail();
        $user->email_verified_at = date(CommonConstants::PHP_DATE_FORMAT);
        $user->update();
        return redirect()->back()->with('success', 'User marked as email verified');
    }

    public function loginAs($id, Request $request)
    {
        /**
         * @var User $user
         */
        $user = User::where('id', $id)->firstOrFail();
        Auth::login($user, true);
        return redirect()->route('redirect');
    }



    public function deleteUser(Request $request , $id){
        User::where('id', $id)->delete();
        UserImage::where('user_id', $id)->delete();
        UserLoginHistory::where('user_id', $id)->delete();
        return redirect('user')->with('success','User deleted successfully.');
    }


}