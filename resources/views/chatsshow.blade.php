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
        :root {
            --primary-color: #075e54;
            --secondary-color: #128c7e;
            --sent-message-color: #dcf8c6;
            --received-message-color: #ffffff;
            --background-color: #e5ddd5;
            --text-color: #333333;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100%;
            background-color: white;
        }

        .chat-header {
            background-color: black;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .chat-header .back-button {
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: rgb(247, 246, 246);
        }

        .message-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .sent-message {
            background-color: var(--sent-message-color);
            color: var(--text-color);
            border-radius: 18px 18px 0 18px;
            padding: 10px 15px;
            margin-left: auto;
            max-width: 75%;
            position: relative;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .received-message {
            background-color: var(--received-message-color);
            border-radius: 18px 18px 18px 0;
            padding: 10px 15px;
            margin-right: auto;
            max-width: 75%;
            position: relative;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .message-time {
            display: block;
            text-align: right;
            font-size: 0.75rem;
            color: #667781;
            margin-top: 5px;
        }

        .message-sender {
            font-size: 0.8rem;
            color: var(--primary-color);
            margin-bottom: 3px;
            font-weight: 500;
        }

        .input-container {
            background-color: #f0f0f0;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            position: sticky;
            bottom: 0;
        }

        .message-input {
            flex: 1;
            border-radius: 20px;
            padding: 10px 15px;
            border: none;
            outline: none;
            background-color: white;
            margin-right: 10px;
        }

        .send-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .send-button:hover {
            background-color: var(--secondary-color);
        }

        /* Search Header Styles */
        .search-header {
            display: none;
            /* Hidden by default */
            background-color: black;
            color: white;
            padding: 10px 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            align-items: center;
        }

        .search-header .back-button {
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
            text-decoration: none;
        }

        .search-header input {
            flex: 1;
            padding: 8px 15px;
            border: none;
            border-radius: 20px;
            outline: none;
            font-size: 1rem;
            background-color: white;
            color: var(--text-color);
        }

        .search-header .search-controls {
            display: flex;
            align-items: center;
            margin-left: 10px;
            color: white;
        }

        .search-header .search-controls .match-count {
            font-size: 0.8rem;
            margin: 0 10px;
        }

        .search-header .search-controls button {
            background: none;
            border: none;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            padding: 5px;
        }

        .search-header .search-controls button:disabled {
            opacity: 0.5;
            cursor: default;
        }

        .highlight {
            background-color: yellow;
            font-weight: bold;
        }

        .hidden {
            display: none !important;
        }

        @media (max-width: 576px) {

            .sent-message,
            .received-message {
                max-width: 85%;
            }
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header" id="chat-header">
            <div class="d-flex align-items-center">
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
                <h1 class="h5 mb-0">
                    @if (auth()->user()->isBreeder())
                        {{ $receiver->name }}
                    @else
                        Admin
                    @endif
                </h1>

            </div>
            <div class="search-icon">
                <i class="fas fa-search" id="search-icon" aria-label="Open search" style="cursor: pointer"></i>
            </div>
        </div>
        <!-- Search Header (replaces chat header when searching) -->
        <div class="search-header" id="search-header">
            <a href="#" class="back-button" id="close-search" aria-label="Close search">
                <i class="fas fa-arrow-left"></i>
            </a>
            <input type="text" id="search-input" placeholder="Search messages..." aria-label="Search messages">
            <div class="search-controls">
                <button id="prev-match" aria-label="Previous match" disabled>
                    <i class="fas fa-chevron-up"></i>
                </button>
                <span class="match-count" id="match-count">0/0</span>
                <button id="next-match" aria-label="Next match" disabled>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        <!-- Messages Container -->
        <div class="messages-container" id="messages-container">
            @foreach ($messages as $message)
                <div class="message-container" data-message-id="{{ $message->id }}">
                    @if ($message->sender_id != Auth::id())
                        <div class="message-sender">
                            {{ $message->sender_id == $receiver->id ? $receiver->name : 'Unknown' }}</div>
                    @endif
                    <div class="{{ $message->sender_id == Auth::id() ? 'sent-message' : 'received-message' }}">
                        <div class="message-text">{{ $message->message }}</div>
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
                class="d-flex w-100 align-items-center">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <input type="text" name="message" id="message-input" class="message-input"
                    placeholder="Type a message" aria-label="Type your message" required>
                <button type="submit" id="send-btn" class="send-button" aria-label="Send message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const conversationId = {{ $conversation->id }};
            const currentUserId = {{ Auth::id() }};
            const receiverId = {{ $receiver->id }};
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const chatHeader = document.getElementById('chat-header');
            const searchHeader = document.getElementById('search-header');
            const searchInput = document.getElementById('search-input');
            const searchIcon = document.getElementById('search-icon');
            const closeSearch = document.getElementById('close-search');
            const prevMatchButton = document.getElementById('prev-match');
            const nextMatchButton = document.getElementById('next-match');
            const matchCount = document.getElementById('match-count');
            let currentMatchIndex = -1;
            let highlightedElements = [];

            // Back button functionality
            // const backButton = document.getElementById('back-button');
            // backButton.addEventListener('click', function(e) {
            //     e.preventDefault();
            //     window.history.back(); // Navigate to the previous page
            // });

            // Subscribe to conversation channel only
            window.Echo.channel(`conversation.${conversationId}`)
                .listen('.ChatMessageSent', (data) => handleIncomingMessage(data));

            function handleIncomingMessage(data) {
                const participants = [currentUserId, receiverId].sort();
                const messageParticipants = [data.sender_id, data.receiver_id].sort();
                if (participants[0] !== messageParticipants[0] || participants[1] !== messageParticipants[1]) {
                    console.log('Message not between these users');
                    return;
                }

                appendMessage(data);
                scrollToBottom();
            }

            function appendMessage(message) {
                const isCurrentUser = message.sender_id == currentUserId;
                const existingMessage = document.querySelector(`[data-message-id="${message.id}"]`);
                if (existingMessage) {
                    return; // Do not append duplicate messages
                }

                const messageClass = isCurrentUser ? 'sent-message' : 'received-message';
                const senderName = isCurrentUser ? 'You' : message.sender.name;

                const messageElement = document.createElement('div');
                messageElement.className = 'message-container';
                messageElement.setAttribute('data-message-id', message.id); // Unique identifier
                messageElement.innerHTML = `
                    ${!isCurrentUser ? `<div class="message-sender">${senderName}</div>` : ''}
                    <div class="${messageClass}">
                        <div class="message-text">${message.message}</div>
                        <span class="message-time">
                            ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                            ${isCurrentUser ? '<i class="fas fa-check-double ms-1"></i>' : ''}
                        </span>
                    </div>
                `;
                messagesContainer.appendChild(messageElement);
            }

            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Handle form submission
            messageForm.addEventListener('submit', function(e) {
                // e.preventDefault();

                const formData = new FormData(this);
                const messageInput = this.querySelector('input[name="message"]');

                const tempMessage = {
                    id: 'temp-' + Date.now(),
                    conversation_id: conversationId,
                    sender_id: currentUserId,
                    receiver_id: receiverId,
                    message: messageInput.value,
                    created_at: new Date().toISOString(),
                    sender: {
                        id: currentUserId,
                        name: 'You'
                    },
                    is_temp: true
                };

                appendMessage(tempMessage);
                scrollToBottom();

                messageInput.value = '';

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const tempElement = document.querySelector(
                            `[data-temp-id="${tempMessage.id}"]`);
                        if (tempElement && data.message) {
                            tempElement.remove();
                            appendMessage(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const tempElement = document.querySelector(
                            `[data-temp-id="${tempMessage.id}"]`);
                        if (tempElement) {
                            tempElement.querySelector('.message-text').textContent +=
                                ' (Failed to send)';
                            tempElement.querySelector('.message-text').style.color = 'red';
                        }
                    });
            });

            // Initial scroll to bottom
            scrollToBottom();

            // Search functionality
            searchIcon.addEventListener('click', function() {
                chatHeader.style.display = 'none';
                searchHeader.style.display = 'flex';
                searchInput.focus();
            });

            closeSearch.addEventListener('click', function(e) {
                e.preventDefault();
                resetSearch();
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const messageContainers = document.querySelectorAll('.message-container');

                highlightedElements = [];
                currentMatchIndex = -1;

                messageContainers.forEach(container => {
                    const messageText = container.querySelector('.message-text');
                    const text = messageText.textContent.toLowerCase();

                    if (searchTerm && text.includes(searchTerm)) {
                        container.classList.remove('hidden');
                        highlightText(messageText, searchTerm);
                        highlightedElements.push(container);
                    } else {
                        container.classList.add('hidden');
                        messageText.innerHTML = text; // Reset highlighting
                    }
                });

                updateMatchControls();

                if (highlightedElements.length > 0) {
                    currentMatchIndex = 0;
                    scrollToMatch(currentMatchIndex);
                }
            });

            prevMatchButton.addEventListener('click', function() {
                if (highlightedElements.length === 0) return;
                currentMatchIndex = (currentMatchIndex - 1 + highlightedElements.length) %
                    highlightedElements.length;
                scrollToMatch(currentMatchIndex);
                updateMatchControls();
            });

            nextMatchButton.addEventListener('click', function() {
                if (highlightedElements.length === 0) return;
                currentMatchIndex = (currentMatchIndex + 1) % highlightedElements.length;
                scrollToMatch(currentMatchIndex);
                updateMatchControls();
            });

            function highlightText(element, searchTerm) {
                const text = element.textContent;
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                element.innerHTML = text.replace(regex, '<span class="highlight">$1</span>');
            }

            function scrollToMatch(index) {
                if (highlightedElements.length > 0 && index >= 0 && index < highlightedElements.length) {
                    const targetElement = highlightedElements[index];
                    messagesContainer.scrollTop = targetElement.offsetTop - messagesContainer.offsetTop - 50;
                }
            }

            function updateMatchControls() {
                if (highlightedElements.length > 0) {
                    matchCount.textContent = `${currentMatchIndex + 1}/${highlightedElements.length}`;
                    prevMatchButton.disabled = false;
                    nextMatchButton.disabled = false;
                } else {
                    matchCount.textContent = '0/0';
                    prevMatchButton.disabled = true;
                    nextMatchButton.disabled = true;
                }
            }

            function resetSearch() {
                searchHeader.style.display = 'none';
                chatHeader.style.display = 'flex';
                searchInput.value = '';

                const messageContainers = document.querySelectorAll('.message-container');
                messageContainers.forEach(container => {
                    container.classList.remove('hidden');
                    const messageText = container.querySelector('.message-text');
                    messageText.innerHTML = messageText.textContent;
                });

                highlightedElements = [];
                currentMatchIndex = -1;
                updateMatchControls();
            }
        });
    </script>
</body>

</html>
