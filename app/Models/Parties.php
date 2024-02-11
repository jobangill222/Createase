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
        'hindi_party_description'
    ];

    public function getPartyImageAttribute()
    {
        return asset('/storage/uploads/parties/' . $this->attributes['party_image']);
    }


}
