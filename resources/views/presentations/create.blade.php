<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ __('Create Presentation Deck') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Register a new slide deck for PointDex gesture navigation
                </p>
            </div>
            <a href="{{ route('presentations.index') }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-cyan-500 transition">
                &larr; Back to Decks
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                
                <form method="POST" action="{{ route('presentations.store') }}" class="space-y-6">
                    @csrf

                    <!-- Deck Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Presentation Title <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title') }}" 
                            placeholder="e.g., Event-Driven Architecture Capstone Defense"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                            required
                        />
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Topic Overview / Presentation Notes
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="3" 
                            placeholder="Briefly describe the presentation objectives or slide agenda..."
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Total Slides -->
                        <div>
                            <label for="slide_count" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Total Slide Count <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="slide_count" 
                                id="slide_count" 
                                value="{{ old('slide_count', 10) }}" 
                                min="1" 
                                max="200"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                                required
                            />
                            @error('slide_count')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sensitivity -->
                        <div>
                            <label for="sensitivity" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Gesture Sensitivity <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="sensitivity" 
                                id="sensitivity" 
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                            >
                                <option value="Low" {{ old('sensitivity') === 'Low' ? 'selected' : '' }}>Low (Broad hand motions)</option>
                                <option value="Medium" {{ old('sensitivity', 'Medium') === 'Medium' ? 'selected' : '' }}>Medium (Recommended default)</option>
                                <option value="High" {{ old('sensitivity') === 'High' ? 'selected' : '' }}>High (Subtle finger flicks)</option>
                            </select>
                            @error('sensitivity')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Cooldown Throttle -->
                        <div>
                            <label for="cooldown_ms" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Cooldown Throttle (ms) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="cooldown_ms" 
                                id="cooldown_ms" 
                                value="{{ old('cooldown_ms', 600) }}" 
                                min="200" 
                                max="3000" 
                                step="50"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                                required
                            />
                            <p class="mt-1 text-xs text-gray-500">Refractory window (600ms default) to prevent double-skips.</p>
                            @error('cooldown_ms')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Deck Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                            >
                                <option value="Ready" {{ old('status', 'Ready') === 'Ready' ? 'selected' : '' }}>Ready to Present</option>
                                <option value="Draft" {{ old('status') === 'Draft' ? 'selected' : '' }}>Draft Mode</option>
                                <option value="Archived" {{ old('status') === 'Archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('presentations.index') }}" class="px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:underline">
                            Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white text-xs font-bold uppercase tracking-wider transition shadow-sm">
                            Save Presentation
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>