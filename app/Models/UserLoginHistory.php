<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends BaseModel
{
    protected $fillable = [
        'user_id',
        'user_agent',
        'created_at',
        'created_ip',
    ];
}
