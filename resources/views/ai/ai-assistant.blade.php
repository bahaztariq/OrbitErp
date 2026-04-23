@extends('layouts.admin')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    .bg-gemini-spark {
        background: linear-gradient(74deg, #4285f4 0, #9b72cb 9%, #d96570 20%, #202124 80%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .animate-gemini-fade {
        animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .chat-response code { 
        background: rgba(0, 0, 0, 0.05); 
        padding: 0.2rem 0.4rem; 
        border-radius: 8px; 
        font-family: 'Fira Code', monospace; 
        font-size: 0.85em;
        color: #d946ef;
    }
    .scrollbar-gemini::-webkit-scrollbar { width: 4px; }
    .scrollbar-gemini::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="gemini-outer min-h-[calc(100vh-140px)] flex flex-col bg-white rounded-3xl overflow-hidden font-inter relative shadow-sm border border-gray-100" 
     x-data="aiAssistant()"
     x-init="init()">
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col items-center relative py-8 px-4 md:px-12 w-full overflow-hidden">
        <div class="w-full max-w-4xl h-full flex flex-col relative">
            
            <!-- Hero State -->
            <div x-show="heroVisible" x-transition.opacity.duration.500ms
                 class="flex-1 flex flex-col justify-center items-center text-center animate-gemini-fade pt-12">
                <div class="flex items-center gap-3 mb-4">
                    <x-application-logo class="w-12 h-12 text-blue-600" />
                    <div class="text-5xl font-bold bg-gemini-spark tracking-tight">OrbitBot</div>
                </div>
                <h1 class="text-4xl md:text-6xl font-medium mb-6 text-gray-900">Hello, {{ explode(' ', auth()->user()->name)[0] }}</h1>
                
                <p class="text-lg text-gray-600 mt-8 max-w-2xl animate-gemini-fade" style="animation-delay: 0.2s">
                    Your intelligent assistant for managing OrbitErp. Ask questions about your clients, products, or orders, and I'll help you find the information you need in seconds.
                </p>
            </div>

            <!-- Chat Messages -->
            <div x-show="!heroVisible" x-transition.opacity.duration.400ms
                 class="flex-1 flex flex-col gap-10 overflow-y-auto pb-44 px-2 scrollbar-gemini"
                 x-ref="messagesBox">
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="flex gap-4 md:gap-6 w-full animate-gemini-fade" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                        <!-- Avatar -->
                        <div class="shrink-0 pt-1">
                            <div x-show="msg.role === 'ai'" class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center shadow-sm border border-blue-50 bg-white">
                                <x-application-logo class="w-6 h-6 md:w-7 md:h-7 text-blue-600" />
                            </div>
                            <div x-show="msg.role === 'user'" class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center shadow-sm">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                        </div>
                        <!-- Bubble -->
                        <div class="chat-response relative group max-w-[85%] md:max-w-[80%]" :class="msg.role === 'user' ? 'text-right' : ''">
                            <div class="inline-block p-4 px-6 rounded-[22px] md:rounded-[26px] leading-relaxed text-[14px] md:text-[15px] shadow-sm transition-all" 
                                 :class="msg.role === 'user' ? 'bg-[#f0f4f9] text-gray-800 rounded-tr-none' : 'bg-white border border-gray-100 text-gray-800 rounded-tl-none hover:border-blue-100'"
                                 x-html="formatMessage(msg.content)">
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Loading State -->
                <div x-show="loading" class="flex gap-4 md:gap-6">
                    <div class="shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-white border border-blue-50 flex items-center justify-center shadow-sm">
                        <x-application-logo class="w-6 h-6 md:w-7 md:h-7 text-blue-400 animate-pulse" />
                    </div>
                    <div class="p-4 px-6 rounded-[26px] bg-gray-50 text-gray-400 text-[13px] font-medium flex items-center gap-4">
                        <div class="flex gap-1">
                            <div class="w-1.5 h-1.5 bg-blue-300 rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 bg-purple-300 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                            <div class="w-1.5 h-1.5 bg-red-300 rounded-full animate-bounce [animation-delay:-0.5s]"></div>
                        </div>
                        OrbitBot is crafting a response
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="sticky bottom-0 pb-8 pt-4 bg-white/95 backdrop-blur-md w-full z-10">
                <div class="max-w-4xl mx-auto px-4 md:px-6 relative group">
                    <div class="bg-[#f0f4f9] border-none rounded-[32px] transition-all duration-300 focus-within:bg-white focus-within:shadow-xl">
                        <div class="flex items-center gap-1 md:gap-2 p-2 px-3 md:px-5 pb-3">
                            <textarea x-model="userInput" 
                                @input="autoResize"
                                @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                                class="flex-1 bg-transparent border-none text-gray-800 p-3 text-[15px] md:text-base outline-none focus:ring-0 resize-none max-h-60 placeholder:text-gray-400 placeholder:font-light" 
                                placeholder="Ask OrbitBot anything..." 
                                rows="1"
                                x-ref="inputField"></textarea>
                            <!-- Actions -->
                            <div class="flex items-center gap-1 mb-1">
                                <button @click="sendMessage()"
                                    :disabled="!userInput.trim() || loading"
                                    class="p-3 md:p-3.5 rounded-full text-white transition-all active:scale-95 disabled:opacity-90 disabled:pointer-events-none shadow-lg"
                                    :class="userInput.trim() ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' : 'bg-blue-500'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M231.87,114l-168-95.89A16,16,0,0,0,40.92,37.34L71.55,128,40.92,218.67A16,16,0,0,0,56,240a16.15,16.15,0,0,0,7.93-2.1l167.92-96.05a16,16,0,0,0,.05-27.89ZM56,224a.56.56,0,0,0,0-.12L85.74,136H144a8,8,0,0,0,0-16H85.74L56.06,32.16A.46.46,0,0,0,56,32l168,95.83Z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="text-[10px] md:text-[11px] text-center mt-3 text-gray-400 font-medium opacity-60">✦ OrbitBot may display inaccurate info, so double-check its responses.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function aiAssistant() {
    return {
        messages: [],
        userInput: '',
        loading: false,
        heroVisible: true,
        
        init() {
            this.$nextTick(() => this.$refs.inputField.focus());
        },

        autoResize() {
            const el = this.$refs.inputField;
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        },

        async sendMessage() {
            if (!this.userInput.trim() || this.loading) return;

            const prompt = this.userInput.trim();
            this.messages.push({ role: 'user', content: prompt });
            this.userInput = '';
            this.heroVisible = false;
            this.loading = true;
            
            this.$nextTick(() => {
                this.scrollToBottom();
                this.autoResize();
            });

            try {
                const response = await fetch("{{ route('ai.chat', ['company' => $companySlug]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt })
                });

                const data = await response.json();
                this.messages.push({ role: 'ai', content: data.response });
            } catch (error) {
                this.messages.push({ role: 'ai', content: 'Sorry, I encountered an error. Please check your connection and try again.' });
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        scrollToBottom() {
            const el = this.$refs.messagesBox;
            if (el) {
                el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
            }
        },

        formatMessage(text) {
            if (!text) return '';
            return text
                .replace(/\*\*(.*?)\*\*/g, '<b class="font-bold text-gray-900">$1</b>')
                .replace(/\n/g, '<br>')
                .replace(/```([\s\S]*?)```/g, '<div class="my-4 bg-gray-950 text-gray-100 p-5 rounded-2xl font-mono text-[13px] overflow-x-auto whitespace-pre border border-white/5">$1</div>');
        }
    }
}
</script>
@endsection
