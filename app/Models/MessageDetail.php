<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MessageDetail extends Model
{
    protected $fillable = ['id_message_list', 'id_user_send', 'message', 'status'];

    public function list()
    {
        return $this->belongsTo(MessageList::class, 'id_message_list');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'id_user_send');
    }
}
