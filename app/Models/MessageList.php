<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageList extends Model
{
    protected $fillable = ['id_user_customer', 'id_user_proprio', 'date'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_user_customer');
    }

    public function proprio()
    {
        return $this->belongsTo(User::class, 'id_user_proprio');
    }

    public function details()
    {
        return $this->hasMany(MessageDetail::class, 'id_message_list');
    }


}

