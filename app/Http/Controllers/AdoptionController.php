<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Puppy;
use App\Events\ChatMessageSent;
use App\Events\ChatMessageRead;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\BreederProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function index()
    {
        $adoptions = Adoption::with(['puppy', 'user', 'breeder'])
            ->latest()
            ->paginate(10);

        return view('adoptions.index', compact('adoptions'));
    }

    public function create()
{
    // This will show the adoption form with puppy data from session
    return view('adoptions.form');
}

public function store(Request $request, Puppy $puppy)
{
    // Validate the request data
    $validated = $request->validate([
        'message' => 'nullable|string|max:500', // Optional message from the user
    ]);

    // Check if the user has answered a question
    $hasAnswered = Answer::where('user_id', Auth::id())->exists();

    // If the user hasn't answered, redirect back with an error message
    if (!$hasAnswered) {
        return redirect()->route('adoptions.questions', $puppy->id);
    }

    // Create the adoption request
    $adoption = Adoption::create([
        'puppy_id' => $puppy->id,
        'user_id' => Auth::id(),
        'breeder_id' => $puppy->breeder->id,
        'message' => $validated['message'] ?? null, // Use the validated message or null
        'status' => 'pending',
    ]);

    // Clear any related session data (optional, depending on your application logic)
    session()->forget('puppy_id');

    // Redirect to the adoption confirmation page with a success message
    return redirect()->back()
        ->with('success', 'Adoption request submitted successfully!');
}

    public function show(Adoption $adoption)
    {
        // $this->authorize('view', $adoption);
        
        return view('adoptions.show', compact('adoption'));
    }

    public function edit(Adoption $adoption)
    {
        $this->authorize('update', $adoption);
        
        return view('adoptions.edit', compact('adoption'));
    }

    public function update(Request $request, Adoption $adoption)
    {
        $this->authorize('update', $adoption);

        if ($adoption->breeder_id === Auth::id()) {
            // Breeder updating status
            $validated = $request->validate([
                'status' => 'required|in:approved,rejected',
                'rejection_reason' => 'required_if:status,rejected|nullable|string|max:255',
                'adoption_date' => 'required_if:status,approved|nullable|date',
                'notes' => 'nullable|string'
            ]);

            $adoption->update($validated);

            // Notify user about status change
            // $adoption->user->notify(new AdoptionStatusUpdated($adoption));

            return redirect()->route('adoptions.show', $adoption)
                ->with('success', 'Adoption request updated successfully!');
        } else {
            // User updating their request
            $validated = $request->validate([
                'message' => 'required|string|max:500'
            ]);

            $adoption->update($validated);

            return redirect()->route('adoptions.show', $adoption)
                ->with('success', 'Adoption request updated successfully!');
        }
    }

    public function destroy(Adoption $adoption)
    {
        $this->authorize('delete', $adoption);
        
        $adoption->delete();
        
        return redirect()->route('adoptions.index')
            ->with('success', 'Adoption request deleted successfully!');
    }

    // Breeder-specific actions
    public function breederIndex()
    {
        $breeders=BreederProfile::where('user_id', Auth::id())->first();
        $adoptions = Adoption::with(['puppy', 'user','breeder'])
            ->where('breeder_id', $breeders->id)
            ->latest()
            ->paginate(10);
            $counts = [
                'pending' => Adoption::where('breeder_id', auth()->id())->where('status', 'pending')->count(),
                'approved' => Adoption::where('breeder_id', auth()->id())->where('status', 'approved')->count(),
                'rejected' => Adoption::where('breeder_id', auth()->id())->where('status', 'rejected')->count(),
            ];

        return view('adoptions.breeder-index', compact('adoptions', 'counts'));
    }
    public function showUserDetails(User $user)
    {
        return view('adoptions.user-details', compact('user'));
    }

    public function approve(Adoption $adoption)
{
    // Authorization check (make sure the breeder owns this puppy)
    
    // Update adoption status
    $adoption->update([
        'status' => 'approved',
        'adoption_date' => now()
    ]);

    // Mark puppy as reserved

    // Reject any other pending requests for this puppy
    Adoption::where('puppy_id', $adoption->puppy_id)
        ->where('id', '!=', $adoption->id)
        ->where('status', 'pending')
        ->update([
            'status' => 'rejected',
            'rejection_reason' => 'Another adoption was approved for this puppy'
        ]);

    return back()->with('success', 'Adoption approved successfully!');
}

    public function reject(Adoption $adoption)
    {
        $this->authorize('breederAction', $adoption);
        
        $adoption->update([
            'status' => 'rejected',
            'rejection_reason' => request('rejection_reason', 'No reason provided')
        ]);

        return back()->with('success', 'Adoption rejected successfully!');
    }
    public function questions($puppyId)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // Check if the authenticated user has already submitted answers for this puppy
        $hasAnswered = Answer::
                            where('user_id', Auth::id())
                            ->exists();

        // If the user has already answered, redirect or show an error
        if ($hasAnswered) {
            return redirect()->route('puppiesprofile.show', $puppyId);
        }
    }

    // Fetch all questions with their answers
    $questions = Question::with('answers')->get(); // Use get() instead of all() for consistency
    return view('adoptions.questions', compact('questions', 'puppyId'));
}

    public function storeAnswers(Request $request, $puppyId)
{
    $request->validate([
        'answers' => 'required|array',
        'answers.*' => 'required'
    ]);

    $user = auth()->user(); // <-- Add this line to get the current user
    $userId = $user->id;

    foreach ($request->answers as $questionId => $answer) {
        $question = Question::findOrFail($questionId);

        
        if ($question->type === 'file' && $request->hasFile("answers.$questionId")) {
            // Get the uploaded file
            $uploadedFile = $request->file("answers.$questionId");

            // Define the destination path within the public directory
            $destinationPath = public_path('uploads/answers');

            // Generate a unique file name to avoid conflicts
            $fileName = time() . '_' . $uploadedFile->getClientOriginalName();

            // Move the file to the destination path
            $uploadedFile->move($destinationPath, $fileName);

            // Save the file path in the database
            $filePath = 'uploads/answers/' . $fileName;

            Answer::create([
                'user_id' => $userId,
                'puppy_id' => $puppyId,
                'question_id' => $questionId,
                'file_path' => $filePath,
            ]);
        } elseif (in_array($question->type, ['checkbox', 'radio', 'select']) && is_array($answer)) {
            Answer::create([
                'user_id' => $userId,
                'puppy_id' => $puppyId,
                'question_id' => $questionId,
                'answer' => json_encode($answer)
            ]);
        } else {
            Answer::create([
                'user_id' => $userId,
                'puppy_id' => $puppyId,
                'question_id' => $questionId,
                'answer' => $answer
            ]);
        }
    }

    $breeder = BreederProfile::first(); // Assuming there's only one breeder or getting the first
    $puppy = Puppy::findOrFail($puppyId); // Make sure you also retrieve the puppy



    $message = ChatMessage::create([
        'conversation_id' => $conversation->id ?? null,
        'sender_id' => $userId,
        'receiver_id' => $breeder->id,
        'message' => "New adoption application submitted for {$puppy->name}!",
        'metadata' => json_encode([
            'type' => 'questionnaire_submission',
            'puppy_id' => $puppy->id,
            'puppy_name' => $puppy->name,
            'user_id' => $userId,
            'user_name' => $user->name,
        ])
    ]);

    broadcast(new ChatMessageRead($message))->toOthers();
    return redirect()->route('puppiesprofile.show', $puppyId)
           ->with('success', 'Your answers have been submitted.');
}

}