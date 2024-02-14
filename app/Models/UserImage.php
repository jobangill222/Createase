<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'is_active'
    ];

    public function getImageAttribute($value)
    {
        return asset('/storage/uploads/users/' . $this->attributes['image']);
    }


}
