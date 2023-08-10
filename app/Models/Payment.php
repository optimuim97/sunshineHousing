<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_type_payment',
        'id_commande',
        'montant',
        'date',
        'id_user',
        'status'
    ];

    public function typePayment()
    {
        return $this->belongsTo(TypePayment::class, 'id_type_payment');
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_commande');
    }
}

