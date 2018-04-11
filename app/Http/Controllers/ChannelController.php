<?php

namespace App\Http\Controllers;

use Core\Domain\Repository\ChannelRepositoryInterface;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    private $channelRepository;

    /**
     * ChannelController constructor.
     */
    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Все каналы
     */
    public function getAll()
    {
        return $this->channelRepository->getAll();
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
        $this->channelRepository->create($request);

        return redirect('/show_messages');
    }

}
