<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_id',
        'state_id',

        'color_code',
        'designation_color_code',
        
        'background_image',
        'filter_ids',
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'filters',
        'states'
    ];

    public function getBackgroundImageAttribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }

  
    public function getFiltersAttribute()
    {
        if ($this->attributes['filter_ids']) {
            $filterString = json_decode($this->attributes['filter_ids']);
            $data = Filter::whereIn('id', $filterString)->pluck('english_name')->implode(', ');
            return $data;
        }
        return null;
    }


    public function getStatesAttribute()
    { 

        if ($this->attributes['state_id']) {

            if(is_array(json_decode($this->attributes['state_id'], true))){
                $stateString = json_decode($this->attributes['state_id']);
                $data = State::whereIn('id', $stateString)->pluck('english_name')->implode(', ');
                return $data;
            }
            else{
                $data = State::where('id', $this->attributes['state_id'])->first();
                return $data->english_name;
            }
        }
        return null;
    }


}