@php
    $user = App\Helpers\helpers::user();
    $breeder = App\Helpers\Helpers::isBreeder();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat with {{ $receiver->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            min-width: 100vw;
            background: linear-gradient(135deg, #a7bfe8 0%, #f5f7fa 100%);
        }

        .main-chat-wrapper {
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: row;
            background: rgba(255, 255, 255, 0.95);
        }

        .chat-sidebar {
            width: 320px;
            background: #6366f1;
            color: #fff;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #e2e2e2;
            padding: 1.5rem 1rem 1rem 1rem;
        }

        .chat-sidebar .sidebar-header {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .chat-sidebar .sidebar-user {
            padding: 0.75rem 0.5rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            background: rgba(255, 255, 255, 0.08);
            cursor: pointer;
            transition: background 0.2s;
        }

        .chat-sidebar .sidebar-user.active,
        .chat-sidebar .sidebar-user:hover {
            background: #818cf8;
        }

        .chat-main {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #f4f6fb;
        }

        .chat-header {
            padding: 1.25rem 2rem;
            border-bottom: 1px solid #e2e2e2;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-height: 70px;
        }

        .chat-header .back-button {
            color: #6366f1;
            font-size: 1.3rem;
            text-decoration: none;
        }

        .chat-header .back-button:hover {
            color: #4338ca;
        }

        .chat-header h1 {
            font-size: 1.3rem;
            margin: 0;
            font-weight: 600;
            color: #6366f1;
        }

        .messages-container {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 2rem 0;
            background: url('https://www.transparenttextures.com/patterns/symphony.png');
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .message-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .sent-message,
        .received-message {
            padding: 0.75rem 1.25rem;
            border-radius: 18px;
            max-width: 60vw;
            word-break: break-word;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.07);
            margin-bottom: 0.5rem;
            font-size: 1.05rem;
        }

        .sent-message {
            background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
            color: #fff;
            align-self: flex-end;
        }

        .received-message {
            background: #fff;
            color: #334155;
            align-self: flex-start;
        }

        .message-sender {
            font-size: 0.9rem;
            color: #6366f1;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .message-time {
            font-size: 0.8rem;
            color: #a5b4fc;
            margin-left: 10px;
        }

        .input-container {
            border-top: 1px solid #e2e2e2;
            background: #fff;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control,
        .btn {
            border-radius: 12px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #818cf8 0%, #6366f1 100%);
        }

        .message-container img {
            border-radius: 10px;
            margin-top: 0.5rem;
            cursor: pointer;
            transition: box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.07);
        }

        .message-container img:hover {
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.18);
        }

        .message-video video {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            background-color: #000;
            display: block;
        }

        .file-preview-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .file-preview-wrapper img,
        .file-preview-wrapper video {
            max-width: 120px;
            max-height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .file-preview-wrapper .btn-danger {
            padding: 2px 6px;
            font-size: 0.75rem;
            line-height: 1;
        }

        @media (max-width: 900px) {
            .chat-sidebar {
                display: none;
            }

            .chat-main {
                width: 100vw;
            }
        }

        @media (max-width: 600px) {

            .chat-header,
            .input-container {
                padding: 1rem;
            }

            .messages-container {
                padding: 1rem 0;
            }

            .sent-message,
            .received-message {
                max-width: 90vw;
            }
        }
    </style>
</head>

<body>
    <div class="main-chat-wrapper">
        <!-- Sidebar (optional, can be removed if you want only chat) -->
        {{-- <div class="chat-sidebar d-none d-md-flex flex-column">
            <div class="sidebar-header">
                <i class="fas fa-comments me-2"></i>Chats
            </div> --}}
        {{-- <div class="sidebar-user active">
                
                @if (auth()->user()->isBreeder())
                @foreach ($user as $us)
                <i class="fas fa-user-circle me-2"></i>
                    {{ $us->name }}
                @endforeach
                    
                @else
                    Admin
                @endif
            </div> --}}
        {{-- <div class="sidebar-user-list">
                @if (auth()->user()->isBreeder())
                    @foreach ($user as $us)
                        @if ($us->id !== auth()->id())
                            <a href="#" class="sidebar-user {{ isset($receiver) && $receiver->id == $us->id ? 'active' : '' }}">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ $us->name }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="sidebar-user active">
                        <i class="fas fa-user-circle me-2"></i>
                        Davepoodles
                    </div>
                @endif
            </div> --}}
        <!-- Add more users/conversations here if needed -->
        {{-- </div> --}}
        <!-- Chat Main Area -->
        <div class="chat-main">
            <!-- Chat Header -->
            <div class="chat-header">
                @auth
                    @if (auth()->user()->isBreeder())
                        <a href="{{ route('dashboard') }}" class="back-button" aria-label="Back to dashboard">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @else
                        <a href="/" class="back-button" aria-label="Back to welcome">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                @else
                    <a href="{{ url('/') }}" class="back-button" aria-label="Go home">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                @endauth
                <h1 class="mb-0 ms-2">
                    @if (auth()->user()->isBreeder())
                        {{ $receiver->name }}
                    @else
                        Davepoodles
                    @endif
                </h1>
            </div>
            <!-- Messages Container -->
            <div class="messages-container" id="messages-container">
                @foreach ($messages as $message)
                    <div class="message-container" data-message-id="{{ $message->id }}">
                        @if ($message->sender_id != Auth::id())
                            <div class="message-sender">
                                {{ $message->sender_id == $receiver->id ? $receiver->name : 'Unknown' }}
                            </div>
                        @endif
                        <div class="{{ $message->sender_id == Auth::id() ? 'sent-message' : 'received-message' }}">
                            @if ($message->message)
                                <div class="message-text">{{ $message->message }}</div>
                            @endif
                            @if ($message->file_path && Str::startsWith($message->file_type, 'image/'))
                                <div>
                                    <a href="{{ asset($message->file_path) }}" target="_blank">
                                        <img src="{{ asset($message->file_path) }}" alt="Image"
                                            style="max-width:220px;max-height:220px;">
                                    </a>
                                </div>
                            @endif
                            @if ($message->file_path && Str::startsWith($message->file_type, 'application/'))
                                <div>
                                    <a href="{{ asset($message->file_path) }}" target="_blank">
                                        <i class="fas fa-file-alt"></i> {{ $message->file_name ?? 'Document' }}
                                    </a>
                                </div>
                            @endif
                            @if ($message->file_path && Str::startsWith($message->file_type, 'video/'))
                                <div class="message-video mt-2">
                                    <video controls width="220" height="150"
                                        style="max-width: 100%; border-radius: 8px;">
                                        <source src="{{ asset($message->file_path) }}"
                                            type="{{ $message->file_type }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                            <span class="message-time">
                                {{ $message->created_at->format('h:i A') }}
                                @if ($message->sender_id == Auth::id())
                                    <i class="fas fa-check-double ms-1"></i>
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Input Container -->
            <div class="input-container">
                <form id="message-form" method="POST" action="{{ route('chat.send') }}"
                    class="flex-grow-1 d-flex align-items-center" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <input type="text" name="message" id="message-input" class="form-control me-2"
                        placeholder="Type a message" aria-label="Type your message">
                    <input type="file" name="file" id="file-input"
                        accept="
                                image/*,
                                video/mp4,
                                video/webm,
                                video/ogg,
                                application/pdf,
                                application/msword,
                                application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                application/vnd.ms-excel,
                                application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                            "
                        style="display:none;">
                    <div id="file-preview-container" class="d-flex align-items-center mt-2" style="display: none;">
                    </div>

                    <button type="button" class="btn btn-light me-2" id="attach-btn" title="Attach file">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <button type="submit" id="send-btn" class="btn btn-primary" aria-label="Send message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <!-- File Preview Container -->
                {{-- <img id="image-preview" src="" alt="Image Preview"
                    style="display:none;max-width:120px;max-height:120px;margin-left:10px;">
                <span id="file-name-preview" style="display:none;margin-left:10px;"></span> --}}
            </div>
        </div>
    </div>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const $fileInput = $('#file-input');
            const $fileNamePreview = $('#file-name-preview');
            const $imagePreview = $('#image-preview');
            const $filePreviewContainer = $('#file-preview-container');

            // Trigger file input when attach button is clicked
            $('#attach-btn').on('click', function() {
                $fileInput.click();
            });

            // Handle file selection
            $fileInput.on('change', function(e) {
                const file = e.target.files[0];
                $filePreviewContainer.empty().hide();

                if (!file) return;

                const fileName = file.name;
                const fileType = file.type;

                const removeIcon = `
                <button type="button" id="remove-file" class="btn btn-sm btn-danger ms-2" title="Remove file">
                    <i class="fas fa-times"></i>
                </button>
            `;

                // Image Preview
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const html = `
                        <img src="${ev.target.result}" alt="Image Preview" id="image-preview"
                            style="max-width:120px; max-height:120px; border-radius: 8px;">
                        ${removeIcon}
                    `;
                        $filePreviewContainer.html(html).show();
                    };
                    reader.readAsDataURL(file);
                }
                // Video Preview
                else if (fileType.startsWith('video/')) {
                    const videoURL = URL.createObjectURL(file);
                    const html = `
                    <div class="position-relative">
                        <video controls width="120" height="90" style="border-radius: 8px;">
                            <source src="${videoURL}" type="${fileType}">
                            Your browser does not support the video tag.
                        </video>
                        ${removeIcon}
                    </div>
                `;
                    $filePreviewContainer.html(html).show();
                }
                // Document Preview (PDF, Word, Excel)
                else if (
                    [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ].includes(fileType)
                ) {
                    const icon = fileType.startsWith('application/pdf') ? 'fa-file-pdf' :
                        fileType.includes('word') ? 'fa-file-word' : 'fa-file-excel';

                    const html = `
                    <div class="d-flex align-items-center bg-light p-2 rounded shadow-sm">
                        <i class="fas ${icon} fa-2x text-danger"></i>
                        <span class="ms-2 small">${fileName}</span>
                        ${removeIcon}
                    </div>
                `;
                    $filePreviewContainer.html(html).show();
                }
                // Other file types
                else {
                    const html = `
                    <div class="d-flex align-items-center bg-light p-2 rounded shadow-sm">
                        <i class="fas fa-file-alt fa-2x text-muted"></i>
                        <span class="ms-2 small">${fileName}</span>
                        ${removeIcon}
                    </div>
                `;
                    $filePreviewContainer.html(html).show();
                }

                // Remove file handler
                $(document).on('click', '#remove-file', function() {
                    $fileInput.val('');
                    $filePreviewContainer.hide().empty(); // hide + clear content
                });

            });

            // Optional: Clear preview on form submit
            $('#message-form').on('submit', function() {
                $filePreviewContainer.hide();
            });
        });
    </script>
    <script>
        $(function() {
            // File preview
            // $('#attach-btn').on('click', function() {
            //     $('#file-input').click();
            // });
            // $('#file-input').on('change', function(e) {
            //     const file = e.target.files[0];
            //     const $imagePreview = $('#image-preview');
            //     const $fileNamePreview = $('#file-name-preview');
            //     if (file) {
            //         if (file.type.startsWith('image/')) {
            //             const reader = new FileReader();
            //             reader.onload = function(ev) {
            //                 $imagePreview.attr('src', ev.target.result).show();
            //                 $fileNamePreview.hide();
            //             };
            //             reader.readAsDataURL(file);
            //         } else {
            //             $imagePreview.hide().attr('src', '');
            //             $fileNamePreview.text(file.name).show();
            //         }
            //     } else {
            //         $imagePreview.hide().attr('src', '');
            //         $fileNamePreview.hide().text('');
            //     }
            // });

            // Real-time message receiving (Laravel Echo)
            if (typeof window.Echo !== 'undefined') {
                window.Echo.private('user.' + {{ auth()->id() }})
                    .listen('.ChatMessageSent', function(message) {
                        // Prevent duplicate rendering if message already exists
                        if ($(`[data-message-id="${message.id}"]`).length) return;

                        let fileHtml = '';
                        if (message.file_path && message.file_type?.startsWith('image/')) {
                            fileHtml = `
                    <div>
                        <a href="/${message.file_path}" target="_blank">
                            <img src="/${message.file_path}" alt="Image" style="max-width:220px;max-height:220px;">
                        </a>
                    </div>
                `;
                        } else if (message.file_path && message.file_type?.startsWith('application/')) {
                            fileHtml = `
                    <div>
                        <a href="/${message.file_path}" target="_blank">
                            <i class="fas fa-file-alt"></i> ${message.file_name || 'Document'}
                        </a>
                    </div>
                `;
                        } else if (message.file_type?.startsWith('video/')) {
                            // Video player
                            fileHtml = `
            <div class="message-video mt-2">
                <video controls width="220" height="150" style="max-width: 100%; border-radius: 8px;">
                    <source src="/${message.file_path}" type="${message.file_type}">
                    Your browser does not support the video tag.
                </video>
            </div>
        `;
                        }

                        const isCurrentUser = message.sender_id == {{ auth()->id() }};
                        const messageClass = isCurrentUser ? 'sent-message' : 'received-message';
                        const senderName = isCurrentUser ? 'You' : (message.sender?.name || 'User');
                        const time = message.created_at ?
                            new Date(message.created_at).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) :
                            '';

                        const html = `
                ${!isCurrentUser ? `<div class="message-sender">${senderName}</div>` : ''}
                <div class="${messageClass}">
                    ${message.message ? `<div class="message-text">${message.message}</div>` : ''}
                    ${fileHtml}
                    <span class="message-time">
                        ${time}
                        ${isCurrentUser ? '<i class="fas fa-check-double ms-1"></i>' : ''}
                    </span>
                </div>
            `;

                        $('#messages-container').append(
                            $('<div>')
                            .addClass('message-container')
                            .attr('data-message-id', message.id)
                            .html(html)
                        );

                        $('#messages-container').scrollTop($('#messages-container')[0].scrollHeight);
                    });
            }


            // Scroll to bottom on load
            $('#messages-container').scrollTop($('#messages-container')[0].scrollHeight);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
