<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    private $channel;

    /**
     * ChannelController constructor.
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Все каналы
     */
    public function getAll()
    {
        return $this->channel->all();
    }

    /**
     * Показать view для создания канала
     */
    public function showCreateView()
    {
        return view('channel.create');
    }

    /**
     * @param Request $request
     * Создать новый канал
     */
    public function create(Request $request)
    {
        $this->channel->create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return redirect('/show_messages');
    }

}
