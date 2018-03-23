<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
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
        $messages = $this->message->all();

        return view('messages.messages')->with([
                'channels' => $channels,
                'messages' => $messages
            ]);
    }

    /**
     * @param Request $request
     * Создать новое сообщение
     */
    public function create(MessageRequest $request)
    {
        $message = $this->message->create([
            'type' => $request->type,
            'contact' => $request->contact,
            'data' => $request->data,
            'status' => 'created'
        ]);

        $this->channelMailingService->sendToDifferentChannels(
            $request->channel_type,
            [
                'contact' => $request->contact,
                'data' => $request->data
            ],
            $message->id
        );

        return redirect('/show_messages');
    }

    /**
     * @param $messageId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Получить статус сообщения
     */
    public function getStatus($messageId)
    {
        $message = $this->message->where('id', $messageId)->with('channels')->first();
        $this->channelMailingService->getMessageStatus($message);

        return redirect('/show_messages');
    }


    public function attemptToSendAgain()
    {
        $channelsArray = $this->message->with('failedChannels')->get();
        dd($channelsArray);

        $channelsArray = array();
        $contactData = '';
        $messageId = 0;

        $this->channelMailingService->sendToDifferentChannels($channelsArray, $contactData, $messageId);
    }


}
