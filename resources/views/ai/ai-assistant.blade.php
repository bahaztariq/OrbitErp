@extends('layouts.admin')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Gemini signature elements */
    .bg-gemini-gradient {
        background: radial-gradient(circle at center, #4285f4 0%, #9b72cb 50%, #d96570 100%);
    }
    .bg-gemini-spark {
        background: linear-gradient(74deg, #4285f4 0, #9b72cb 9%, #d96570 20%, #e3e3e3 80%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-selected-gradient {
        background: linear-gradient(to bottom, #fff 0%, #aaa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-gemini-fade {
        animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    @keyframes pulse-ring {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(75, 144, 255, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(75, 144, 255, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(75, 144, 255, 0); }
    }
    .input-focus-ring:focus-within {
        animation: pulse-ring 2s infinite;
    }
    
    /* Markdown improvements */
    .chat-response b { font-weight: 700; color: #111; }
    .chat-response code { 
        background: rgba(0, 0, 0, 0.05); 
        padding: 0.2rem 0.4rem; 
        border-radius: 6px; 
        font-family: 'Fira Code', monospace; 
        font-size: 0.85em;
        color: #d946ef;
    }
    .chat-response ul { list-style: disc; margin-left: 1.5rem; margin-top: 0.5rem; color: #374151; }
    .chat-response li { margin-bottom: 0.3rem; }

    /* Glassmorphism sidebar */
    .sidebar-blur {
        backdrop-filter: blur(16px);
        background: rgba(19, 19, 20, 0.8);
    }
    
    .scrollbar-gemini::-webkit-scrollbar { width: 5px; }
    .scrollbar-gemini::-webkit-scrollbar-thumb { background: #28292a; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="gemini-outer min-h-[calc(100vh-140px)] flex flex-row bg-white rounded-3xl overflow-hidden text-[#e3e3e3] font-inter relative shadow-border" 
     x-data="{ sidebarOpen: false }">
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col items-center relative py-8 px-4 md:px-12 w-full">
        <div class="w-full max-w-4xl h-full flex flex-col">
            
            <!-- Hero State -->
            <div id="hero" class="flex-1 flex flex-col justify-center items-center text-center animate-gemini-fade">
                <div class="text-5xl font-bold bg-gemini-spark mb-4 tracking-tight text-black">✦ OrbitBot</div>
                <h1 class="text-hero-gradient text-4xl md:text-6xl font-medium mb-6 text-black">Hello, {{ explode(' ', auth()->user()->name)[0] }}</h1>
                
                <!-- Suggested Prompts -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 w-full mt-12">
                    @php
                        $suggestions = [
                            ['icon' => '📄', 'title' => 'List all clients', 'text' => 'Get a quick summary of your customer base'],
                            ['icon' => '💰', 'title' => 'Show revenue', 'text' => 'Analyze company performance for this month'],
                            ['icon' => '📦', 'title' => 'Check stock', 'text' => 'Which products are currently low in inventory?'],
                            ['icon' => '✍️', 'title' => 'Create invoice', 'text' => 'Generate a new billing request for a client']
                        ];
                    @endphp
                    @foreach($suggestions as $s)
                    <button class="group p-5 bg-white hover:bg-gray-100 border border-white/5 rounded-2xl text-left transition-all hover:scale-[1.02] active:scale-95 flex flex-col gap-3"
                            onclick="fillPrompt('{{ $s['title'] }}')">
                        <span class="text-2xl">{{ $s['icon'] }}</span>
                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-black">{{ $s['title'] }}</p>
                            <p class="text-xs text-[#b4b4b4] leading-relaxed">{{ $s['text'] }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Chat State -->
            <div id="chat-messages" class="hidden flex-1 flex flex-col gap-8 overflow-y-auto pb-44 px-2 scrollbar-gemini">
                <!-- Messages will be injected here -->
            </div>

            <!-- Typing/Processing Indicator -->
            <div id="typing" class="hidden fixed bottom-32 left-1/2 -translate-x-1/2 w-full max-w-xl text-center">
                <div class="flex items-center justify-center gap-1">
                    <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-1.5 h-1.5 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-1.5 h-1.5 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    <span class="ml-2 text-xs text-[#b4b4b4] font-medium uppercase tracking-widest">OrbitBot is processing</span>
                </div>
            </div>

            <!-- Input Bar -->
            <div class="sticky bottom-0 pb-8 pt-4 bg-white/80 backdrop-blur-sm w-full">
                <form id="chat-form" method="POST" class="max-w-3xl mx-auto px-6 relative group">
                    @csrf
                    <div class="bg-[#f0f4f9] border border-transparent rounded-[28px] overflow-hidden transition-all duration-300 input-focus-ring focus-within:bg-white focus-within:border-gray-200 focus-within:shadow-lg">
                        <div class="flex items-end gap-2 ">
                            <textarea id="user-input" 
                                class="flex-1 bg-transparent border-none text-gray-800 p-2 text-base outline-none resize-none max-h-64 scrollbar-gemini py-2.5 placeholder:text-gray-500/70 focus:outline-none" 
                                placeholder="Enter a prompt here" 
                                rows="1"></textarea>
                            <div class="flex items-center gap-1 mb-1">
                                <button type="submit" id="send-btn" 
                                    class="p-3.5 rounded-full text-white bg-blue-600 opacity-50 cursor-not-allowed transform transition-all active:scale-95 disabled:pointer-events-none shadow-sm">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-center mt-3 text-gray-500 font-medium">✦ OrbitBot may display inaccurate info, so double-check its responses.</p>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
    const chatForm = document.getElementById('chat-form');
    const userInput = document.getElementById('user-input');
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing');
    const hero = document.getElementById('hero');
    const sendBtn = document.getElementById('send-btn');

    function fillPrompt(text) {
        userInput.value = text;
        userInput.dispatchEvent(new Event('input'));
        userInput.focus();
    }

    userInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        
        if (this.value.trim().length > 0) {
            sendBtn.classList.add('opacity-100', 'cursor-pointer', 'shadow-[0_0_15px_rgba(75,144,255,0.4)]');
            sendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            sendBtn.disabled = false;
        } else {
            sendBtn.classList.add('opacity-50', 'cursor-not-allowed');
            sendBtn.classList.remove('opacity-100', 'cursor-pointer', 'shadow-[0_0_15px_rgba(75,144,255,0.4)]');
            sendBtn.disabled = true;
        }
    });

    userInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (userInput.value.trim()) {
                chatForm.dispatchEvent(new Event('submit'));
            }
        }
    });

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const prompt = userInput.value.trim();
        if (!prompt) return;

        if (hero) hero.classList.add('hidden');
        chatMessages.classList.remove('hidden');

        appendMessage(prompt, 'user');
        
        userInput.value = '';
        userInput.style.height = 'auto';
        sendBtn.classList.add('opacity-50', 'cursor-not-allowed');
        sendBtn.disabled = true;

        typingIndicator.classList.remove('hidden');
        userInput.disabled = true;
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        try {
            const companySlug = '{{ $companySlug }}';
            const response = await fetch("{{ route('ai.chat', ['company' => '__SLUG__']) }}".replace('__SLUG__', companySlug), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ prompt })
            });

            const data = await response.json();
            appendMessage(data.response, 'ai');
        } catch (error) {
            appendMessage('Sorry, I encountered an error. Please check your connection and try again.', 'ai');
        } finally {
            typingIndicator.classList.add('hidden');
            userInput.disabled = false;
            userInput.focus();
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });

    function appendMessage(text, sender) {
        const wrapper = document.createElement('div');
        wrapper.className = `flex gap-6 w-full animate-gemini-fade ${sender === 'user' ? 'flex-row-reverse' : ''}`;
        
        const avatar = document.createElement('div');
        avatar.className = `shrink-0 p-0.5 rounded-full ${sender === 'ai' ? 'bg-gemini-gradient shadow-lg' : 'bg-[#333]'}`;
        
        const avatarInner = document.createElement('div');
        avatarInner.className = `w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm ${sender === 'ai' ? 'bg-[#0e0e0e] text-white' : 'bg-gray-200 text-gray-500'}`;
        avatarInner.innerHTML = sender === 'ai' ? '<span class="bg-gemini-spark text-lg">✦</span>' : '{{ substr(auth()->user()->name, 0, 1) }}';
        
        avatar.appendChild(avatarInner);
        
        const content = document.createElement('div');
        content.className = `chat-response relative group max-w-[80%] ${sender === 'user' ? 'text-right' : ''}`;
        
        const innerContent = document.createElement('div');
        innerContent.className = `p-4 px-6 rounded-3xl leading-loose text-[15px] ${sender === 'user' ? 'bg-[#f0f4f9] text-gray-800' : 'text-gray-800'}`;
        
        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, '<b class="font-bold text-gray-900">$1</b>')
            .replace(/\n/g, '<br>');
            
        innerContent.innerHTML = formattedText;
        content.appendChild(innerContent);
        
        wrapper.appendChild(avatar);
        wrapper.appendChild(content);
        
        chatMessages.appendChild(wrapper);
        chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
    }
</script>
@endsection
