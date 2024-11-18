<?php

namespace App\Http\Controllers\api;

use App\Events\NewMessageEvent;
use App\Events\NewMessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $message = Message::create($data);

        broadcast(new NewMessageSent($message));
        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $data = $request->all();
        $message->update($data);
        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        Message::destroy($message->id);
        return new MessageResource($message);
    }
}
