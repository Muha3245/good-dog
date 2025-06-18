@extends('layouts.admin')

@section('admin')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Question</h1>
            </div>
            @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('questions.index') }}">Questions</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Question</h3>
                    </div>
                    <form action="{{ route('questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="question">Question Text *</label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" 
                                       id="question" name="question" value="{{ old('question', $question->question) }}" required>
                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Question Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="text" {{ old('type', $question->type) == 'text' ? 'selected' : '' }}>Text Input</option>
                                    <option value="textarea" {{ old('type', $question->type) == 'textarea' ? 'selected' : '' }}>Text Area</option>
                                    <option value="radio" {{ old('type', $question->type) == 'radio' ? 'selected' : '' }}>Radio Buttons</option>
                                    <option value="checkbox" {{ old('type', $question->type) == 'checkbox' ? 'selected' : '' }}>Checkboxes</option>
                                    <option value="select" {{ old('type', $question->type) == 'select' ? 'selected' : '' }}>Dropdown</option>
                                    <option value="file" {{ old('type', $question->type) == 'file' ? 'selected' : '' }}>File Upload</option>
                                    <option value="yes_no" {{ old('type', $question->type) == 'yes_no' ? 'selected' : '' }}>Yes/No</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="order">Display Order *</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $question->order) }}" min="0" required>
                                @error('order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="is_required" value="0">
                                    <input type="checkbox" class="custom-control-input" id="is_required" 
                                           name="is_required" value="1" 
                                           {{ old('is_required', $question->is_required) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_required">Required Question</label>
                                </div>
                            </div>

                            <div id="options-container" style="display: none;">
                                <div class="form-group">
                                    <label>Options *</label>
                                    <div id="options-wrapper">
                                        @php
                                            $options = old('options', $question->options ? json_decode($question->options) : ['']);
                                        @endphp
                                        
                                        @foreach($options as $index => $option)
                                        <div class="input-group mb-2 option-item">
                                            <input type="text" class="form-control" name="options[]" 
                                                   value="{{ $option }}" placeholder="Option {{ $index + 1 }}" >
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger remove-option" type="button">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-option" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-plus"></i> Add Option
                                    </button>
                                    @error('options')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                    @error('options.*')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Question
                            </button>
                            <a href="{{ route('questions.index') }}" class="btn btn-default float-right">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const optionsContainer = document.getElementById('options-container');
        const optionsWrapper = document.getElementById('options-wrapper');
        const addOptionBtn = document.getElementById('add-option');
    
        // Show/hide options based on question type
        function toggleOptions() {
            const needsOptions = ['radio', 'checkbox', 'select'].includes(typeSelect.value);
            optionsContainer.style.display = needsOptions ? 'block' : 'none';
            
            // Initialize options display based on current type
            if (['radio', 'checkbox', 'select'].includes('{{ $question->type }}')) {
                optionsContainer.style.display = 'block';
            }
        }
    
        // Add new option field
        addOptionBtn.addEventListener('click', function() {
            const optionCount = document.querySelectorAll('.option-item').length + 1;
            const newOption = document.createElement('div');
            newOption.className = 'input-group mb-2 option-item';
            newOption.innerHTML = `
                <input type="text" class="form-control" name="options[]" placeholder="Option ${optionCount}" >
                <div class="input-group-append">
                    <button class="btn btn-outline-danger remove-option" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            optionsWrapper.appendChild(newOption);
        });
    
        // Remove option field
        optionsWrapper.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option') || 
                e.target.closest('.remove-option')) {
                const optionItem = e.target.closest('.option-item');
                if (document.querySelectorAll('.option-item').length > 1) {
                    optionItem.remove();
                } else {
                    alert('You must have at least one option.');
                }
            }
        });
    
        // Initialize and add event listener
        toggleOptions();
        typeSelect.addEventListener('change', toggleOptions);
    });
    </script>
@endsection
