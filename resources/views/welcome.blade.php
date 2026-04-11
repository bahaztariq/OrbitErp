<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'OrbitErp') }} - All-in-one Business Workspace</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Outfit', sans-serif; }
            .text-gradient {
                background: linear-gradient(135deg, #465fff 0%, #3641f5 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-up { animation: fadeUp 0.6s ease-out forwards; }
        </style>
    </head>
    <body class="bg-white text-[#37352f] antialiased selection:bg-[#465fff1a] selection:text-[#465fff]">
        <!-- Navbar -->
        <nav x-data="{ mobileOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-[#37352f1a]">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-16 px-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#465fff] flex items-center justify-center">
                        <span class="text-white font-bold text-lg leading-none">O</span>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-[#37352f]">OrbitErp</span>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('companies.index') }}" class="text-sm font-medium text-[#37352f80] hover:text-[#37352f] px-3 py-1.5 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-[#37352f80] hover:text-[#37352f] px-3 py-1.5 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm bg-[#465fff] text-white hover:bg-[#3641f5] px-4 py-1.5 rounded-md font-medium transition-all shadow-sm">Get started free →</a>
                        @endauth
                    @endif
                </div>
                <button class="md:hidden text-[#37352f]" @click="mobileOpen = !mobileOpen">
                    <template x-if="!mobileOpen">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </template>
                    <template x-if="mobileOpen">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </template>
                </button>
            </div>
        </nav>

        <!-- Hero -->
        <section class="pt-40 pb-20 px-4 overflow-hidden">
            <div class="max-w-4xl mx-auto text-center">
                <div class="animate-fade-up">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#37352f1a] bg-[#f7f6f3] px-4 py-1.5 text-xs font-semibold text-[#37352f60] mb-8">
                        <span class="w-2 h-2 rounded-full bg-[#465fff]"></span>
                        OrbitErp v1.0 is now live
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black tracking-tight text-[#37352f] leading-[1.05] mb-8">
                        The all-in-one workspace for <br class="hidden md:block">
                        <span class="text-gradient">your business</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-[#37352f80] max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                        Manage products, finances, inventory, and teams — all in one beautifully simple platform. Built for modern businesses that move fast.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-[#465fff] text-white hover:bg-[#3641f5] px-10 py-4 rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl active:scale-[0.98]">
                            Get started free
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                        <a href="#" class="w-full sm:w-auto px-10 py-4 rounded-xl border border-[#37352f1a] text-[#37352f] font-bold text-lg hover:bg-[#37352f0a] transition-all flex items-center justify-center">
                            Request a demo
                        </a>
                    </div>
                    <p class="text-sm text-[#37352f40] mt-6 font-medium">Free for individuals · Professional plans for teams</p>
                </div>
                <div class="mt-20 animate-fade-up" style="animation-delay: 0.2s">
                    <div class="rounded-2xl border border-[#37352f1a] overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.1)] hover:shadow-[0_30px_70px_rgba(0,0,0,0.15)] transition-shadow duration-500">
                        <img src="{{ asset('images/landing-hero.png') }}" alt="OrbitErp Dashboard" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="product" class="py-32 px-6 bg-[#f7f6f3]/50 border-y border-[#37352f0a]">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-20 animate-fade-up">
                    <p class="text-sm font-bold text-[#465fff] uppercase tracking-widest mb-4">Features</p>
                    <h2 class="text-4xl md:text-5xl font-black text-[#37352f] mb-6 tracking-tight">Everything you need, nothing you don't</h2>
                    <p class="text-xl text-[#37352f80] max-w-xl mx-auto font-medium">A unified platform that replaces scattered tools with one elegant workspace.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $features = [
                            ['icon' => '📊', 'title' => 'Financial Insights', 'desc' => 'Real-time dashboards for revenue, expenses, and cash flow. Make data-driven decisions instantly.'],
                            ['icon' => '📦', 'title' => 'Inventory Management', 'desc' => 'Track stock levels, automate reorders, and manage suppliers all from one clean interface.'],
                            ['icon' => '👥', 'title' => 'Team Collaboration', 'desc' => 'Assign tasks, share documents, and communicate seamlessly across departments.'],
                            ['icon' => '📄', 'title' => 'Smart Documents', 'desc' => 'Generate invoices, purchase orders, and reports with beautiful templates in seconds.'],
                            ['icon' => '⚡', 'title' => 'Workflow Automation', 'desc' => 'Automate repetitive tasks and approvals. Set it once, let it run forever.'],
                            ['icon' => '🛡️', 'title' => 'Enterprise Security', 'desc' => 'Role-based access, audit logs, and data encryption to keep your business secure.'],
                        ];
                    @endphp

                    @foreach($features as $index => $feature)
                        <div class="group bg-white rounded-3xl border border-[#37352f1a] p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 animate-fade-up" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="w-14 h-14 rounded-2xl bg-[#f7f6f3] flex items-center justify-center mb-6 group-hover:bg-[#465fff1a] transition-colors">
                                <span class="text-3xl transition-transform group-hover:scale-110">{{ $feature['icon'] }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-[#37352f] mb-4">{{ $feature['title'] }}</h3>
                            <p class="text-[#37352f80] leading-relaxed font-medium">{{ $feature['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-32 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-20 animate-fade-up">
                    <p class="text-sm font-bold text-[#465fff] uppercase tracking-widest mb-4">Testimonials</p>
                    <h2 class="text-4xl font-black text-[#37352f] tracking-tight">Loved by modern teams</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $testimonials = [
                            ['quote' => 'OrbitErp replaced 5 different tools for us. Our team is more productive than ever.', 'name' => 'Sarah Chen', 'role' => 'COO, TechVentures'],
                            ['quote' => 'The cleanest ERP I\'ve ever used. It actually makes managing finances enjoyable.', 'name' => 'Marcus Rivera', 'role' => 'CFO, GreenLeaf Co'],
                            ['quote' => 'We onboarded our entire team in a day. No training needed — it\'s that intuitive.', 'name' => 'Priya Sharma', 'role' => 'Operations Lead, Nexus'],
                        ];
                    @endphp

                    @foreach($testimonials as $i => $t)
                        <div class="bg-[#f7f6f3]/30 border border-[#37352f1a] rounded-3xl p-8 animate-fade-up hover:bg-white transition-colors duration-300" style="animation-delay: {{ $i * 0.15 }}s">
                            <p class="text-lg text-[#37352f] leading-relaxed mb-8 font-medium">"{{ $t['quote'] }}"</p>
                            <div>
                                <p class="font-bold text-[#37352f]">{{ $t['name'] }}</p>
                                <p class="text-sm text-[#37352f60] font-semibold tracking-wide uppercase mt-1">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-40 px-6 bg-[#f7f6f3]/50 border-t border-[#37352f0a]">
            <div class="max-w-3xl mx-auto text-center animate-fade-up">
                <h2 class="text-4xl md:text-6xl font-black text-[#37352f] mb-8 tracking-tight">Start running your business smarter today.</h2>
                <p class="text-xl md:text-2xl text-[#37352f80] mb-12 font-medium">Join thousands of teams who already use OrbitErp to simplify operations and grow faster.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-[#465fff] text-white hover:bg-[#3641f5] px-12 py-5 rounded-xl font-bold text-lg transition-all shadow-xl hover:shadow-2xl active:scale-[0.98]">
                        Get started for free
                    </a>
                </div>
                <p class="text-sm text-[#37352f40] mt-6 font-medium uppercase tracking-widest">No credit card required · Free plan available</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-[#37352f1a] py-32 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-16 mb-24">
                    <div class="col-span-2 md:col-span-1">
                        <div class="flex items-center gap-2 mb-8">
                            <div class="w-8 h-8 rounded-lg bg-[#465fff] flex items-center justify-center">
                                <span class="text-white font-bold text-lg leading-none">O</span>
                            </div>
                            <span class="font-bold text-xl tracking-tight">OrbitErp</span>
                        </div>
                        <p class="text-[#37352f80] font-medium leading-relaxed mb-8">The modern workspace for growing businesses.</p>
                        <div class="flex gap-4">
                            <!-- Social Icons -->
                        </div>
                    </div>
                    @php
                        $footer = [
                            'Product' => ['Features', 'Pricing', 'Integrations', 'Changelog'],
                            'Company' => ['About', 'Blog', 'Careers', 'Contact'],
                            'Resources' => ['Documentation', 'Help Center', 'Community', 'Status'],
                            'Legal' => ['Privacy', 'Terms', 'Security'],
                        ];
                    @endphp
                    @foreach($footer as $category => $links)
                        <div>
                            <p class="font-bold text-xs uppercase tracking-widest text-[#37352f50] mb-8">{{ $category }}</p>
                            <ul class="space-y-4">
                                @foreach($links as $link)
                                    <li><a href="#" class="text-[15px] font-medium text-[#37352f80] hover:text-[#465fff] transition-colors">{{ $link }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-[#37352f0a] mt-12 pt-12 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-sm font-medium text-[#37352f40]">© {{ date('Y') }} OrbitErp. All rights reserved.</p>
                    <div class="flex gap-8 text-sm font-medium text-[#37352f40]">
                        <a href="#" class="hover:text-[#37352f] transition-colors">Privacy</a>
                        <a href="#" class="hover:text-[#37352f] transition-colors">Terms</a>
                        <a href="#" class="hover:text-[#37352f] transition-colors">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
