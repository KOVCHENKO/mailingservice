<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'type',
        'contact',
        'data',
    ];

    public function channels()
    {
        return $this->belongsToMany('App\Models\Channel', 'messages_channels');
    }

    public function updateMessageChannelStatus()
    {
        $user->roles()->updateExistingPivot($roleId, $attributes);
    }
}
