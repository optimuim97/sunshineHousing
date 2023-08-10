<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HebergementOption extends Model
{
    use HasFactory;
    // protected $table = 'hebergement_option';

    protected $fillable = [
        'hebergement_id',
        'commodite_id'
    ];


}
