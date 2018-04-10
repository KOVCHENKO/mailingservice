<?php

namespace App\Http\Controllers;

use App\Core\Domain\Repository\ChannelRepositoryInterface;
use App\Core\Domain\Repository\MessageRepositoryInterface;
use App\Core\Domain\Services\ChannelMailingService;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $channelMailingService;

    private $channelRepository;
    private $messageRepository;



    /**
     * MessageController constructor.
     */
    public function __construct(ChannelMailingService $channelMailingService,

                                ChannelRepositoryInterface $channelRepository,
                                MessageRepositoryInterface $messageRepository
                                )
    {
        $this->channelMailingService = $channelMailingService;

        $this->channelRepository = $channelRepository;
        $this->messageRepository = $messageRepository;
    }


    /**
     * Возвращает view с возможностью добавления нового сообщения
     */
    public function show()
    {
        $channels = $this->channelRepository->getAll();
        $messages = $this->messageRepository->getAll();

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
        $message = $this->messageRepository->create($request);

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
    public function sync($messageId)
    {
        $messageWithChannels = $this->messageRepository->getMessageWithChannels($messageId);

        $this->channelMailingService->sync($messageWithChannels);

        return redirect('/show_messages');
    }

}
