<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = [ 
        'id_hebergement',
        'id_user',
        'id_proprio',
        'date_debut',
        'date_fin',
        'montant',
        'avance',
        'reste',
        'nbre_personne',
        'status'
    ];

    public function userPropio()
    {
        return $this->belongsTo(User::class, 'id_proprio');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function hebergement()
    {
        return $this->hasOne(Hebergement::class, 'id', 'id_hebergement');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_commande');
    }
}
