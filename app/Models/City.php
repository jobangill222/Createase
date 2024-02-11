<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends BaseModel
{
    public static function getCityFromName(State $state, $name)
    {
        return self::where([
            ['state_id', '=', $state->id],
            ['name', 'like', $name],
        ])->first();
    }
}
