@extends('layouts.admin')
@section('admin')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">User Questions & Answers</h3>
                    <div class="float-right">
                        <span id="totalUnreadBadge" class="badge badge-danger">
                            Total Unread Messages: {{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- User List -->
                    @foreach ($users as $user)
                        @php
                            // Get relations for the user
                            $unreadCount = auth()->user()->unreadMessagesFrom($user)->count();
                            $latestMessage = $user->sentMessagesTo(auth()->user())->latest()->first();
                            $userSubmissions = $user->submissions;
                            $conversations = $user->conversations;
                        @endphp
                        <div class="user-card mb-3 p-3 border rounded d-flex justify-content-between align-items-center" data-user-id="{{ $user->id }}">
                            <div>
                                <div class="user-name font-weight-bold">
                                    {{ $user->name }}
                                    @if($unreadCount > 0)
                                        <span class="unread-badge badge badge-danger ml-2" data-user-id="{{ $user->id }}">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $user->email }}</small>
                                
                                <!-- User Profile Info -->
                                @if($user->profile)
                                <div class="user-profile mt-2 small">
                                    <span class="text-muted">
                                        <i class="fas fa-phone"></i> {{ $user->profile->phone ?? 'N/A' }} | 
                                        <i class="fas fa-map-marker-alt"></i> {{ $user->profile->location ?? 'N/A' }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Display latest message preview -->
                                @if($latestMessage)
                                    <div class="latest-message mt-2 small text-muted">
                                        <strong>Latest: </strong>{{ Str::limit($latestMessage->content, 50) }}
                                        <span class="text-muted float-right">{{ $latestMessage->created_at->format('M j, H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <!-- Button to open answers modal -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#answerModal{{ $user->id }}">
                                    <i class="fas fa-comment-alt"></i> View Answers
                                </button>
                                
                                <!-- Chat Button -->
                                @if($userSubmissions->isNotEmpty())
                                    @foreach($userSubmissions->unique('puppy_id') as $submission)
                                        <form action="{{ route('conversation.store') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="breeder_id" value="{{ $submission->breeder_id }}">
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="puppy_id" value="{{ $submission->puppy_id }}">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-comments"></i> Chat ({{ $submission->puppy->name ?? 'Unknown' }})
                                            </button>
                                        </form>
                                    @endforeach
                                @else
                                    <form action="{{ route('conversation.store') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="breeder_id" value="{{ auth()->id() }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-comments"></i> Start Chat
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- View Profile Button -->
                                @if($user->profile)
                                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Modal for Each User's Answers -->
                        <div class="modal fade" id="answerModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="answerModalLabel{{ $user->id }}">
                                            <i class="fas fa-user"></i> {{ $user->name }}'s Answers
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="user-info mb-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                                    @if($user->profile)
                                                    <p><strong>Phone:</strong> {{ $user->profile->phone ?? 'N/A' }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($user->profile)
                                                    <p><strong>Location:</strong> {{ $user->profile->location ?? 'N/A' }}</p>
                                                    <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="mb-3">Questionnaire Answers</h5>
                                        @foreach ($questions as $question)
                                            <div class="card mb-3">
                                                <div class="card-header bg-light">
                                                    <strong>{{ $question->question }}</strong>
                                                </div>
                                                <div class="card-body">
                                                    @php
                                                        $answers = $user->submissions->where('question_id', $question->id);
                                                    @endphp
                                                    @if ($answers->isEmpty())
                                                        <div class="text-muted">No answer submitted.</div>
                                                    @else
                                                        @foreach ($answers as $answer)
                                                            @if ($answer->file_path)
                                                                @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $answer->file_path))
                                                                    <img src="{{ asset($answer->file_path) }}" class="img-fluid mb-2" style="max-height: 200px;">
                                                                @else
                                                                    <a href="{{ asset($answer->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-download"></i> Download File
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <div class="answer">{{ $answer->answer ?? 'No text answer' }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
@vite(['resources/js/app.js'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUserId = {{ auth()->id() }};

    // Debugging: Log window.Echo to ensure it's initialized
    console.log('Echo instance:', window.Echo);

    // Listen for real-time events on a private channel
    if (typeof window.Echo !== 'undefined') {
        window.Echo.private(`user.${currentUserId}`)
            .listen('.ChatMessageSent', (data) => {
                console.log('ChatMessageSent event received:', data);

                // Update unread message count for specific user
                updateUserUnreadCount(data.sender_id, 1);
                
                // Update total unread count
                updateTotalUnreadCount(1);

                // Update latest message preview
                updateLatestMessage(data.sender_id, data);
            });
    }

    // Function to update unread message count for a specific user
    function updateUserUnreadCount(userId, change) {
        const userCard = document.querySelector(`.user-card[data-user-id="${userId}"]`);
        if (!userCard) {
            console.error(`User card not found for user ID: ${userId}`);
            return;
        }

        let userNameElement = userCard.querySelector('.user-name');
        let badgeElement = userCard.querySelector('.unread-badge[data-user-id="' + userId + '"]');
        let currentCount = badgeElement ? parseInt(badgeElement.innerText) || 0 : 0;
        let newCount = Math.max(0, currentCount + change);

        if (newCount > 0) {
            if (!badgeElement) {
                badgeElement = document.createElement('span');
                badgeElement.className = 'unread-badge badge badge-danger ml-2';
                badgeElement.setAttribute('data-user-id', userId);
                badgeElement.innerText = newCount;
                userNameElement.appendChild(badgeElement);
            } else {
                badgeElement.innerText = newCount;
            }
        } else if (badgeElement) {
            badgeElement.remove();
        }

        console.log(`Updated unread count for user ID ${userId}:`, newCount);
    }

    // Function to update total unread count
    function updateTotalUnreadCount(change) {
        const totalUnreadBadge = document.getElementById('totalUnreadBadge');
        if (!totalUnreadBadge) {
            console.error('Total unread badge not found');
            return;
        }

        // Extract current count from the badge text
        const currentText = totalUnreadBadge.innerText;
        const currentCount = parseInt(currentText.match(/\d+/)[0]) || 0;
        const newCount = Math.max(0, currentCount + change);

        // Update the badge text
        totalUnreadBadge.innerText = `Total Unread Messages: ${newCount}`;

        console.log(`Updated total unread count:`, newCount);
    }

    // Function to update latest message preview
    function updateLatestMessage(userId, messageData) {
        const userCard = document.querySelector(`.user-card[data-user-id="${userId}"]`);
        if (!userCard) {
            console.error(`User card not found for user ID: ${userId}`);
            return;
        }

        // Get or create the message container
        let messageContainer = userCard.querySelector('.latest-message');
        if (!messageContainer) {
            messageContainer = document.createElement('div');
            messageContainer.className = 'latest-message mt-2 small text-muted';
            userCard.querySelector('div > div').appendChild(messageContainer);
        }

        // Format the date
        const messageDate = new Date(messageData.created_at);
        const formattedDate = messageDate.toLocaleString('default', { 
            month: 'short', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        // Update the message content
        const messageContent = messageData.content || messageData.message;
        messageContainer.innerHTML = `
            <strong>Latest: </strong>${messageContent.substring(0, 50)}${messageContent.length > 50 ? '...' : ''}
            <span class="text-muted float-right">${formattedDate}</span>
        `;

        console.log(`Updated latest message for user ID ${userId}:`, messageContent);
    }
});

// Handle marking messages as read when the chat button is clicked
$(document).ready(function () {
    $('.btn-success').on('click', function (e) {
        var form = $(this).closest('form'); // Get the form element
        var userId = form.find('input[name="user_id"]').val(); // Get the user ID

        // Send AJAX request to mark messages as read
        $.ajax({
            url: '/mark-messages-as-read',
            method: 'POST',
            data: {
                user_id: userId,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    // Update the UI to reflect messages are read
                    const badgeElement = document.querySelector(`.unread-badge[data-user-id="${userId}"]`);
                    if (badgeElement) {
                        badgeElement.remove();
                    }
                    
                    // Update total unread count
                    const totalUnreadBadge = document.getElementById('totalUnreadBadge');
                    if (totalUnreadBadge) {
                        const currentText = totalUnreadBadge.innerText;
                        const currentCount = parseInt(currentText.match(/\d+/)[0]) || 0;
                        const unreadCount = parseInt(badgeElement ? badgeElement.innerText : 0);
                        const newCount = Math.max(0, currentCount - unreadCount);
                        totalUnreadBadge.innerText = `Total Unread Messages: ${newCount}`;
                    }

                    // Submit the form after marking messages as read
                    form.unbind('submit').submit();
                }
            },
            error: function (error) {
                console.error('Error marking messages as read:', error);
            }
        });
    });
});
</script>
@endsection