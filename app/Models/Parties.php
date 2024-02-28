<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parties extends Model
{
    use HasFactory;


    protected $fillable = [
        'party_image',
        'english_party_name',
        'english_party_description',
        'hindi_party_name',
        'hindi_party_description',
        'centre_image_first',
        'centre_image_second',
        'is_deleted',
    ];

    public function getPartyImageAttribute()
    {
        if ($this->attributes['party_image']) {
            return asset('/storage/uploads/parties/' . $this->attributes['party_image']);
        }
        return null;
    }

    public function getCentreimageFirstAttribute()
    {
        if ($this->attributes['centre_image_first']) {
            return asset('/storage/uploads/leaders/' . $this->attributes['centre_image_first']);
        }
        return null;
    }

    public function getCentreImageSecondAttribute()
    {
        if ($this->attributes['centre_image_second']) {
            return asset('/storage/uploads/leaders/' . $this->attributes['centre_image_second']);
        }
        return null;
    }


}