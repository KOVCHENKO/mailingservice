<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'type',
        'contact',
        'data',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * сообщения_каналы - все
     */
    public function channels()
    {
        return $this->belongsToMany('App\Models\Channel', 'messages_channels');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * Получить все сообщения, которые не были доставлены по определенным каналам
     */
    public function failedChannels()
    {
        return $this->belongsToMany('App\Models\Channel', 'messages_channels')
            ->wherePivot('status', 'failed')->wherePivot('attempts', '<>', 0);
    }



}
