<?php

namespace App\Http\Controllers\Auth;

use App\Components\Helper;
use App\Constants\CommonConstants;
use App\Constants\LogConstants;
use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        $ip = request()->ip();
        $country_ip = Helper::fetchIpDetails($ip, true);
        /**
         * @var $user User
         */
        $user->userLoginHistory()->create([
            'created_at' => date(CommonConstants::PHP_DATE_FORMAT),
            'created_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'country_id' => $country_ip ? $country_ip['country']->id : null,
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $checkUser = User::query()->where($fieldType, '=', $input['username'])->first();
        if ($checkUser) {
            if ($checkUser->status != UserConstants::STATUS_ACTIVE) {
                throw ValidationException::withMessages([
                    'username' => [trans('auth.failed')],
                ]);
            }
        }
        if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
            $ip = request()->ip();
            $country_ip = Helper::fetchIpDetails($ip, true);

            auth()->user()->userLoginHistory()->create([
                'created_at' => date(CommonConstants::PHP_DATE_FORMAT),
                'created_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'country_id' => $country_ip ? $country_ip['country']->id : null,
            ]);

            if (\Session::has('redirect_after_login')) {
                return redirect()->to(\Session::get('redirect_after_login'));
            }

            // return redirect($this->redirectTo);
            return redirect('/user');

        } else {
            throw ValidationException::withMessages([
                'username' => [trans('auth.failed')],
            ]);
        }
    }
}
