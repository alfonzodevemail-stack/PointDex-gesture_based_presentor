<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PointDex — Gesture-Based Remote Presentation Controller</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-cyan-500 selection:text-white">
        <!-- Background Glow FX -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl"></div>
        </div>

        <!-- Navigation Header -->
        <header class="border-b border-slate-800/80 backdrop-blur-md sticky top-0 z-50 bg-slate-950/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/30 text-white font-black text-xl">
                        P
                    </div>
                    <div>
                        <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">PointDex</span>
                        <span class="hidden sm:inline-block ml-2 text-xs uppercase px-2 py-0.5 rounded-full bg-cyan-950 text-cyan-400 border border-cyan-800 font-semibold tracking-wider">EDA ML Controller</span>
                    </div>
                </div>

                <nav class="flex items-center space-x-4 text-sm font-medium">
                    <a href="{{ route('about') }}" class="text-slate-300 hover:text-cyan-400 transition">About System</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-cyan-400 transition">Dashboard</a>
                            <a href="{{ route('presentations.index') }}" class="px-4 py-2 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold transition shadow-md shadow-cyan-500/20">
                                My Decks
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-300 hover:text-cyan-400 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-semibold transition shadow-md shadow-cyan-500/20">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-cyan-400">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    Event-Driven Optical Architecture • UN SDG 9 & 12
                </div>
                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                    Gesture-Based Remote <br/>
                    <span class="bg-gradient-to-r from-cyan-400 via-sky-400 to-blue-500 bg-clip-text text-transparent">
                        Presentation Controller
                    </span>
                </h1>

                <p class="text-lg text-slate-400 leading-relaxed">
                    Transform standard laptop webcams into zero-latency optical presentation clickers. Powered by 
                    <span class="text-slate-200 font-semibold">MediaPipe Hands</span>, 
                    client-side WebAssembly event loops, and non-blocking DOM dispatching.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    @auth
                        <a href="{{ route('presentations.index') }}" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold transition shadow-lg shadow-cyan-500/25 flex items-center gap-2">
                            Launch Decks
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold transition shadow-lg shadow-cyan-500/25 flex items-center gap-2">
                            Create Presenter Account
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 font-semibold border border-slate-800 transition">
                            Sign In
                        </a>
                    @endauth
                    <a href="{{ route('about') }}" class="px-6 py-3.5 rounded-xl bg-slate-900/60 hover:bg-slate-800 text-slate-300 font-medium border border-slate-800 transition">
                        System Architecture
                    </a>
                </div>
            </div>

            <!-- Gesture Controls Showcase Grid -->
            <div class="mt-20">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-slate-100">Standard Hand Gesture Mappings</h2>
                    <p class="text-sm text-slate-400 mt-1">Directly synthesized into DOM presentation keystrokes without external hardware</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Gesture 1 -->
                    <div class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800/80 hover:border-cyan-500/50 transition duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-cyan-950/70 text-cyan-400 border border-cyan-800/60 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                            👉
                        </div>
                        <h3 class="text-lg font-bold text-slate-200">Swipe Right</h3>
                        <p class="text-xs text-cyan-400 font-mono mt-1">Dispatch: ArrowRight</p>
                        <p class="text-sm text-slate-400 mt-2">Open hand horizontally translated rightward advances the presentation to the next slide.</p>
                    </div>

                    <!-- Gesture 2 -->
                    <div class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800/80 hover:border-cyan-500/50 transition duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-cyan-950/70 text-cyan-400 border border-cyan-800/60 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                            👈
                        </div>
                        <h3 class="text-lg font-bold text-slate-200">Swipe Left</h3>
                        <p class="text-xs text-cyan-400 font-mono mt-1">Dispatch: ArrowLeft</p>
                        <p class="text-sm text-slate-400 mt-2">Open hand rapidly translated leftward navigates back to the preceding slide.</p>
                    </div>

                    <!-- Gesture 3 -->
                    <div class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800/80 hover:border-cyan-500/50 transition duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-cyan-950/70 text-cyan-400 border border-cyan-800/60 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                            ✊
                        </div>
                        <h3 class="text-lg font-bold text-slate-200">Closed Fist</h3>
                        <p class="text-xs text-cyan-400 font-mono mt-1">Dispatch: F5 / Fullscreen</p>
                        <p class="text-sm text-slate-400 mt-2">Closed fist held statically for 1.5 seconds toggles fullscreen presentation mode.</p>
                    </div>

                    <!-- Gesture 4 -->
                    <div class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800/80 hover:border-cyan-500/50 transition duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-cyan-950/70 text-cyan-400 border border-cyan-800/60 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                            ✋
                        </div>
                        <h3 class="text-lg font-bold text-slate-200">Open Palm (Stop)</h3>
                        <p class="text-xs text-cyan-400 font-mono mt-1">Dispatch: 'B' / Blank Screen</p>
                        <p class="text-sm text-slate-400 mt-2">Open palm facing camera activates presentation pause or screen blanking.</p>
                    </div>
                </div>
            </div>

            <!-- Empirical Benchmark Badges -->
            <div class="mt-16 p-8 rounded-3xl bg-slate-900/40 border border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-3xl font-extrabold text-cyan-400">&lt; 80 ms</div>
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Target Latency</div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-emerald-400">30 FPS</div>
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Inference Rate</div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-blue-400">≥ 95%</div>
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Accuracy Benchmark</div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-purple-400">0 Watts</div>
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Disposable Batteries</div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-800/80 py-8 text-center text-xs text-slate-500">
            <p>PointDex: Gesture-Based Remote Presentation Controller • ITCC3101 Practical Exam</p>
            <p class="mt-1 text-slate-600">Built with Laravel 11, Blade, Tailwind CSS & MediaPipe Hands ML</p>
        </footer>
    </body>
</html>