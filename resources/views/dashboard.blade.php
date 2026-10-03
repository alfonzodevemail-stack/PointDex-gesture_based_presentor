<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ __('Presenter Dashboard') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    PointDex Optical Remote Telemetry & Deck Management
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('presentations.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-cyan-500 hover:to-blue-500 transition shadow-sm">
                    + New Presentation
                </a>
                <a href="{{ route('presentations.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    View All Decks
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- System Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Decks</span>
                        <span class="w-8 h-8 rounded-lg bg-cyan-100 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-bold text-sm">📁</span>
                    </div>
                    <div class="mt-3 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalDecks }}</div>
                    <p class="text-xs text-cyan-600 dark:text-cyan-400 mt-1">Managed via Eloquent ORM</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Ready To Present</span>
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-sm">✓</span>
                    </div>
                    <div class="mt-3 text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $readyDecks }}</div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Calibrated gesture thresholds</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Target Latency</span>
                        <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm">⚡</span>
                    </div>
                    <div class="mt-3 text-3xl font-extrabold text-blue-600 dark:text-blue-400">&lt; 80 ms</div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Non-blocking client-side loop</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">SUS Usability Goal</span>
                        <span class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-sm">★</span>
                    </div>
                    <div class="mt-3 text-3xl font-extrabold text-purple-600 dark:text-purple-400">&gt; 75.0</div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">ISO/IEC 25010 Quality Model</p>
                </div>
            </div>

            <!-- Recent Presentations Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Presentation Decks</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Select any deck to enter the gesture controller preview</p>
                    </div>
                    <a href="{{ route('presentations.index') }}" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:underline">
                        View All ({{ $totalDecks }}) &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-3">Deck Title</th>
                                <th class="px-6 py-3">Slides</th>
                                <th class="px-6 py-3">Sensitivity</th>
                                <th class="px-6 py-3">Cooldown</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentDecks as $deck)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $deck->title }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $deck->slide_count }} slides
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-mono">
                                            {{ $deck->sensitivity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-300">
                                        {{ $deck->cooldown_ms }}ms
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($deck->status === 'Ready')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400 font-medium">Ready</span>
                                        @elseif ($deck->status === 'Draft')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400 font-medium">Draft</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400 font-medium">Archived</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('presentations.show', $deck) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-semibold shadow-sm transition">
                                            ▶ Present
                                        </a>
                                        <a href="{{ route('presentations.edit', $deck) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium transition">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No presentations found. <a href="{{ route('presentations.create') }}" class="text-cyan-500 underline font-semibold">Create your first presentation</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Optical Gesture Quick Guide -->
            <div class="p-6 bg-gradient-to-r from-slate-900 to-slate-950 text-white rounded-2xl border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="font-bold text-base text-cyan-400">PointDex Hand Gesture Quick Reference</h4>
                    <p class="text-xs text-slate-400 mt-1">Position webcam 1.0m to 3.5m away in 300–500 lux lighting for optimal recognition accuracy.</p>
                </div>
                <div class="flex flex-wrap gap-4 text-xs font-mono">
                    <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700">👉 Swipe Right &rarr; Next Slide</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700">👈 Swipe Left &rarr; Prev Slide</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700">✊ Fist &rarr; F5 Fullscreen</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700">✋ Palm &rarr; Pause Screen</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>