<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodite extends Model
{
    use HasFactory;
    protected $table = 'commodites';
    protected $fillable = [
        'wifi',
        'parking',
        'tv',
        'frigo',
        'clim',
        'gardien',
        'id_hebergement'
    ];

    public function hebergement()
    {
        return $this->belongsTo(Hebergement::class, 'id_hebergement');
    }
    
}
