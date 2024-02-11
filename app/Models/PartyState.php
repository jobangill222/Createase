<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyState extends Model
{
    use HasFactory;


    protected $table = 'party_states';

    protected $fillable = [
        'english_name',
        'hindi_name',
    ];

}
