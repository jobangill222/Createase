<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        if(!auth()->guest()) {
            /** @var $identity User */
            $identity=auth()->user();
            if($identity->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function profile()
    {
        return view('profile.profile');
    }

    public function updatePassword(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'old_password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('profile'))->withErrors($validator)->withInput();
        }

        if(!Hash::check($request->input('old_password'),$user->password)) {
            return redirect(route('profile'))->with('error', 'Old password not matched');
        }

        $user->updatePassword($request->input('password'));
        return redirect(route('profile'))->with('success', 'Password has been updated');
    }
}
