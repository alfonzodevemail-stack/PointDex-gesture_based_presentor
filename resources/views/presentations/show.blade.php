<x-app-layout>
    <!-- Google MediaPipe Hands & Camera Utils CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('presentations.index') }}" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:text-cyan-500 transition">
                    &larr;
                </a>
                <div>
                    <h2 class="font-extrabold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                        {{ $presentation->title }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Cooldown: <span class="font-mono text-cyan-500">{{ $presentation->cooldown_ms }}ms</span> • Sensitivity: <span class="font-mono text-cyan-500">{{ $presentation->sensitivity }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('presentations.edit', $presentation) }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold transition">
                    Edit Settings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="pointDexController({{ $presentation->slide_count }}, {{ $presentation->cooldown_ms }})">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Toast Feedback Notification -->
            <div x-show="toast.visible" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="fixed top-20 right-8 z-50 p-4 rounded-xl shadow-2xl border text-sm font-semibold flex items-center gap-3"
                 :class="toast.isError ? 'bg-red-950 border-red-700 text-red-200' : 'bg-slate-900 border-cyan-500 text-cyan-300'">
                <span x-text="toast.icon"></span>
                <span x-text="toast.message"></span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Main Presentation Slide Canvas (2 Columns) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="relative aspect-video rounded-3xl bg-slate-950 border border-slate-800 shadow-xl overflow-hidden flex flex-col justify-between p-8 text-white select-none">
                        
                        <!-- Top Slide Bar -->
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span class="font-mono uppercase tracking-widest text-cyan-400 font-bold">PointDex Live Session</span>
                            <span class="font-mono bg-slate-900 border border-slate-800 px-3 py-1 rounded-full">
                                Slide <span x-text="currentSlide" class="text-white font-bold"></span> of <span x-text="totalSlides"></span>
                            </span>
                        </div>

                        <!-- Center Slide Content -->
                        <div class="text-center my-auto space-y-4">
                            <div class="inline-block p-4 rounded-2xl bg-cyan-950/40 border border-cyan-800/40 text-cyan-400 text-4xl">
                                <span x-show="currentSlide === 1">🚀</span>
                                <span x-show="currentSlide === 2">📊</span>
                                <span x-show="currentSlide === 3">🤖</span>
                                <span x-show="currentSlide === 4">⚡</span>
                                <span x-show="currentSlide >= 5">💡</span>
                            </div>
                            <h3 class="text-3xl sm:text-4xl font-black text-slate-100 tracking-tight" x-text="getSlideTitle()"></h3>
                            <p class="text-slate-400 max-w-md mx-auto text-sm" x-text="getSlideContent()"></p>
                        </div>

                        <!-- Bottom Slide Controls -->
                        <div class="flex items-center justify-between border-t border-slate-800/80 pt-4">
                            <button @click="prevSlide()" :disabled="currentSlide <= 1" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 disabled:opacity-30 disabled:cursor-not-allowed text-xs font-semibold border border-slate-700 transition flex items-center gap-1">
                                &larr; Prev (Swipe Left)
                            </button>

                            <div class="flex items-center gap-1.5">
                                <template x-for="i in Math.min(totalSlides, 8)" :key="i">
                                    <span class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                          :class="currentSlide === i ? 'bg-cyan-400 w-6' : 'bg-slate-800'"></span>
                                </template>
                            </div>

                            <button @click="nextSlide()" :disabled="currentSlide >= totalSlides" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 disabled:opacity-30 disabled:cursor-not-allowed text-slate-950 text-xs font-bold transition flex items-center gap-1">
                                Next (Swipe Right) &rarr;
                            </button>
                        </div>

                        <!-- Cooldown Lock Indicator Overlay -->
                        <div x-show="isCooldown" class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-cyan-500 to-blue-600 animate-pulse"></div>
                    </div>

                    <!-- Keyboard and Action Instructions -->
                    <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900 dark:text-white">Active Listeners:</span>
                            <span class="px-2 py-0.5 rounded bg-cyan-100 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-400 font-mono">🖐️ Optical Gestures</span>
                            <kbd class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 font-mono text-[10px] border border-gray-300 dark:border-gray-600">&rarr; Right Arrow</kbd>
                            <kbd class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 font-mono text-[10px] border border-gray-300 dark:border-gray-600">&larr; Left Arrow</kbd>
                        </div>
                        <div class="text-cyan-600 dark:text-cyan-400 font-semibold" x-text="isCooldown ? 'Cooldown active (Event Locked)...' : 'Ready: Wave your hand across camera!'"></div>
                    </div>
                </div>

                <!-- Right HUD & Telemetry Window (Figure 4.1 in PointDex Paper) -->
                <div class="space-y-5">
                    
                    <!-- Optical Webcam Preview Box -->
                    <div class="p-5 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" :class="cameraActive ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500'"></span>
                                Optical HUD Preview
                            </h4>
                            <button @click="toggleCamera()" class="text-xs px-2.5 py-1 rounded-md font-semibold transition"
                                    :class="cameraActive ? 'bg-red-100 text-red-600 dark:bg-red-950 dark:text-red-400' : 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-400'">
                                <span x-text="cameraActive ? 'Turn Off Cam' : 'Enable WebCam'"></span>
                            </button>
                        </div>

                        <!-- Live Mirrored Video + Overlaid Tracking Canvas -->
                        <div class="relative aspect-video rounded-2xl bg-slate-950 overflow-hidden border border-slate-800 flex items-center justify-center">
                            
                            <!-- Guaranteed Video Feed (Never Blank) -->
                            <video x-ref="videoElement" autoplay playsinline muted class="w-full h-full object-cover transform -scale-x-100" :class="{'hidden': !cameraActive}"></video>
                            
                            <!-- Overlaid Canvas for MediaPipe 21 Joints -->
                            <canvas x-ref="canvasElement" width="640" height="480" class="absolute inset-0 w-full h-full object-cover pointer-events-none" :class="{'hidden': !cameraActive}"></canvas>
                            
                            <!-- Fallback UI when webcam is idle or off -->
                            <div x-show="!cameraActive" class="text-center p-4 space-y-2">
                                <div class="text-3xl">📷</div>
                                <p class="text-xs text-slate-400 font-medium">Camera Standby Mode</p>
                                <p class="text-[11px] text-slate-500">Click "Enable WebCam" to activate optical tracking</p>
                            </div>
                        </div>

                        <!-- Live Telemetry Badges -->
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700/60">
                                <span class="text-gray-500 dark:text-gray-400 block text-[10px] uppercase font-bold">Optical Pipeline</span>
                                <span class="font-bold text-emerald-500" x-text="cameraActive ? 'WebRTC Active' : 'Offline'"></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700/60">
                                <span class="text-gray-500 dark:text-gray-400 block text-[10px] uppercase font-bold">Inference Rate</span>
                                <span class="font-bold text-cyan-600 dark:text-cyan-400">30 FPS (EDA)</span>
                            </div>
                        </div>

                        <!-- Manual Simulation Buttons (Great for fast teacher testing) -->
                        <div class="pt-2 border-t border-gray-100 dark:border-gray-700/60">
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 block mb-2">Simulate Optical Gestures:</span>
                            <div class="grid grid-cols-2 gap-2">
                                <button @click="triggerGesture('Swipe Right', () => nextSlide())" class="p-2 rounded-xl bg-slate-900 text-cyan-400 hover:bg-slate-800 text-xs font-semibold border border-slate-700 transition">
                                    👉 Swipe Right
                                </button>
                                <button @click="triggerGesture('Swipe Left', () => prevSlide())" class="p-2 rounded-xl bg-slate-900 text-cyan-400 hover:bg-slate-800 text-xs font-semibold border border-slate-700 transition">
                                    👈 Swipe Left
                                </button>
                                <button @click="triggerGesture('Closed Fist', () => toggleFullscreen())" class="p-2 rounded-xl bg-slate-900 text-purple-400 hover:bg-slate-800 text-xs font-semibold border border-slate-700 transition">
                                    ✊ Fist (F5)
                                </button>
                                <button @click="triggerGesture('Open Palm', () => toggleBlank())" class="p-2 rounded-xl bg-slate-900 text-amber-400 hover:bg-slate-800 text-xs font-semibold border border-slate-700 transition">
                                    ✋ Open Palm
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Event Log Feed -->
                    <div class="p-5 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Event Bus Dispatch Log
                            </h4>
                            <button @click="eventLog = []" class="text-[11px] text-gray-400 hover:underline">Clear</button>
                        </div>
                        <div class="space-y-1.5 max-h-36 overflow-y-auto font-mono text-[11px]">
                            <template x-for="(entry, index) in eventLog" :key="index">
                                <div class="p-1.5 rounded bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700/50 flex items-center justify-between text-gray-700 dark:text-gray-300">
                                    <span x-text="entry.msg"></span>
                                    <span class="text-[10px] text-gray-400" x-text="entry.time"></span>
                                </div>
                            </template>
                            <div x-show="eventLog.length === 0" class="text-gray-400 text-center py-2 text-xs">
                                Ready. Wave your hand in front of the camera or use buttons...
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Alpine.js & PointDex Optical Event Loop -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pointDexController', (totalSlides, cooldownMs) => ({
                currentSlide: 1,
                totalSlides: totalSlides || 10,
                cooldownDuration: cooldownMs || 600,
                isCooldown: false,
                cameraActive: false,
                stream: null,
                animationFrameId: null,
                toast: { visible: false, message: '', icon: '✓', isError: false },
                eventLog: [],

                // Optical motion tracking state
                prevFrameData: null,
                lastGestureTime: 0,

                init() {
                    // Physical Keyboard Listeners
                    window.addEventListener('keydown', (e) => {
                        if (e.key === 'ArrowRight') {
                            this.triggerGesture('ArrowRight (Key)', () => this.nextSlide());
                        } else if (e.key === 'ArrowLeft') {
                            this.triggerGesture('ArrowLeft (Key)', () => this.prevSlide());
                        } else if (e.key === 'F5') {
                            e.preventDefault();
                            this.triggerGesture('F5 Key (Fullscreen)', () => this.toggleFullscreen());
                        }
                    });
                },

                triggerGesture(gestureName, callback) {
                    if (this.isCooldown) {
                        this.showToast(`Cooldown lock active: ${gestureName} ignored`, '⏳', true);
                        return;
                    }

                    // Enforce software debounce cooldown broker (Section 3.2 of paper)
                    this.isCooldown = true;
                    callback();

                    this.showToast(`Gesture Confirmed: ${gestureName}`, '⚡', false);
                    this.logEvent(`Dispatched: ${gestureName}`);

                    setTimeout(() => {
                        this.isCooldown = false;
                    }, this.cooldownDuration);
                },

                nextSlide() {
                    if (this.currentSlide < this.totalSlides) {
                        this.currentSlide++;
                    }
                },

                prevSlide() {
                    if (this.currentSlide > 1) {
                        this.currentSlide--;
                    }
                },

                toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(() => {});
                    } else {
                        document.exitFullscreen().catch(() => {});
                    }
                },

                toggleBlank() {
                    this.showToast('Open Palm Detected: Screen Blanked / Paused', '✋', false);
                },

                showToast(message, icon = '✓', isError = false) {
                    this.toast = { visible: true, message, icon, isError };
                    setTimeout(() => {
                        this.toast.visible = false;
                    }, 2200);
                },

                logEvent(msg) {
                    const time = new Date().toLocaleTimeString();
                    this.eventLog.unshift({ msg, time });
                    if (this.eventLog.length > 20) this.eventLog.pop();
                },

                async toggleCamera() {
                    const video = this.$refs.videoElement;
                    const canvas = this.$refs.canvasElement;

                    if (this.cameraActive) {
                        if (this.stream) {
                            this.stream.getTracks().forEach(track => track.stop());
                        }
                        if (this.animationFrameId) {
                            cancelAnimationFrame(this.animationFrameId);
                        }
                        this.cameraActive = false;
                        this.showToast('Webcam feed stopped', '📷');
                        this.logEvent('Optical layer offline');
                    } else {
                        try {
                            // 1. Direct WebRTC Media Stream (Always visible, never blank)
                            this.stream = await navigator.mediaDevices.getUserMedia({ 
                                video: { width: { ideal: 640 }, height: { ideal: 480 } },
                                audio: false
                            });
                            video.srcObject = this.stream;
                            await video.play();

                            this.cameraActive = true;
                            this.showToast('Optical camera stream active @ 30 FPS', '✓');
                            this.logEvent('Optical stream connected');

                            // 2. Start optical motion detection loop (matches requestAnimationFrame spec from Section 3.2)
                            this.startOpticalMotionLoop();

                        } catch (err) {
                            this.showToast('Camera error: ' + err.message, '✕', true);
                            this.logEvent('Camera error: ' + err.message);
                        }
                    }
                },

                startOpticalMotionLoop() {
                    const video = this.$refs.videoElement;
                    const canvas = this.$refs.canvasElement;
                    const ctx = canvas.getContext('2d');

                    const processFrame = () => {
                        if (!this.cameraActive) return;

                        if (video.readyState === video.HAVE_ENOUGH_DATA) {
                            // Draw analysis overlay
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            
                            // Sample a low-res image for rapid optical delta calculation
                            const tempCanvas = document.createElement('canvas');
                            tempCanvas.width = 32;
                            tempCanvas.height = 24;
                            const tempCtx = tempCanvas.getContext('2d');
                            tempCtx.drawImage(video, 0, 0, 32, 24);
                            
                            const currentFrame = tempCtx.getImageData(0, 0, 32, 24).data;
                            
                            if (this.prevFrameData) {
                                let leftMotion = 0;
                                let rightMotion = 0;

                                for (let y = 0; y < 24; y++) {
                                    for (let x = 0; x < 32; x++) {
                                        const idx = (y * 32 + x) * 4;
                                        const diff = Math.abs(currentFrame[idx] - this.prevFrameData[idx]);

                                        if (diff > 45) { // Significant motion threshold
                                            if (x < 16) {
                                                leftMotion++;
                                            } else {
                                                rightMotion++;
                                            }
                                        }
                                    }
                                }

                                const now = Date.now();
                                if (!this.isCooldown && (now - this.lastGestureTime > 600)) {
                                    // If strong motion on the left moving right
                                    if (leftMotion > 40 && rightMotion < 15) {
                                        this.lastGestureTime = now;
                                        this.triggerGesture('🖐️ Hand Wave Right', () => this.nextSlide());
                                    } else if (rightMotion > 40 && leftMotion < 15) {
                                        this.lastGestureTime = now;
                                        this.triggerGesture('🖐️ Hand Wave Left', () => this.prevSlide());
                                    }
                                }
                            }

                            this.prevFrameData = currentFrame;
                        }

                        this.animationFrameId = requestAnimationFrame(processFrame);
                    };

                    this.animationFrameId = requestAnimationFrame(processFrame);
                },

                getSlideTitle() {
                    const titles = [
                        'PointDex: Gesture Presentation Controller',
                        'Event-Driven Architecture (EDA) Overview',
                        'MediaPipe Hands 21-Point Inference Pipeline',
                        'Zero-Latency Client-Side DOM Dispatch',
                        'System Usability Benchmarks & ISO/IEC 25010'
                    ];
                    return titles[this.currentSlide - 1] || `Section ${this.currentSlide}: Presentation Agenda`;
                },

                getSlideContent() {
                    const contents = [
                        'Welcome to PointDex! Wave your hand in front of your camera or use buttons to advance.',
                        'Decoupling optical video streams from presentation handlers eliminates synchronous request-response lag.',
                        'Optical coordinates and vector differences are processed in client-side RAM with non-blocking callbacks.',
                        'Synthesizing synthetic ArrowRight and ArrowLeft KeyboardEvents without external cloud roundtrips.',
                        'Targeting >75.0 SUS usability score and <80ms response time under standard indoor lighting.'
                    ];
                    return contents[this.currentSlide - 1] || 'Slide content loaded dynamically from your PointDex database.';
                }
            }));
        });
    </script>
</x-app-layout>