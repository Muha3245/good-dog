<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Conversations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <style>
        :root {
            --light-bg: #ffffff;
            --lighter-bg: #f9f9f9;
            --red-accent: #d32f2f;
            --dark-text: #333333;
            --light-black: #555555;
            --gray-border: #e0e0e0;
            --card-bg: #ffffff;
            --unread-badge: #d32f2f;
        }
        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .conversations-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--red-accent);
        }
        .header h1 {
            color: var(--red-accent);
            margin-bottom: 5px;
        }
        .conversations-list {
            display: grid;
            gap: 20px;
        }
        .conversation-card {
            background-color: var(--card-bg);
            border: 1px solid var(--gray-border);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .conversation-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.1);
            border-left: 3px solid var(--red-accent);
        }
        .conversation-header {
            background-color: var(--lighter-bg);
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .conversation-id {
            color: var(--red-accent);
            font-weight: bold;
        }
        .conversation-user {
            font-style: italic;
            color: var(--light-black);
            position: relative;
        }
        .conversation-body {
            padding: 20px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--gray-border);
        }
        .detail-label {
            color: var(--red-accent);
            font-weight: bold;
            width: 150px;
        }
        .no-conversations {
            text-align: center;
            padding: 40px;
            color: var(--light-black);
            font-size: 1.2rem;
            border: 1px dashed var(--gray-border);
            border-radius: 8px;
            background-color: var(--lighter-bg);
        }
        .unread-count {
            background-color: var(--unread-badge);
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        .latest-message {
            color: var(--light-black);
            font-size: 0.9rem;
            margin-top: 10px;
            padding: 8px;
            background-color: var(--lighter-bg);
            border-radius: 4px;
            border-left: 3px solid var(--red-accent);
        }
        .message-preview {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="conversations-container">
        <div class="header">
            <h1>Your Conversations</h1>
            <p style="color: var(--light-black);">All active conversations</p>
        </div>
        <div class="conversations-list">
            @forelse($conversations as $conversation)
                @php
                    $unreadCount = auth()->user()->receivedMessages()
                        ->where('conversation_id', $conversation->id)
                        ->where('is_read', 0)
                        ->count();
                    $latestMessage = $conversation->messages()->latest()->first();
                @endphp
                <div class="conversation-card" data-conversation-id="{{ $conversation->id }}">
                    <div class="conversation-header">
                        <span class="conversation-id">Conversation #{{ $conversation->id }}</span>
                        <a href="{{ route('chat.show', ['conversation' => $conversation->id]) }}">
                            <span class="conversation-user">
                                <i class="fas fa-comments me-2"></i>With: Admin
                                @if ($unreadCount > 0)
                                    <span id="unread-count-{{ $conversation->id }}" class="unread-count">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    </div>
                    <div class="conversation-body">
                        <div class="detail-row">
                            <span class="detail-label">Started On:</span>
                            <span>{{ $conversation->created_at->format('F j, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Started At:</span>
                            <span>{{ $conversation->created_at->format('g:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Last Updated:</span>
                            <span id="last-updated-{{ $conversation->id }}">{{ $conversation->updated_at->diffForHumans() }}</span>
                        </div>
                        @if ($latestMessage)
                            <div class="latest-message" id="latest-message-{{ $conversation->id }}">
                                <strong>Latest: </strong>
                                <span class="message-preview">{{ Str::limit($latestMessage->content, 50) }}</span>
                                <span class="message-time" style="float: right; color: var(--light-black);">
                                    {{ $latestMessage->created_at->format('M j, H:i') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-conversations">
                    <p>You are not currently in any conversations</p>
                    <p><small>Start a new conversation to begin chatting</small></p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentUserId = {{ auth()->id() }};
            console.log('Echo instance:', window.Echo);

            if (typeof window.Echo !== 'undefined') {
                window.Echo.private(`user.${currentUserId}`)
                    .listen('.ChatMessageSent', (data) => {
                        console.log('ChatMessageSent event received:', data);
                        const conversationId = data.conversation_id || (data.message && data.message.conversation_id);
                        if (!conversationId) return;

                        const receiverId = data.receiver_id || (data.message && data.message.receiver_id);
                        const messageContent = data.message?.content || data.content;
                        const messageCreatedAt = data.created_at || (data.message && data.message.created_at);

                        const conversationCard = document.querySelector(
                            `.conversation-card[data-conversation-id="${conversationId}"]`
                        );
                        if (!conversationCard) return;

                        if (receiverId == currentUserId) {
                            updateUnreadCount(conversationId, 1);
                        }

                        const message = {
                            content: messageContent,
                            created_at: messageCreatedAt
                        };

                        updateLatestMessage(conversationId, message);
                        updateLastUpdated(conversationId);
                    });
            }

            function updateUnreadCount(conversationId, change) {
                const conversationCard = document.querySelector(
                    `.conversation-card[data-conversation-id="${conversationId}"]`);
                if (!conversationCard) return;

                let unreadBadge = conversationCard.querySelector(`#unread-count-${conversationId}`);
                let currentCount = unreadBadge ? parseInt(unreadBadge.innerText) || 0 : 0;
                let newCount = Math.max(0, currentCount + change);

                if (newCount > 0) {
                    if (!unreadBadge) {
                        const userSpan = conversationCard.querySelector('.conversation-user');
                        unreadBadge = document.createElement('span');
                        unreadBadge.className = 'unread-count';
                        unreadBadge.id = `unread-count-${conversationId}`;
                        unreadBadge.innerText = newCount;
                        userSpan.appendChild(unreadBadge);
                    } else {
                        unreadBadge.innerText = newCount;
                    }
                } else if (unreadBadge) {
                    unreadBadge.remove();
                }
            }

            function updateLatestMessage(conversationId, message) {
                const conversationCard = document.querySelector(
                    `.conversation-card[data-conversation-id="${conversationId}"]`);
                if (!conversationCard) return;

                let latestMessageDiv = conversationCard.querySelector(`#latest-message-${conversationId}`);
                const messageDate = new Date(message.created_at);
                const formattedDate = messageDate.toLocaleString('default', {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                if (!latestMessageDiv) {
                    const conversationBody = conversationCard.querySelector('.conversation-body');
                    latestMessageDiv = document.createElement('div');
                    latestMessageDiv.className = 'latest-message';
                    latestMessageDiv.id = `latest-message-${conversationId}`;
                    conversationBody.appendChild(latestMessageDiv);
                }

                latestMessageDiv.innerHTML = `
                    <strong>Latest: </strong>
                    <span class="message-preview">${message.content.substring(0, 50)}${message.content.length > 50 ? '...' : ''}</span>
                    <span class="message-time" style="float: right; color: var(--light-black);">
                        ${formattedDate}
                    </span>
                `;
            }

            function updateLastUpdated(conversationId) {
                const lastUpdatedSpan = document.querySelector(`#last-updated-${conversationId}`);
                if (lastUpdatedSpan) {
                    lastUpdatedSpan.innerText = 'Just now';
                }
            }

            $(document).ready(function () {
                $('.conversation-header a').on('click', function (e) {
                    const conversationCard = $(this).closest('.conversation-card');
                    const conversationId = conversationCard.data('conversation-id');

                    $.ajax({
                        url: '/mark-read',
                        method: 'POST',
                        data: {
                            conversation_id: conversationId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                conversationCard.find(`#unread-count-${conversationId}`).remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error marking messages as read:', error);
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>