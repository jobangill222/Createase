<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function getProfile(Request $request)
    {
        return Auth::user();
    }

}
