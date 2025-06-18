<?php

namespace App\Http\Controllers;

use App\Models\BreederProfile;
use App\Models\ChatMessage;
use App\Events\ChatMessageSent;
use App\Events\ChatMessageRead;
use App\Models\Conversation;
use App\Models\Question;

use App\Models\Answer;
use App\Models\Puppy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::get();
        $submissions = Answer::with(['user', 'puppy'])
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->get();
        $conversations=Conversation::get();
        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('chat', [
            'users' => $users,
            'submissions' => $submissions,
            'questions' => $questions,
            'conversations' => $conversations,

        ]);
    }

    public function chatindex()
    {
        $conversations = Conversation::with(['messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->with(['user', 'breeder.user', 'puppy'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('chatsshow', compact('conversations'));
    }

    public function show($conversationId)
    {
        $conversation= Conversation::findOrFail($conversationId);
        $receiver_id = ($conversation->user_id == Auth::id())
        ? $conversation->breeder->user_id
        : $conversation->user_id;
        $currentUser = auth()->user();
        $receiver = User::findOrFail($receiver_id);
    
        $messages = ChatMessage::where(function($query) use ($currentUser, $receiver_id) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $receiver_id);
            })
            ->orWhere(function($query) use ($currentUser, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                      ->where('receiver_id', $currentUser->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
    
        // Return JSON if the request wants JSON (like AJAX calls)
        
        return view('chatsshow', [
            'messages' => $messages,
        'currentUser' => $currentUser,
        'receiver' => $receiver,
        'conversation' => $conversation
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
            'conversation_id' => 'nullable|exists:conversations,id'
        ]);
    
        $message = ChatMessage::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]); // Eager load relationships
        // Broadcast the event to all participants
        broadcast(new ChatMessageSent($message))->toOthers();
    
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);
        }
    
        return redirect()->back()->with('success', 'Message sent!');
    }

    public function storeconversations(Request $request)
    {
        $request->validate([
            'breeder_id' => 'nullable|exists:breeder_profiles,id',
            'user_id' => 'required|exists:users,id',
            'puppy_id' => 'required|exists:puppies,id',
        ]);

        $breederId = $request->breeder_id ?? BreederProfile::where('user_id', '!=', $request->user_id)
            ->first()
            ?->id;

        if (!$breederId) {
            return back()->with('error', 'No breeder available to start conversation');
        }

        $conversation = Conversation::updateOrCreate(
            [
                'breeder_id' => $breederId,
                'user_id' => $request->user_id,
                'puppy_id' => $request->puppy_id,
            ],
            ['last_message_at' => now()]
        );

        return redirect()->route('chat.show', $conversation->id)
            ->with('success', 'Conversation started successfully!');
    }
    public function getMessages($id)
    {
        $conversations = Conversation::where('user_id',$id)->with('user')->get();
        return view('userconversations', compact('conversations'));
    }
    // In ChatController or relevant controller
public function markMessagesAsRead(Request $request)
{
    // dd($request->all());
    $userId = $request->input('user_id'); // ID of the user whose messages are being marked as read
    $authUserId = auth()->id(); // ID of the authenticated user

    // Update unread messages for the authenticated user
    $unreadMessages= ChatMessage::where('sender_id', $userId)
        ->where('receiver_id', $authUserId)
        ->where('is_read', 0)
        ->update([
            'is_read' => 1,
            'read_at' => now(),
        ]);
        if ($unreadMessages->isNotEmpty()) {
            // Update all messages at once
            ChatMessage::whereIn('id', $unreadMessages->pluck('id'))
                ->update([
                    'is_read' => 1, // Changed from true to 1
                    'read_at' => now()
                ]);

            // Broadcast events for each updated message
            foreach ($unreadMessages as $message) {
                $message->refresh(); // Get updated attributes
                broadcast(new ChatMessageRead($message))->toOthers();
            }
        }

    return response()->json(['success' => true]);
}
}