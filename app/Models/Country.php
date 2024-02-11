<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends BaseModel
{
    public static function getCountryFromCountryCode($country_code)
    {
        return self::where('iso', $country_code)->first();
    }
}
