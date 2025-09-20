<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'min:"1"'
        ]);
        Message::create([
            'content' => $request->text,
            'user_id' => '1',
        ]);
        return response()->json('message create success!', 201);
    }
}
