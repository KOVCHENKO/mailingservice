<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    public function getByType($type)
    {
        return $this->where('type', $type)->first();
    }

    public function messages()
    {
        return $this->belongsToMany('App\Models\Message', 'messages_channels');
    }
}
