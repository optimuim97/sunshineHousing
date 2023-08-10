<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['file_url',
     'type_file', 'id_user', 'id_hebergement', 'status'];
    public function hebergement()
{
    return $this->belongsTo(Hebergement::class, 'id_hebergement');
}

}
