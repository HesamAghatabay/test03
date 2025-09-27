<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $me = Auth::user();
        $messages = Message::with('user')->get();
        return response()->json(['messages' => $messages, 'me' => $me], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);
        $message = Message::create([
            'content' => $request->text,
            'user_id' => '1',
        ]);
        broadcast(new MessageSent($message))->toOthers();
        return response()->json('message create success!', 201);
    }
}
