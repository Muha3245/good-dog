<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('order')->get();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateQuestion($request);
        
        // Process question data
        $questionData = $this->processQuestionData($request, $validated);
        
        Question::create($questionData);
        
        return redirect()->route('questions.index')
               ->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $this->validateQuestion($request);
        
        // Process question data
        $questionData = $this->processQuestionData($request, $validated);
        
        $question->update($questionData);

        return redirect()->route('questions.index')
               ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')
               ->with('success', 'Question deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:questions,id'
        ]);

        foreach ($request->order as $order => $id) {
            Question::where('id', $id)->update(['order' => $order]);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Validate question request data
     */
    protected function validateQuestion(Request $request)
    {
        return $request->validate([
            'question' => 'required|string|max:255',
            'type' => 'required|in:text,description,radio,checkbox,select,file,yes_no',
            'options' => 'required_if:type,radio,checkbox,select|array|min:1',
            'options.*' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_required' => 'nullable|boolean'
        ]);
    }

    /**
     * Process question data before saving
     */
    protected function processQuestionData(Request $request, array $validated)
    {
        $data = [
            'question' => $validated['question'],
            'type' => $validated['type'],
            'order' => $validated['order'],
            'is_required' => $request->boolean('is_required')
        ];

        // Process options for question types that need them
        if (in_array($validated['type'], ['radio', 'checkbox', 'select'])) {
            $data['options'] = $this->processOptions($validated['options']);
        } else {
            $data['options'] = null;
        }

        return $data;
    }

    /**
     * Process and validate options array
     */
    protected function processOptions(array $options)
    {
        // Filter out empty options
        $filteredOptions = array_filter(array_map('trim', $options));
        
        if (empty($filteredOptions)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'options' => 'At least one option is required for this question type.'
            ]);
        }
        
        return json_encode(array_values($filteredOptions));
    }
}