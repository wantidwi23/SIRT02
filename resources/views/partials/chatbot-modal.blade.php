<!-- Chatbot Modal Button -->
<button class="chatbot-toggle-btn" id="chatbot-toggle-btn" title="Buka Chatbot">
    <i class="bi bi-chat-dots-fill"></i>
</button>

<!-- Chatbot Modal -->
<div class="chatbot-modal" id="chatbot-modal">
    <!-- Header -->
    <div class="chatbot-modal-header">
        <h3>
            <i class="bi bi-chat-dots"></i> Asisten RT
        </h3>
        <div class="chatbot-modal-actions">
            <button class="chatbot-clear-btn" id="chatbot-clear-btn" title="Hapus percakapan">
                <i class="bi bi-trash"></i>
            </button>
            <button class="chatbot-close-btn" id="chatbot-close-btn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <!-- Messages -->
    <div class="chatbot-messages" id="chatbot-messages">
        <div class="chatbot-empty-state">
            <i class="bi bi-chat-left-dots"></i>
            <h4>Mulai Percakapan</h4>
            <p>Tanyakan tentang persyaratan surat, prosedur administrasi, dan jadwal pelayanan RT</p>
            
            <div class="chatbot-suggested-questions">
                <button class="chatbot-suggested-btn" data-question="Apa persyaratan untuk membuat surat keterangan?">
                    Persyaratan surat keterangan
                </button>
                <button class="chatbot-suggested-btn" data-question="Berapa lama proses pembuatan surat?">
                    Durasi pembuatan surat
                </button>
                <button class="chatbot-suggested-btn" data-question="Jam pelayanan RT berapa saja?">
                    Jadwal pelayanan RT
                </button>
                <button class="chatbot-suggested-btn" data-question="Bagaimana cara membuat laporan ke RT?">
                    Cara membuat laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Input -->
    <div class="chatbot-input-area">
        <div class="chatbot-templates" id="chatbot-templates" aria-hidden="false">
            <button class="chatbot-template-btn" data-q="Bagaimana cara mengajukan surat pengantar KTP?">Pengantar KTP</button>
            <button class="chatbot-template-btn" data-q="Apa persyaratan untuk membuat surat keterangan domisili?">Persyaratan Domisili</button>
            <button class="chatbot-template-btn" data-q="Bagaimana cara mereset password akun?">Reset Password</button>
            <button class="chatbot-template-btn" data-q="Bagaimana cara melaporkan lampu jalan yang rusak?">Laporkan Lampu</button>
        </div>
        <div class="chatbot-input-group">
            <input 
                type="text" 
                id="chatbot-message-input" 
                class="chatbot-input" 
                placeholder="Ketik pertanyaan..." 
                autocomplete="off"
            />
            <button id="chatbot-send-btn" class="chatbot-send-btn" type="button">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Chatbot Toggle Button */
    .chatbot-toggle-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(184, 212, 200, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 999;
    }

    .chatbot-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(184, 212, 200, 0.6);
    }

    .chatbot-toggle-btn.hidden {
        display: none;
    }

    /* Chatbot Modal */
    .chatbot-modal {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 420px;
        height: 600px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
        display: none;
        flex-direction: column;
        z-index: 1000;
        animation: slideUp 0.3s ease-out;
    }

    .chatbot-modal.open {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header */
    .chatbot-modal-header {
        background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
        color: white;
        padding: 16px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbot-modal-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chatbot-modal-actions {
        display: flex;
        gap: 8px;
    }

    .chatbot-clear-btn,
    .chatbot-close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 6px;
        padding: 6px 10px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-clear-btn:hover,
    .chatbot-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Messages Area */
    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chatbot-message {
        display: flex;
        margin-bottom: 8px;
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

    .chatbot-message.user {
        justify-content: flex-end;
    }

    .chatbot-message.bot {
        justify-content: flex-start;
    }

    .chatbot-message-content {
        padding: 10px 14px;
        border-radius: 12px;
        max-width: 75%;
        word-wrap: break-word;
        font-size: 13px;
        line-height: 1.5;
    }

    .chatbot-message.user .chatbot-message-content {
        background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
        color: white;
        border-radius: 16px 16px 4px 16px;
    }

    .chatbot-message.bot .chatbot-message-content {
        background: #f0f0f0;
        color: #333;
        border-radius: 16px 16px 16px 4px;
    }

    /* Typing Indicator */
    .chatbot-typing-indicator {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 10px 14px;
        background: #f0f0f0;
        border-radius: 16px 16px 16px 4px;
        width: fit-content;
    }

    .chatbot-typing-indicator span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #999;
        animation: bounce 1.4s infinite;
    }

    .chatbot-typing-indicator span:nth-child(1) {
        animation-delay: 0s;
    }

    .chatbot-typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .chatbot-typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {
        0%, 60%, 100% {
            opacity: 0.3;
            transform: translateY(0);
        }
        30% {
            opacity: 1;
            transform: translateY(-8px);
        }
    }

    /* Empty State */
    .chatbot-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
        text-align: center;
        padding: 16px;
    }

    .chatbot-empty-state i {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.5;
        color: #999;
    }

    .chatbot-empty-state h4 {
        font-size: 14px;
        margin: 8px 0;
        color: #333;
    }

    .chatbot-empty-state p {
        font-size: 12px;
        margin: 0 0 12px 0;
        color: #999;
    }

    /* Suggested Questions */
    .chatbot-suggested-questions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
        margin-top: 12px;
    }

    .chatbot-suggested-btn {
        padding: 8px 12px;
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
        color: #333;
    }

    .chatbot-suggested-btn:hover {
        background: #b8d4c8;
        color: white;
        border-color: #b8d4c8;
    }

    /* Input Area */
    .chatbot-input-area {
        padding: 12px;
        border-top: 1px solid #eee;
        background: white;
        border-radius: 0 0 12px 12px;
    }

    .chatbot-templates {
        display: flex;
        gap: 8px;
        padding: 8px 12px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 4px solid transparent;
        overflow-x: auto;
    }

    .chatbot-template-btn {
        background: #f5f5f5;
        border: 1px solid #e1e1e1;
        padding: 6px 10px;
        border-radius: 18px;
        font-size: 12px;
        cursor: pointer;
        white-space: nowrap;
    }

    .chatbot-template-btn:hover {
        background: #b8d4c8;
        color: white;
        border-color: #b8d4c8;
    }

    .chatbot-input-group {
        display: flex;
        gap: 8px;
    }

    .chatbot-input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        transition: all 0.3s ease;
    }

    .chatbot-input:focus {
        border-color: #b8d4c8;
        box-shadow: 0 0 0 3px rgba(184, 212, 200, 0.15);
    }

    .chatbot-send-btn {
        background: linear-gradient(135deg, #b8d4c8 0%, #a3b88b 100%);
        border: none;
        color: white;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .chatbot-send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(184, 212, 200, 0.4);
    }

    .chatbot-send-btn:active {
        transform: scale(0.95);
    }

    .chatbot-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Scrollbar styling */
    .chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chatbot-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .chatbot-messages::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    .chatbot-messages::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chatbot-modal {
            width: 100%;
            height: 100%;
            bottom: 0;
            right: 0;
            border-radius: 0;
            max-width: 100%;
        }

        .chatbot-toggle-btn {
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .chatbot-message-content {
            max-width: 85%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('chatbot-toggle-btn');
        const closeBtn = document.getElementById('chatbot-close-btn');
        const modal = document.getElementById('chatbot-modal');
        const chatMessages = document.getElementById('chatbot-messages');
        const messageInput = document.getElementById('chatbot-message-input');
        const sendBtn = document.getElementById('chatbot-send-btn');
        const clearBtn = document.getElementById('chatbot-clear-btn');
        
        let sessionId = localStorage.getItem('chatbot_session_id') || generateSessionId();
        let isLoading = false;

        // Generate session ID
        function generateSessionId() {
            const id = 'session_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('chatbot_session_id', id);
            return id;
        }

        // Toggle modal
        toggleBtn.addEventListener('click', () => {
            modal.classList.add('open');
            toggleBtn.classList.add('hidden');
            messageInput.focus();
            loadConversation();
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('open');
            toggleBtn.classList.remove('hidden');
        });

        // Send message
        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message || isLoading) return;

            addMessage('user', message);
            messageInput.value = '';

            showTypingIndicator();
            isLoading = true;
            sendBtn.disabled = true;

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
            const emptyState = chatMessages.querySelector('.chatbot-empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const messageEl = document.createElement('div');
            messageEl.className = `chatbot-message ${role}`;
            messageEl.innerHTML = `<div class="chatbot-message-content">${formatChatMessage(content)}</div>`;
            chatMessages.appendChild(messageEl);
            scrollToBottom();
        }

        // Format chat message: escape HTML, convert **bold** to <strong>, preserve paragraphs and line breaks
        function formatChatMessage(text) {
            if (text === null || text === undefined) return '';
            const escaped = escapeHtml(String(text));

            // Convert markdown bold **text** to <strong>
            const withBold = escaped.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');

            // Break into paragraphs on double newline, single newline -> <br>
            const paragraphs = withBold.split(/\n{2,}/).map(p => '<p>' + p.replace(/\n/g, '<br>') + '</p>');
            return paragraphs.join('');
        }

        // Show typing indicator
        function showTypingIndicator() {
            const messageEl = document.createElement('div');
            messageEl.className = 'chatbot-message bot';
            messageEl.id = 'chatbot-typing-indicator';
            messageEl.innerHTML = `
                <div class="chatbot-typing-indicator">
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
            const indicator = document.getElementById('chatbot-typing-indicator');
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
                        const emptyState = chatMessages.querySelector('.chatbot-empty-state');
                        if (emptyState) {
                            emptyState.remove();
                        }
                        
                        data.messages.forEach(msg => {
                            addMessage(msg.role, msg.content);
                        });
                    }
                })
                .catch(error => console.error('Error loading conversation:', error));
        }

        // Clear conversation
        clearBtn.addEventListener('click', () => {
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
                    <div class="chatbot-empty-state">
                        <i class="bi bi-chat-left-dots"></i>
                        <h4>Mulai Percakapan</h4>
                        <p>Tanyakan tentang persyaratan surat, prosedur administrasi, dan jadwal pelayanan RT</p>
                        
                        <div class="chatbot-suggested-questions">
                            <button class="chatbot-suggested-btn" data-question="Apa persyaratan untuk membuat surat keterangan?">
                                Persyaratan surat keterangan
                            </button>
                            <button class="chatbot-suggested-btn" data-question="Berapa lama proses pembuatan surat?">
                                Durasi pembuatan surat
                            </button>
                            <button class="chatbot-suggested-btn" data-question="Jam pelayanan RT berapa saja?">
                                Jadwal pelayanan RT
                            </button>
                            <button class="chatbot-suggested-btn" data-question="Bagaimana cara membuat laporan ke RT?">
                                Cara membuat laporan
                            </button>
                        </div>
                    </div>
                `;
                attachSuggestedButtonListeners();
            })
            .catch(error => console.error('Error clearing conversation:', error));
        });

        // Attach template button listeners (above input)
        function attachTemplateListeners() {
            document.querySelectorAll('.chatbot-template-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    messageInput.value = btn.dataset.q || btn.textContent.trim();
                    messageInput.focus();
                    // Auto-send when template clicked to simplify flow
                    // small delay to allow focus/UX updates
                    setTimeout(() => {
                        sendMessage();
                    }, 150);
                });
            });
        }

        // Suggested questions
        function attachSuggestedButtonListeners() {
            document.querySelectorAll('.chatbot-suggested-btn').forEach(btn => {
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

        // Initial setup
        attachSuggestedButtonListeners();
        attachTemplateListeners();
    });
</script>
