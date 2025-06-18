<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Questionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #e0e7ff;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fc;
            --dark-color: #2d3748;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .questionnaire-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .questionnaire-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        }

        .questionnaire-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .questionnaire-header h3 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .questionnaire-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .progress-bar-container {
            margin-bottom: 30px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .progress-info span:first-child {
            color: var(--dark-color);
            font-weight: 500;
        }

        .progress-info span:last-child {
            color: var(--primary-color);
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            background-color: var(--border-color);
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
            transition: width 0.4s ease;
        }

        .question {
            margin-bottom: 25px;
            padding: 25px;
            border-radius: 12px;
            background-color: white;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
        }

        .question.active {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-sm);
        }

        .question h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-color);
            position: relative;
            padding-left: 20px;
        }

        .question h4::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--primary-color);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Card-based Yes/No Options */
        .option-cards {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .option-card {
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            border: 2px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .option-card:hover {
            border-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .option-card.selected {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
        }

        .option-card.selected::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .option-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .option-card .option-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .option-card .option-label {
            font-weight: 500;
            color: var(--dark-color);
        }

        /* Checkbox Cards */
        .checkbox-card {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            background-color: white;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 10px;
        }

        .checkbox-card:hover {
            border-color: var(--primary-light);
        }

        .checkbox-card.selected {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
        }

        .checkbox-card input[type="checkbox"] {
            margin-right: 15px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* File Upload */
        .file-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
        }

        .file-upload-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed var(--primary-color);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .file-upload-circle:hover {
            background-color: var(--primary-light);
        }

        .file-upload-circle i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .file-upload-circle input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-preview {
            position: relative;
            margin-top: 10px;
            width: 150px;
            height: 150px;
            display: none;
        }

        .file-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
        }

        .file-preview .remove-preview {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .file-preview .remove-preview:hover {
            background-color: #d1145a;
        }

        /* Navigation Buttons */
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .btn {
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background-color: white;
            color: var(--dark-color);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .questionnaire-container {
                padding: 25px;
                margin: 20px auto;
            }
            
            .option-cards {
                flex-direction: column;
                gap: 10px;
            }
            
            .question {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="questionnaire-container">
            <div class="questionnaire-header">
                <h3>Puppy Adoption Questionnaire</h3>
                <p>Please answer all questions to complete your adoption application</p>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-info">
                    <span id="progress-text">Question 1 of {{ count($questions) }}</span>
                    <span id="progress-percent">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>

            <!-- Questions Form -->
            <form id="questionnaireForm" action="{{ route('adoptions.storeAnswers', $puppyId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @foreach($questions as $index => $question)
                <div class="question @if($index !== 0) d-none @endif" id="question{{ $question->id }}" data-type="{{ $question->type }}">
                    <h4>{{ $index + 1 }}. {{ $question->question }}</h4>
                    
                    @if($question->type === 'text')
                        <input type="text" name="answers[{{ $question->id }}]" class="form-control" required>
                    
                    @elseif($question->type === 'yes_no')
                        <div class="option-cards">
                            <label class="option-card" for="yes_{{ $question->id }}">
                                <input type="radio" name="answers[{{ $question->id }}]" id="yes_{{ $question->id }}" value="yes" required>
                                <div class="option-icon"><i class="fas fa-check-circle"></i></div>
                                <div class="option-label">Yes</div>
                            </label>
                            <label class="option-card" for="no_{{ $question->id }}">
                                <input type="radio" name="answers[{{ $question->id }}]" id="no_{{ $question->id }}" value="no">
                                <div class="option-icon"><i class="fas fa-times-circle"></i></div>
                                <div class="option-label">No</div>
                            </label>
                        </div>
                    
                    @elseif($question->type === 'file')
                        <div class="file-upload-container">
                            <div class="file-upload-circle">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <input type="file" name="answers[{{ $question->id }}]" onchange="previewFile(this, '{{ $question->id }}')" required>
                            </div>
                            <div class="file-preview" id="preview-container-{{ $question->id }}">
                                <img id="preview_{{ $question->id }}" src="#" alt="Preview">
                                <button type="button" class="remove-preview" onclick="removePreview('{{ $question->id }}')">&times;</button>
                            </div>
                        </div>
                    
                    @elseif($question->type === 'description')
                        <textarea name="answers[{{ $question->id }}]" class="form-control" rows="4" required></textarea>
                    
                    @elseif(in_array($question->type, ['select', 'radio', 'checkbox']))
                        @php
                            $options = json_decode($question->options);
                        @endphp
                        
                        @if($question->type === 'select')
                            <select name="answers[{{ $question->id }}]" class="form-select" required>
                                <option value="">Select an option</option>
                                @foreach($options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        
                        @elseif($question->type === 'radio')
                            <div class="option-cards">
                                @foreach($options as $key => $option)
                                <label class="option-card" for="option_{{ $question->id }}_{{ $key }}">
                                    <input type="radio" name="answers[{{ $question->id }}]" 
                                           id="option_{{ $question->id }}_{{ $key }}" value="{{ $option }}" @if($key === 0) required @endif>
                                    <div class="option-icon">
                                        <i class="fas fa-{{ $key === 0 ? 'check-circle' : ($key === 1 ? 'times-circle' : 'circle') }}"></i>
                                    </div>
                                    <div class="option-label">{{ $option }}</div>
                                </label>
                                @endforeach
                            </div>
                        
                        @else
                            <div class="options-container">
                                @foreach($options as $key => $option)
                                <label class="checkbox-card">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]" 
                                           id="option_{{ $question->id }}_{{ $key }}" value="{{ $option }}">
                                    <span>{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
                @endforeach

                <!-- Navigation Buttons -->
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" id="prevButton" disabled>
                        <i class="fas fa-arrow-left me-2"></i>Previous
                    </button>
                    <button type="button" class="btn btn-primary" id="nextButton">
                        Next<i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewFile(input, questionId) {
            const preview = document.getElementById(`preview_${questionId}`);
            const previewContainer = document.getElementById(`preview-container-${questionId}`);
            const uploadCircle = input.closest('.file-upload-circle');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    uploadCircle.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview(questionId) {
            const preview = document.getElementById(`preview_${questionId}`);
            const previewContainer = document.getElementById(`preview-container-${questionId}`);
            const uploadCircle = document.querySelector(`#question${questionId} .file-upload-circle`);
            const fileInput = document.querySelector(`#question${questionId} input[type="file"]`);

            preview.src = '#';
            previewContainer.style.display = 'none';
            uploadCircle.style.display = 'flex';
            fileInput.value = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const questions = document.querySelectorAll('.question');
            const progressBarFill = document.querySelector('.progress-bar-fill');
            const progressText = document.getElementById('progress-text');
            const progressPercent = document.getElementById('progress-percent');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const form = document.getElementById('questionnaireForm');
            let currentQuestionIndex = 0;

            // Initialize option cards
            document.querySelectorAll('.option-card').forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                
                // Set initial selected state
                if (radio.checked) {
                    card.classList.add('selected');
                }
                
                // Add click handler
                card.addEventListener('click', function() {
                    if (radio.type === 'radio') {
                        document.querySelectorAll(`input[name="${radio.name}"]`).forEach(r => {
                            r.closest('.option-card').classList.remove('selected');
                        });
                    }
                    
                    radio.checked = true;
                    card.classList.add('selected');
                });
            });

            // Initialize checkbox cards
            document.querySelectorAll('.checkbox-card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                
                // Set initial selected state
                if (checkbox.checked) {
                    card.classList.add('selected');
                }
                
                // Add click handler
                card.addEventListener('click', function() {
                    checkbox.checked = !checkbox.checked;
                    card.classList.toggle('selected', checkbox.checked);
                });
            });

            function updateProgressBar() {
                const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
                progressBarFill.style.width = progress + '%';
                progressText.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;
                progressPercent.textContent = `${Math.round(progress)}%`;
            }

            function showQuestion(index) {
                questions.forEach((question, i) => {
                    question.classList.toggle('d-none', i !== index);
                    question.classList.toggle('active', i === index);
                });
                
                prevButton.disabled = index === 0;
                nextButton.innerHTML = index === questions.length - 1 
                    ? 'Submit <i class="fas fa-paper-plane ms-2"></i>' 
                    : 'Next <i class="fas fa-arrow-right ms-2"></i>';
                updateProgressBar();
                
                // Scroll to the current question with offset for fixed headers
                const element = questions[index];
                const headerOffset = 100;
                const elementPosition = element.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }

            nextButton.addEventListener('click', function () {
                const currentQuestion = questions[currentQuestionIndex];
                const inputs = currentQuestion.querySelectorAll('input, textarea, select');
                let isValid = true;

                inputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        // For checkboxes, we need to check if at least one is checked
                        const checkboxes = currentQuestion.querySelectorAll(`input[name="${input.name}"]`);
                        const checked = Array.from(checkboxes).some(cb => cb.checked);
                        
                        if (!checked && input.required) {
                            isValid = false;
                            // Highlight all checkboxes in the group
                            checkboxes.forEach(cb => {
                                cb.reportValidity();
                                cb.closest('.checkbox-card').style.borderColor = 'var(--danger-color)';
                                setTimeout(() => {
                                    cb.closest('.checkbox-card').style.borderColor = '';
                                }, 2000);
                            });
                        }
                    } else if (!input.checkValidity()) {
                        isValid = false;
                        input.reportValidity();
                        
                        // Highlight invalid input
                        if (input.type !== 'file') {
                            input.style.borderColor = 'var(--danger-color)';
                            setTimeout(() => {
                                input.style.borderColor = '';
                            }, 2000);
                        }
                    }
                });

                if (isValid) {
                    if (currentQuestionIndex < questions.length - 1) {
                        currentQuestionIndex++;
                        showQuestion(currentQuestionIndex);
                    } else {
                        form.submit();
                    }
                }
            });

            prevButton.addEventListener('click', function () {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    showQuestion(currentQuestionIndex);
                }
            });

            // Initialize
            showQuestion(currentQuestionIndex);
        });
    </script>
</body>
</html>