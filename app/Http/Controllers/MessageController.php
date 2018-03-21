<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\ChannelMailingService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $message;
    private $channelController;
    private $channelMailingService;

    /**
     * MessageController constructor.
     */
    public function __construct(Message $message, ChannelController $channelController, ChannelMailingService $channelMailingService)
    {
        $this->message = $message;
        $this->channelController = $channelController;
        $this->channelMailingService = $channelMailingService;
    }


    /**
     * Возвращает view с возможностью добавления нового сообщения
     */
    public function show()
    {
        $channels = $this->channelController->getAll();

        return view('messages.messages')->with('channels', $channels);
    }

    /**
     * @param Request $request
     * Создать новое сообщение
     */
    public function create(Request $request)
    {
        $this->channelMailingService->sendToDifferentChannels($request->provider_type);
//        $this->message->create([
//
//        ]);
    }


}
