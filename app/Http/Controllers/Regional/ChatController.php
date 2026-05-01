<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $countryId = $user->country_id;

        // Get clients from the same country
        $clients = User::where('type', 'client')
            ->where('country_id', $countryId)
            ->get();

        $selectedClient = null;
        $messages = [];

        if ($request->has('client_id')) {
            $selectedClient = User::findOrFail($request->client_id);
            
            // Security check: Ensure client is in the same country
            if ($selectedClient->country_id != $countryId) {
                abort(403);
            }

            // Mark messages as read
            Message::where('sender_id', $selectedClient->id)
                ->where('receiver_id', $user->id)
                ->update(['is_read' => true]);

            $messages = Message::where(function($q) use ($user, $selectedClient) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $selectedClient->id);
                })->orWhere(function($q) use ($user, $selectedClient) {
                    $q->where('sender_id', $selectedClient->id)->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('regional.chat.index', compact('clients', 'selectedClient', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        // Security check: Ensure receiver is in the same country
        if ($receiver->country_id != $user->country_id) {
            abort(403);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
