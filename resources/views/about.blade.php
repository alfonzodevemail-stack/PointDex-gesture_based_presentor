<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About PointDex — Gesture-Based Presentation Architecture</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-cyan-500 selection:text-white">
        <!-- Navigation Header -->
        <header class="border-b border-slate-800/80 backdrop-blur-md sticky top-0 z-50 bg-slate-950/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-cyan-500/30">
                            P
                        </div>
                        <div>
                            <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">PointDex</span>
                        </div>
                    </a>
                </div>

                <nav class="flex items-center space-x-4 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-slate-300 hover:text-cyan-400 transition">Home</a>
                    <a href="{{ route('about') }}" class="text-cyan-400 font-semibold border-b-2 border-cyan-400 pb-1">About System</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-cyan-400 transition">Dashboard</a>
                        <a href="{{ route('presentations.index') }}" class="px-3.5 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold transition">
                            Presentations
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-cyan-400 transition">Log in</a>
                        <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold transition">
                            Get Started
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
            <!-- Header Section -->
            <div class="border-b border-slate-800 pb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/70 border border-cyan-800/80 text-xs font-semibold text-cyan-400 mb-4">
                    Research Proposal & System Documentation
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-100">
                    PointDex Architecture & Literature Review
                </h1>
                <p class="text-slate-400 text-base sm:text-lg mt-3">
                    A client-side Event-Driven Architecture (EDA) transforming continuous optical video streams into deterministic DOM presentation controls.
                </p>
                <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-400">
                    <span class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800">Lead Researchers: Khobe Clayne Lolong, I-Chieh Hung, Alfonzo Balagapo, Xer Ruie Morales</span>
                    <span class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800">Track: Software Engineering & Benchmarking</span>
                </div>
            </div>

            <!-- Problem Statement vs Solution -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-2xl bg-slate-900/60 border border-red-900/30">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-950 text-red-400 flex items-center justify-center font-bold">✕</div>
                        <h2 class="text-lg font-bold text-slate-200">The Problem: Synchronous Bottlenecks</h2>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Traditional request-response models and synchronous hardware polling block the execution thread, causing input lag, single points of failure, and interface freeze during high-concurrency video frame analysis. Furthermore, reliance on physical Bluetooth presentation remotes incurs constant battery consumption and hardware failure.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900/60 border border-cyan-900/30">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-cyan-950 text-cyan-400 flex items-center justify-center font-bold">✓</div>
                        <h2 class="text-lg font-bold text-slate-200">The Solution: PointDex Event Loop</h2>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        PointDex decouples camera capture from presentation triggers via an in-browser Pub/Sub pipeline. By running the MediaPipe Hands ML model through WebAssembly (WASM) and WebGL directly in browser RAM, it achieves sub-80ms response latency with zero cloud transmission or video storage.
                    </p>
                </div>
            </div>

            <!-- 4-Layer Architecture Breakdown -->
            <div class="p-8 rounded-3xl bg-slate-900/40 border border-slate-800 space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-100">Decoupled 4-Layer System Pipeline</h2>
                    <p class="text-sm text-slate-400 mt-1">Based on Figure 3.1: Event-Driven Architectural Diagram and Pub/Sub Pipeline</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                        <span class="text-xs font-mono text-cyan-400 font-bold">LAYER 1</span>
                        <h3 class="font-bold text-slate-200">Optical Producer</h3>
                        <p class="text-xs text-slate-400">Captures raw 720p/1080p webcam frames @ 30 FPS via <code class="text-cyan-300">getUserMedia()</code> non-blocking loop.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                        <span class="text-xs font-mono text-cyan-400 font-bold">LAYER 2</span>
                        <h3 class="font-bold text-slate-200">ML Inference</h3>
                        <p class="text-xs text-slate-400">Extracts 21 normalized 3D hand coordinates locally using Google MediaPipe Hands WASM.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                        <span class="text-xs font-mono text-cyan-400 font-bold">LAYER 3</span>
                        <h3 class="font-bold text-slate-200">Event Bus & Cooldown</h3>
                        <p class="text-xs text-slate-400">Calculates coordinate delta vectors with a 600ms–1500ms software debounce throttle to prevent double-skips.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                        <span class="text-xs font-mono text-cyan-400 font-bold">LAYER 4</span>
                        <h3 class="font-bold text-slate-200">Presentation Handler</h3>
                        <p class="text-xs text-slate-400">Subscribes to validated gestures and synthesizes native DOM <code class="text-cyan-300">KeyboardEvent</code> (ArrowRight / ArrowLeft / F5).</p>
                    </div>
                </div>
            </div>

            <!-- UN SDG Alignment & Ethical Compliance -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-400">UN SDG 9 & 12 Alignment</div>
                    <h3 class="text-lg font-bold text-slate-200">Sustainable Zero-Hardware Computing</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        By repurposing standard pre-installed laptop webcams as presentation clickers, PointDex eliminates electronic waste generated by disposable alkaline batteries and single-use plastic remote peripherals.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-purple-400">RA 10173 Compliance</div>
                    <h3 class="text-lg font-bold text-slate-200">Data Privacy & Local In-Memory Inference</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Under the Philippine Data Privacy Act of 2012, all video stream processing occurs exclusively in client RAM. No video frames, screenshots, or biometric identifiers are saved or transmitted to external servers.
                    </p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-800/80 py-8 text-center text-xs text-slate-500">
            <p>PointDex Project • ITCC3101 Midterm Practical Exam</p>
        </footer>
    </body>
</html>