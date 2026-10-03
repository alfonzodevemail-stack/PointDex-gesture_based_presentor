<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ __('Presentation Decks (CRUD Module)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Manage your gesture-calibrated slide decks and event configurations
                </p>
            </div>
            <a href="{{ route('presentations.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-cyan-500 hover:to-blue-500 transition shadow-sm">
                + Create Presentation
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert Notification -->
            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">✓</span>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-xs text-emerald-500 hover:underline">Dismiss</button>
                </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('presentations.index') }}" class="flex items-center gap-2 w-full sm:w-96">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by title or status..." 
                        class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-cyan-500 focus:ring-cyan-500"
                    />
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold transition">
                        Filter
                    </button>
                    @if (request('search'))
                        <a href="{{ route('presentations.index') }}" class="text-xs text-gray-500 hover:underline">Reset</a>
                    @endif
                </form>

                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Showing <span class="font-bold text-gray-900 dark:text-white">{{ $presentations->count() }}</span> of {{ $presentations->total() }} records
                </div>
            </div>

            <!-- Presentations Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4">Title & Description</th>
                                <th class="px-6 py-4">Slides</th>
                                <th class="px-6 py-4">Sensitivity</th>
                                <th class="px-6 py-4">Cooldown</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($presentations as $deck)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-base">
                                            {{ $deck->title }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5">
                                            {{ $deck->description ?? 'No topic description provided.' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-300">
                                        {{ $deck->slide_count }} slides
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs rounded-md font-mono 
                                            @if($deck->sensitivity === 'High') bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-400
                                            @elseif($deck->sensitivity === 'Medium') bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-400
                                            @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ $deck->sensitivity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-300">
                                        {{ $deck->cooldown_ms }}ms
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($deck->status === 'Ready')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400 font-semibold">Ready</span>
                                        @elseif ($deck->status === 'Draft')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400 font-semibold">Draft</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400 font-semibold">Archived</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('presentations.show', $deck) }}" class="px-3 py-1.5 rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-semibold shadow-sm transition">
                                                ▶ Present
                                            </a>
                                            <a href="{{ route('presentations.edit', $deck) }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium transition">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('presentations.destroy', $deck) }}" onsubmit="return confirm('Are you sure you want to delete this presentation deck?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-950 hover:bg-red-200 dark:hover:bg-red-900 text-red-600 dark:text-red-400 text-xs font-medium transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        No presentations match your search criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                @if ($presentations->hasPages())
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $presentations->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>