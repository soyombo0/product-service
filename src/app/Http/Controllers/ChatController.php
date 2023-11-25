<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\Request;
use Musonza\Chat\Facades\ChatFacade as Chat;
class ChatController extends Controller
{
    public function createConvo(Request $request)
    {
        $user = auth()->user();
        $conversation = Chat::createConversation([$user]);

        return $conversation->getParticipants();
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $data = $request->validated();
        $conversation = Chat::conversations()->getById(1);
        $message = Chat::message($data['message'])
            ->from(auth()->user())
            ->to($conversation)
            ->send();

        return Chat::conversation($conversation)->setParticipant(auth()->user())->getMessages();
    }

    public function indexConvo($var)
    {
        $paginated = Chat::conversations()->setParticipant(auth()->user())
            ->setPaginationParams($var)
            ->get();
    }
}
