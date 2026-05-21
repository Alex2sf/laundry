{{-- Onboarding Tour Component --}}
{{-- Usage: <x-onboarding-tour :steps="$tourSteps" tour-id="dashboard" /> --}}
@props(['tourId' => 'default', 'steps' => [], 'autoStart' => false])

<script>
    window.__tourSteps_{{ str_replace('-', '_', $tourId) }} = {!! json_encode($steps, JSON_UNESCAPED_UNICODE) !!};
</script>

<div x-data="onboardingTour('{{ $tourId }}', window.__tourSteps_{{ str_replace('-', '_', $tourId) }}, {{ $autoStart ? 'true' : 'false' }})"
     x-init="init()"
     x-cloak
     id="onboarding-tour-{{ $tourId }}">



    {{-- Backdrop Overlay --}}
    <template x-if="isActive">
        <div class="tour-backdrop" x-show="isActive" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Spotlight cutout - positioned dynamically --}}
            <div class="tour-spotlight" :style="spotlightStyle" x-show="currentStep >= 0"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100">
            </div>
        </div>
    </template>

    {{-- Tooltip / Guide Card --}}
    <template x-if="isActive && currentStep >= 0">
        <div class="tour-tooltip" :style="tooltipStyle" :class="'tour-tooltip-' + tooltipPosition"
             x-show="showTooltip"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4">

            {{-- Progress indicator --}}
            <div class="tour-progress">
                <div class="tour-progress-bar">
                    <div class="tour-progress-fill" :style="'width: ' + progressPercent + '%'"></div>
                </div>
                <span class="tour-progress-text" x-text="'Step ' + (currentStep + 1) + ' / ' + totalSteps"></span>
            </div>

            {{-- Icon + Content --}}
            <div class="tour-content">
                <div class="tour-icon-wrap" :style="'background: ' + currentStepData.iconBg">
                    <span class="tour-icon" x-html="currentStepData.icon"></span>
                </div>
                <div class="tour-text">
                    <h4 class="tour-title" x-text="currentStepData.title"></h4>
                    <p class="tour-description" x-text="currentStepData.description"></p>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="tour-actions">
                <button @click="skipTour()" class="tour-btn-skip" type="button">
                    Lewati Tour
                </button>
                <div class="tour-nav-btns">
                    <button @click="prevStep()" x-show="currentStep > 0" class="tour-btn-prev" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali
                    </button>
                    <button @click="nextStep()" class="tour-btn-next" type="button">
                        <span x-text="isLastStep ? '🎉 Selesai!' : 'Lanjut'"></span>
                        <svg x-show="!isLastStep" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Step dots --}}
            <div class="tour-dots">
                <template x-for="(step, idx) in steps" :key="idx">
                    <button @click="goToStep(idx)" class="tour-dot" :class="{ 'active': idx === currentStep, 'completed': idx < currentStep }" type="button"></button>
                </template>
            </div>
        </div>
    </template>

    {{-- Welcome Modal (shown before tour starts) --}}
    <template x-if="showWelcome">
        <div class="tour-welcome-overlay" x-show="showWelcome"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="tour-welcome-card"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                {{-- Animated washing machine icon --}}
                <div class="tour-welcome-icon">
                    <div class="tour-washing-machine">
                        <div class="tour-washing-door">
                            <div class="tour-washing-glass">
                                <div class="tour-washing-water"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="tour-welcome-title">
                    Selamat Datang di <span class="text-gradient">LaundryPOS</span>! 🎉
                </h2>
                <p class="tour-welcome-subtitle">
                    Hai <strong>{{ auth()->user()->name ?? 'Boss' }}</strong>! Mari kita kenalan dengan fitur-fitur keren
                    yang akan membantu bisnis laundry kamu makin lancar jaya!
                </p>

                <div class="tour-welcome-features">
                    <div class="tour-feature-item">
                        <span class="tour-feature-icon">📊</span>
                        <span>Dashboard & Analitik</span>
                    </div>
                    <div class="tour-feature-item">
                        <span class="tour-feature-icon">🧺</span>
                        <span>Manajemen Order</span>
                    </div>
                    <div class="tour-feature-item">
                        <span class="tour-feature-icon">👥</span>
                        <span>Data Pelanggan</span>
                    </div>
                    <div class="tour-feature-item">
                        <span class="tour-feature-icon">💰</span>
                        <span>Laporan Keuangan</span>
                    </div>
                </div>

                <div class="tour-welcome-actions">
                    <button @click="startTour()" class="tour-btn-start" type="button">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mulai Tour Interaktif
                    </button>
                    <button @click="dismissWelcome()" class="tour-btn-later" type="button">
                        Nanti Aja 👋
                    </button>
                </div>

                <p class="tour-welcome-hint">
                    💡 Tour bisa diakses kapan aja lewat tombol <strong>"?"</strong> di pojok bawah
                </p>
            </div>
        </div>
    </template>

    {{-- Floating Help Button (always visible when tour is not active) --}}
    <button x-show="!isActive && !showWelcome" @click="restartTour()" class="tour-help-btn"
            x-transition:enter="transition ease-out duration-300 delay-500"
            x-transition:enter-start="opacity-0 scale-0"
            x-transition:enter-end="opacity-100 scale-100"
            title="Mulai Tour Panduan"
            type="button">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </button>

    {{-- Completion Celebration --}}
    <template x-if="showCelebration">
        <div class="tour-celebration-overlay"
             x-show="showCelebration"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">

            {{-- Confetti particles --}}
            <div class="tour-confetti-container">
                <template x-for="i in 50" :key="i">
                    <div class="tour-confetti-piece" :style="confettiStyle(i)"></div>
                </template>
            </div>

            <div class="tour-celebration-card"
                 x-transition:enter="transition ease-out duration-600 delay-200"
                 x-transition:enter-start="opacity-0 scale-50"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="tour-celebration-emoji">🏆</div>
                <h2 class="tour-celebration-title">Tour Selesai!</h2>
                <p class="tour-celebration-text">
                    Mantap! Kamu sudah siap mengelola bisnis laundry dengan LaundryPOS.
                    <br>Semoga sukses dan laris manis! 🚀
                </p>
                <button @click="closeCelebration()" class="tour-btn-start" type="button">
                    Mulai Kerja! 💪
                </button>
            </div>
        </div>
    </template>
</div>

<script>
function onboardingTour(tourId, steps, autoStart) {
    return {
        tourId: tourId,
        steps: steps,
        isActive: false,
        showWelcome: false,
        showTooltip: false,
        showCelebration: false,
        currentStep: -1,
        spotlightStyle: '',
        tooltipStyle: '',
        tooltipPosition: 'bottom',
        resizeObserver: null,

        get totalSteps() { return this.steps.length; },
        get isLastStep() { return this.currentStep === this.steps.length - 1; },
        get progressPercent() { return ((this.currentStep + 1) / this.steps.length) * 100; },
        get currentStepData() {
            return this.steps[this.currentStep] || { title: '', description: '', icon: '', iconBg: 'linear-gradient(135deg, #0ea5e9, #06b6d4)' };
        },

        init() {
            const tourDone = localStorage.getItem('tour_completed_' + this.tourId);
            if (!tourDone && autoStart) {
                this.$nextTick(() => {
                    setTimeout(() => { this.showWelcome = true; }, 800);
                });
            }
        },

        startTour() {
            this.showWelcome = false;
            this.isActive = true;
            this.currentStep = 0;
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => this.positionElements());
        },

        restartTour() {
            this.showWelcome = true;
        },

        dismissWelcome() {
            this.showWelcome = false;
            localStorage.setItem('tour_completed_' + this.tourId, 'true');
        },

        nextStep() {
            if (this.isLastStep) {
                this.completeTour();
                return;
            }
            this.showTooltip = false;
            setTimeout(() => {
                this.currentStep++;
                this.$nextTick(() => this.positionElements());
            }, 250);
        },

        prevStep() {
            if (this.currentStep <= 0) return;
            this.showTooltip = false;
            setTimeout(() => {
                this.currentStep--;
                this.$nextTick(() => this.positionElements());
            }, 250);
        },

        goToStep(idx) {
            this.showTooltip = false;
            setTimeout(() => {
                this.currentStep = idx;
                this.$nextTick(() => this.positionElements());
            }, 250);
        },

        skipTour() {
            this.isActive = false;
            this.showTooltip = false;
            this.currentStep = -1;
            document.body.style.overflow = '';
            localStorage.setItem('tour_completed_' + this.tourId, 'true');
        },

        completeTour() {
            this.isActive = false;
            this.showTooltip = false;
            this.currentStep = -1;
            document.body.style.overflow = '';
            localStorage.setItem('tour_completed_' + this.tourId, 'true');
            this.showCelebration = true;
        },

        closeCelebration() {
            this.showCelebration = false;
        },

        positionElements() {
            const step = this.steps[this.currentStep];
            if (!step) return;

            const target = document.querySelector(step.target);
            if (!target) {
                // If target doesn't exist, create a virtual center spotlight
                this.spotlightStyle = 'position:fixed;top:50%;left:50%;width:300px;height:200px;transform:translate(-50%,-50%);';
                this.tooltipStyle = 'position:fixed;top:50%;left:50%;transform:translate(-50%,20px);';
                this.tooltipPosition = 'bottom';
                this.showTooltip = true;
                return;
            }

            // Scroll into view
            target.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });

            setTimeout(() => {
                const rect = target.getBoundingClientRect();
                const padding = 12;
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                const scrollX = window.scrollX || document.documentElement.scrollLeft;

                // Position the spotlight
                this.spotlightStyle = `
                    position: fixed;
                    top: ${rect.top - padding}px;
                    left: ${rect.left - padding}px;
                    width: ${rect.width + padding * 2}px;
                    height: ${rect.height + padding * 2}px;
                `;

                // Calculate tooltip position
                const tooltipWidth = 380;
                const tooltipHeight = 260;
                const margin = 16;
                const viewportH = window.innerHeight;
                const viewportW = window.innerWidth;

                let top, left;
                let position = step.position || 'auto';

                if (position === 'auto') {
                    const spaceBelow = viewportH - rect.bottom;
                    const spaceAbove = rect.top;
                    const spaceRight = viewportW - rect.right;
                    const spaceLeft = rect.left;

                    if (spaceBelow >= tooltipHeight + margin) {
                        position = 'bottom';
                    } else if (spaceAbove >= tooltipHeight + margin) {
                        position = 'top';
                    } else if (spaceRight >= tooltipWidth + margin) {
                        position = 'right';
                    } else if (spaceLeft >= tooltipWidth + margin) {
                        position = 'left';
                    } else {
                        position = 'bottom';
                    }
                }

                switch (position) {
                    case 'bottom':
                        top = rect.bottom + margin;
                        left = rect.left + rect.width / 2 - tooltipWidth / 2;
                        break;
                    case 'top':
                        top = rect.top - tooltipHeight - margin;
                        left = rect.left + rect.width / 2 - tooltipWidth / 2;
                        break;
                    case 'right':
                        top = rect.top + rect.height / 2 - tooltipHeight / 2;
                        left = rect.right + margin;
                        break;
                    case 'left':
                        top = rect.top + rect.height / 2 - tooltipHeight / 2;
                        left = rect.left - tooltipWidth - margin;
                        break;
                }

                // Clamp within viewport
                left = Math.max(margin, Math.min(left, viewportW - tooltipWidth - margin));
                top = Math.max(margin, Math.min(top, viewportH - tooltipHeight - margin));

                this.tooltipPosition = position;
                this.tooltipStyle = `position:fixed;top:${top}px;left:${left}px;width:${tooltipWidth}px;`;
                this.showTooltip = true;

                // Add highlight class to target
                document.querySelectorAll('.tour-target-highlight').forEach(el => el.classList.remove('tour-target-highlight'));
                target.classList.add('tour-target-highlight');
            }, 400);
        },

        confettiStyle(i) {
            const colors = ['#0ea5e9', '#06b6d4', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#ec4899', '#f97316'];
            const color = colors[i % colors.length];
            const left = Math.random() * 100;
            const delay = Math.random() * 3;
            const duration = 2 + Math.random() * 3;
            const size = 6 + Math.random() * 8;
            const rotation = Math.random() * 360;
            return `
                position:absolute;
                left:${left}%;
                top:-10px;
                width:${size}px;
                height:${size}px;
                background:${color};
                border-radius:${Math.random() > 0.5 ? '50%' : '2px'};
                animation:confettiFall ${duration}s ${delay}s ease-in forwards;
                transform:rotate(${rotation}deg);
            `;
        }
    }
}
</script>
