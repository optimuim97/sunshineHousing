<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'statut'
    ];
    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_type_payment');
    }
}
