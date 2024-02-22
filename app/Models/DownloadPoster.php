<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadPoster extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'party_id',
        'image'
    ];

    public function getImageAttribute()
    {
        return asset('/storage/uploads/posters/' . $this->attributes['image']);
    }


}
