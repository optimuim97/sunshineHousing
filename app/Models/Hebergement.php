<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hebergement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'titre',
        'type_logement',
        'categorie',
        'ville',
        'commune',
        'description',
        'adresse',
        'id_user',
        'date_disponibilite',
        'nbre_personne',
        'nbre_lit',
        'nbre_sale_bain',
        'prix',
        'lat',
        'long',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'id_hebergement');
    }
    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'id_hebergement');
    }

    public function commodite()
    {
        return $this->hasMany(Commodite::class, 'id_hebergement');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
