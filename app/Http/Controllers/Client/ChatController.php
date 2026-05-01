<?php

namespace App\Http\Controllers\Client;

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

        // Get regional offices from the same country
        $offices = User::where('type', 'regional_office')
            ->where('country_id', $countryId)
            ->get();

        $selectedOffice = null;
        $messages = [];

        if ($request->has('office_id')) {
            $selectedOffice = User::findOrFail($request->office_id);
            
            // Security check: Ensure office is in the same country
            if ($selectedOffice->country_id != $countryId || $selectedOffice->type != 'regional_office') {
                abort(403);
            }

            // Mark messages as read
            Message::where('sender_id', $selectedOffice->id)
                ->where('receiver_id', $user->id)
                ->update(['is_read' => true]);

            $messages = Message::where(function($q) use ($user, $selectedOffice) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $selectedOffice->id);
                })->orWhere(function($q) use ($user, $selectedOffice) {
                    $q->where('sender_id', $selectedOffice->id)->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('client.chat.index', compact('offices', 'selectedOffice', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        // Security check: Ensure receiver is a regional office in the same country
        if ($receiver->country_id != $user->country_id || $receiver->type != 'regional_office') {
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
