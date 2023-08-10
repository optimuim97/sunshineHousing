<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePropertie extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'statut'
    ];
    
}
