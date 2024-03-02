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
        'filters'
    ];

    public function getBackgroundImageAttribute($value)
    {
        return asset('/storage/uploads/template/' . $value);
    }


    public function stateDetails()
    {
        return $this->belongsTo(State::class, 'state_id');
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


}