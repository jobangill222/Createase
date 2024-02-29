<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateParties extends Model
{
    use HasFactory;


    protected $fillable = [
        'state_id',
        'party_id',
        'state_leader_first',
        'state_leader_second',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted',
        'created_at',
        'updated_at'
    ];


    public function partyDetails()
    {
        return $this->belongsTo(Parties::class, 'party_id');
    }


    public function getStateLeaderFirstAttribute($value)
    {
        if ($this->attributes['state_leader_first']) {
            return asset('/storage/uploads/leaders/' . $this->attributes['state_leader_first']);

        }
        return null;
    }

    public function getStateLeaderSecondAttribute($value)
    {
        if ($this->attributes['state_leader_second']) {
            return asset('/storage/uploads/leaders/' . $this->attributes['state_leader_second']);
        }
        return null;
    }

}