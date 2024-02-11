<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends BaseModel
{
    protected $fillable = [
        'user_id', 'particulars', 'created_ip', 'user_agent', 'type', 'data'
    ];

    protected $attributes = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function insertLog($data){
        if(is_array($data) && array_key_exists('data', $data)){
            if(is_array($data['data'])){
                $data['data'] = json_encode($data['data']);
            }
        }
        Log::create($data);
    }
}
