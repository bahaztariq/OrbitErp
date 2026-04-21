<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'OrbitErp') }} - All-in-one Business Workspace</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        
        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .text-gradient {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232563eb' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2v-4h4v-2H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-100 selection:text-blue-700">
        <!-- Navbar -->
        <nav x-data="{ mobileOpen: false, scrolled: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 20)"
             :class="scrolled ? 'bg-white/80 backdrop-blur-lg border-slate-200 shadow-sm' : 'bg-transparent border-transparent'"
             class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-20 px-6">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <x-application-logo class="w-10 h-10 fill-current text-blue-600" />
                        <span class="font-extrabold text-2xl tracking-tight text-slate-900">OrbitErp</span>
                    </a>
                </div>
                
                

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('companies.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-slate-900 px-4 py-2 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">Get Started Free</a>
                    @endauth
                </div>
                
                <button class="md:hidden p-2 text-slate-600" @click="mobileOpen = !mobileOpen">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileOpen" x-cloak class="md:hidden bg-white border-b border-slate-200 p-6 space-y-4">
                <div class="flex flex-col gap-3">
                    @auth
                        <a href="{{ route('companies.index') }}" class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-center">Sign In</a>
                        <a href="{{ route('register') }}" class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold text-center">Get Started Here</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main>
            <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
                <div class="max-w-7xl mx-auto px-6 relative z-10 text-center lg:text-left">
                    <div class="flex flex-col lg:flex-row items-center gap-16">
                        <div class="flex-1 max-w-2xl">
                            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-1.5 text-xs font-bold text-blue-600 mb-8 animate-fade-up">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                OrbitErp v1.0 is now live
                            </div>
                            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 leading-[1.1] mb-8 animate-fade-up">
                                The ultimate <span class="text-gradient">all-in-one</span> workspace
                            </h1>
                            <p class="text-xl md:text-2xl text-slate-500 mb-12 leading-relaxed animate-fade-up" style="animation-delay: 0.1s">
                                OrbitErp brings your products, clients, accounting, and teams into one beautifully synchronized platform. Built for businesses that demand excellence.
                            </p>
                            <div class="flex flex-col sm:flex-row items-center gap-4 animate-fade-up" style="animation-delay: 0.2s">
                                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 px-10 py-5 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-blue-600/30 active:scale-[0.98]">
                                    Get Started Here
                                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 rounded-2xl border border-slate-200 bg-white text-slate-700 font-bold text-lg hover:bg-slate-50 transition-all flex items-center justify-center shadow-sm">
                                    Sign In
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex-1 w-full animate-fade-up" style="animation-delay: 0.4s">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                                <div class="relative bg-white p-2 rounded-[2rem] shadow-2xl border border-slate-200/50">
                                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2426&q=80" alt="Dashboard" class="rounded-[1.5rem] w-full h-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features (Bento Grid) -->
            <section id="features" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="mb-20 text-center lg:text-left">
                        <h2 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest mb-4">Enterprise Features</h2>
                        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">One platform, <span class="text-blue-600 italic">infinite</span> possibilities.</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Large Feature Card -->
                        <div class="md:col-span-2 group relative p-10 bg-slate-50 rounded-[2.5rem] overflow-hidden border border-slate-100 hover:border-blue-200 transition-all">
                            <div class="relative z-10">
                                <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center mb-8 shadow-lg shadow-blue-600/20">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h4 class="text-3xl font-extrabold text-slate-900 mb-4">Advanced Real-time Analytics</h4>
                                <p class="text-lg text-slate-500 max-w-sm mb-8 font-medium italic">Track every metric that matters. From revenue retention to inventory turnover, OrbitErp gives you the full picture instantly.</p>
                            </div>
                            <div class="absolute bottom-0 right-0 w-1/2 translate-y-12 translate-x-12 opacity-40 group-hover:opacity-100 transition-opacity duration-500">
                                <img src="https://images.unsplash.com/photo-1551288049-bbbda546697a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="rounded-tl-3xl shadow-2xl">
                            </div>
                        </div>

                        <!-- Single Feature Card -->
                        <div class="group p-10 bg-white rounded-[2.5rem] border border-slate-200 hover:shadow-2xl hover:shadow-blue-600/5 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-8">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-1.173-10.99c.07-.315.152-.63.243-.941L8.284 6.05a3.15 3.15 0 014.288-4.056 3.149 3.149 0 011.127 1.465l.505 1.517m-1.173 10.99A4.14 4.14 0 0115 12h3M6 18c-3 0-5-2-5-5s2-5 5-5m12 10c0 1.414-.586 2.828-1.414 3.414L15 18"></path></svg>
                            </div>
                            <h4 class="text-2xl font-extrabold text-slate-900 mb-4">Secure Multi-tenancy</h4>
                            <p class="text-slate-500 font-medium">Enterprise-grade isolation between companies. Your data remains yours, always encrypted and secure.</p>
                        </div>

                        <!-- Single Feature Card -->
                        <div class="group p-10 bg-white rounded-[2.5rem] border border-slate-200 hover:shadow-2xl hover:shadow-blue-600/5 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-8">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h4 class="text-2xl font-extrabold text-slate-900 mb-4">Smart Invoicing</h4>
                            <p class="text-slate-500 font-medium">Automate your billing cycle. Professional templates that reflect your brand's quality.</p>
                        </div>

                        <!-- Medium Feature Card -->
                        <div class="md:col-span-2 group relative p-10 bg-slate-900 rounded-[2.5rem] overflow-hidden text-white border border-slate-800">
                            <div class="relative z-10">
                                <div class="w-16 h-16 rounded-2xl bg-blue-500 text-white flex items-center justify-center mb-8">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h4 class="text-3xl font-extrabold mb-4">Seamless Team Management</h4>
                                <p class="text-slate-400 font-medium italic text-lg max-w-sm">Permissions, roles, and collaboration built right into the core. Scale your team without scaling complexity.</p>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent pointer-events-none"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials -->
            <section id="testimonials" class="py-24 bg-slate-50 border-y border-slate-200">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="text-center mb-16">
                        <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight italic">Loved by world-class teams.</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach([
                            ['quote' => 'OrbitErp didn\'t just replace our spreadsheet hell, it redesigned how we think about our business operations.', 'author' => 'Sarah Graham', 'title' => 'CEO at Lumina'],
                            ['quote' => 'The attention to detail in the UI is matched by the power of the backend. It\'s a masterclass in software design.', 'author' => 'Mark Wilson', 'title' => 'CFO at FlowState'],
                            ['quote' => 'Our onboarding time dropped from weeks to hours. It\'s the only tool my team actually enjoys using.', 'author' => 'Jessica Chen', 'title' => 'Ops Lead at Nexus']
                        ] as $testimonial)
                            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300">
                                <div class="flex gap-1 mb-6">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-5 h-5 text-blue-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <p class="text-slate-600 font-medium mb-8 leading-relaxed italic">"{{ $testimonial['quote'] }}"</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-200"></div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $testimonial['author'] }}</p>
                                        <p class="text-xs text-slate-500 font-semibold">{{ $testimonial['title'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Final CTA -->
            <section class="py-24 lg:py-40">
                <div class="max-w-5xl mx-auto px-6 text-center">
                    <div class="bg-blue-600 rounded-[3rem] p-12 lg:p-24 shadow-2xl shadow-blue-600/20 relative overflow-hidden">
                        <div class="relative z-10">
                            <h2 class="text-4xl lg:text-6xl font-extrabold text-white mb-8 tracking-tight">Scale your enterprise with <br> confidence.</h2>
                            <p class="text-xl text-blue-100 mb-12 max-w-2xl mx-auto font-medium">Join 2,000+ modern companies using OrbitErp to streamline their future. No credit card required to start.</p>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-blue-600 px-12 py-5 rounded-2xl font-bold text-lg hover:bg-blue-50 transition-all shadow-xl active:scale-[0.98]">
                                    Get Started for Free
                                </a>
                                <a href="#" class="w-full sm:w-auto px-12 py-5 rounded-2xl border border-white/20 text-white font-bold text-lg hover:bg-white/10 transition-all">
                                    Talk to Sales
                                </a>
                            </div>
                        </div>
                        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500 rounded-full blur-3xl opacity-50"></div>
                        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-30"></div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-12 mb-20">
                    <div class="col-span-2">
                        <a href="/" class="flex items-center gap-3 mb-8">
                            <x-application-logo class="w-8 h-8 fill-current text-blue-600" />
                            <span class="font-extrabold text-xl tracking-tight text-slate-900 italic">OrbitErp</span>
                        </a>
                        <p class="text-slate-500 font-medium leading-relaxed max-w-xs transition-colors hover:text-slate-700">The next-generation enterprise workspace designed for speed and scale.</p>
                    </div>
                    
                    @foreach([
                        'Product' => ['Features', 'Integrations', 'Pricing', 'Changelog'],
                        'Company' => ['About', 'Blog', 'Careers', 'Contact'],
                        'Legal' => ['Privacy Policy', 'Terms of Service', 'Cookie Policy'],
                        'Social' => ['Twitter', 'LinkedIn', 'YouTube']
                    ] as $category => $links)
                        <div>
                            <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">{{ $category }}</h5>
                            <ul class="space-y-4">
                                @foreach($links as $link)
                                    <li><a href="#" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">{{ $link }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                
                <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-sm font-bold text-slate-400">© {{ date('Y') }} OrbitErp. All rights reserved.</p>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                        <span class="text-xs font-extrabold text-slate-400">System Operational</span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
