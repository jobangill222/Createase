<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'english_name',
        'hindi_name',
        'party_state_id',
    ];

}
