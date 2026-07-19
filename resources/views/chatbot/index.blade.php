<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Asisten RT - Tanya Jawab Administrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .chatbot-container {
            width: 100%;
            max-width: 500px;
            height: 90vh;
            max-height: 700px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
            color: #2d4a3f;
            padding: 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .chat-header h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .chat-header p {
            font-size: 12px;
            opacity: 0.9;
            margin: 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            display: flex;
            margin-bottom: 10px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            justify-content: flex-end;
        }

        .message.bot {
            justify-content: flex-start;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 12px;
            max-width: 80%;
            word-wrap: break-word;
            font-size: 14px;
            line-height: 1.5;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
            color: #2d4a3f;
            border-radius: 18px 18px 4px 18px;
        }

        .message.bot .message-content {
            background: #f0f0f0;
            color: #333;
            border-radius: 18px 18px 18px 4px;
        }

        .typing-indicator {
            display: flex;
            gap: 5px;
            align-items: center;
            padding: 12px 16px;
            background: #f0f0f0;
            border-radius: 18px 18px 18px 4px;
            width: fit-content;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #999;
            animation: bounce 1.4s infinite;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 60%, 100% {
                opacity: 0.3;
                transform: translateY(0);
            }
            30% {
                opacity: 1;
                transform: translateY(-10px);
            }
        }

        .chat-input-area {
            padding: 15px;
            border-top: 1px solid #eee;
            background: white;
            display: flex;
            gap: 10px;
        }

        .input-group {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .input-group input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px 15px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #b8d4c8;
            box-shadow: 0 0 0 3px rgba(184, 212, 200, 0.2);
        }

        .input-group button {
            background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
            border: none;
            color: #2d4a3f;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .input-group button:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(184, 212, 200, 0.4);
        }

        .input-group button:active {
            transform: scale(0.95);
        }

        .input-group button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
            text-align: center;
            padding: 20px;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .empty-state p {
            font-size: 13px;
            margin: 0;
        }

        .suggested-questions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 15px;
        }

        .suggested-questions button {
            padding: 8px 12px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            color: #333;
        }

        .suggested-questions button:hover {
            background: #b8d4c8;
            color: #2d4a3f;
            border-color: #b8d4c8;
        }

        .chat-header .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .chat-header button {
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-header button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        .timestamp {
            font-size: 11px;
            color: #999;
            text-align: center;
            margin: 10px 0;
        }

        @media (max-width: 600px) {
            .chatbot-container {
                max-width: 100%;
                height: 100vh;
                max-height: none;
                border-radius: 0;
            }

            .message-content {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="chatbot-container">
        <!-- Header -->
        <div class="chat-header">
            <h2>
                <i class="bi bi-chat-dots"></i> Asisten RT
            </h2>
            <p>Tanya jawab administrasi RT 24/7</p>
            <div class="action-buttons">
                <button id="clear-btn" title="Hapus percakapan">
                    <i class="bi bi-trash"></i> Bersihkan
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div class="chat-messages" id="chat-messages">
            <div class="empty-state">
                <i class="bi bi-chat-left-dots"></i>
                <h3>Mulai Percakapan</h3>
                <p>Tanyakan tentang persyaratan surat, prosedur administrasi, dan jadwal pelayanan RT</p>
                
                <div class="suggested-questions">
                    <button class="suggested-btn" data-question="Apa persyaratan untuk membuat surat keterangan?">
                        Persyaratan surat keterangan
                    </button>
                    <button class="suggested-btn" data-question="Berapa lama proses pembuatan surat?">
                        Durasi pembuatan surat
                    </button>
                    <button class="suggested-btn" data-question="Jam pelayanan RT berapa saja?">
                        Jadwal pelayanan RT
                    </button>
                    <button class="suggested-btn" data-question="Bagaimana cara membuat laporan ke RT?">
                        Cara membuat laporan
                    </button>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="chat-input-area">
            <div class="input-group">
                <input 
                    type="text" 
                    id="message-input" 
                    placeholder="Ketik pertanyaan Anda..." 
                    autocomplete="off"
                />
                <button id="send-btn" type="button">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const clearBtn = document.getElementById('clear-btn');
        let sessionId = localStorage.getItem('chatbot_session_id') || generateSessionId();
        let isLoading = false;

        // Generate session ID
        function generateSessionId() {
            const id = 'session_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('chatbot_session_id', id);
            return id;
        }

        // Load previous conversation
        loadConversation();

        // Send message
        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message || isLoading) return;

            // Add user message
            addMessage('user', message);
            messageInput.value = '';

            // Show typing indicator
            showTypingIndicator();
            isLoading = true;
            sendBtn.disabled = true;

            // Send to backend
            fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    message: message,
                    session_id: sessionId
                })
            })
            .then(response => response.json())
            .then(data => {
                removeTypingIndicator();
                if (data.success) {
                    addMessage('bot', data.message);
                } else {
                    addMessage('bot', data.message || 'Terjadi kesalahan, silakan coba lagi.');
                }
            })
            .catch(error => {
                removeTypingIndicator();
                addMessage('bot', 'Maaf, terjadi kesalahan dalam menghubungi server.');
                console.error('Error:', error);
            })
            .finally(() => {
                isLoading = false;
                sendBtn.disabled = false;
                messageInput.focus();
            });
        }

        // Add message to chat
        function addMessage(role, content) {
            // Remove empty state if exists
            const emptyState = chatMessages.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const messageEl = document.createElement('div');
            messageEl.className = `message ${role}`;
            messageEl.innerHTML = `<div class="message-content">${escapeHtml(content)}</div>`;
            chatMessages.appendChild(messageEl);
            scrollToBottom();
        }

        // Show typing indicator
        function showTypingIndicator() {
            const messageEl = document.createElement('div');
            messageEl.className = 'message bot';
            messageEl.id = 'typing-indicator';
            messageEl.innerHTML = `
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatMessages.appendChild(messageEl);
            scrollToBottom();
        }

        // Remove typing indicator
        function removeTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                indicator.remove();
            }
        }

        // Scroll to bottom
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Load conversation
        function loadConversation() {
            fetch(`{{ route("chatbot.get") }}?session_id=${sessionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages && data.messages.length > 0) {
                        // Clear empty state
                        const emptyState = chatMessages.querySelector('.empty-state');
                        if (emptyState) {
                            emptyState.remove();
                        }
                        
                        // Load messages
                        data.messages.forEach(msg => {
                            addMessage(msg.role, msg.content);
                        });
                    }
                })
                .catch(error => console.error('Error loading conversation:', error));
        }

        // Clear conversation
        clearBtn.addEventListener('click', () => {
            if (confirm('Yakin ingin menghapus percakapan?')) {
                fetch('{{ route("chatbot.clear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ session_id: sessionId })
                })
                .then(() => {
                    chatMessages.innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-chat-left-dots"></i>
                            <h3>Mulai Percakapan</h3>
                            <p>Tanyakan tentang persyaratan surat, prosedur administrasi, dan jadwal pelayanan RT</p>
                            
                            <div class="suggested-questions">
                                <button class="suggested-btn" data-question="Apa persyaratan untuk membuat surat keterangan?">
                                    Persyaratan surat keterangan
                                </button>
                                <button class="suggested-btn" data-question="Berapa lama proses pembuatan surat?">
                                    Durasi pembuatan surat
                                </button>
                                <button class="suggested-btn" data-question="Jam pelayanan RT berapa saja?">
                                    Jadwal pelayanan RT
                                </button>
                                <button class="suggested-btn" data-question="Bagaimana cara membuat laporan ke RT?">
                                    Cara membuat laporan
                                </button>
                            </div>
                        </div>
                    `;
                    attachSuggestedButtonListeners();
                })
                .catch(error => console.error('Error clearing conversation:', error));
            }
        });

        // Suggested questions
        function attachSuggestedButtonListeners() {
            document.querySelectorAll('.suggested-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    messageInput.value = btn.dataset.question;
                    sendMessage();
                });
            });
        }

        // Event listeners
        sendBtn.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Initial setup
        attachSuggestedButtonListeners();
        messageInput.focus();

        // Escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
    </script>

    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>
