<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_id',
        'background_image',
        'centre_image_1',
        'centre_image_2',
        'state_image_1',
        'state_image_2',
        'deleted_at',
    ];


    public function getBackgroundImageAttribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }

    public function getCentreImage1Attribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }
    public function getCentreImage2Attribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }
    public function getStateImage1Attribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }
    public function getStateImage2Attribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }

}
