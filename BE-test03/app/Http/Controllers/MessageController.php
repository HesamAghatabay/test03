<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->get();
        return response()->json($messages, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'min:"1"'
        ]);
        $message = Message::create([
            'content' => $request->text,
            'user_id' => '1',
        ]);
        broadcast(new MessageSent($message))->toOthers();
        return response()->json('message create success!', 201);
    }
}
