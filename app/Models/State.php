<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends BaseModel
{
    public static function getStateFromName(Country $country, $name)
    {
        return self::where([
            ['country_id', '=', $country->id],
            ['name', 'like', $name],
        ])->first();
    }
}
