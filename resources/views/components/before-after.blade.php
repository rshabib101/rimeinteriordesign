@props([
    'beforeImage',
    'afterImage',
    'title' => 'Space Transformation',
    'beforeLabel' => 'Before',
    'afterLabel' => 'After',
])

<div
    x-data="{
        position: 50,
        dragging: false,
        updatePosition(clientX) {
            const rect = this.$refs.container.getBoundingClientRect();
            const pct = ((clientX - rect.left) / rect.width) * 100;
            this.position = Math.max(5, Math.min(95, pct));
        }
    }"
    x-ref="container"
    @mousedown="dragging = true; updatePosition($event.clientX)"
    @mousemove.window="if (dragging) updatePosition($event.clientX)"
    @mouseup.window="dragging = false"
    @touchstart.passive="dragging = true; updatePosition($event.touches[0].clientX)"
    @touchmove.window="if (dragging) updatePosition($event.touches[0].clientX)"
    @touchend.window="dragging = false"
    class="relative w-full h-[360px] sm:h-[480px] rounded-2xl overflow-hidden select-none cursor-ew-resize border border-white/10 shadow-2xl group"
>
    <!-- After Image (Base Full Width) -->
    <img
        src="{{ \App\Support\MediaHelper::url($afterImage) }}"
        alt="{{ $title }} - {{ $afterLabel }}"
        class="absolute inset-0 w-full h-full object-cover pointer-events-none"
        loading="lazy"
    />

    <!-- Before Image (Clipped Overlay) -->
    <div
        class="absolute inset-0 overflow-hidden pointer-events-none"
        :style="`clip-path: inset(0 ${100 - position}% 0 0);`"
    >
        <img
            src="{{ \App\Support\MediaHelper::url($beforeImage) }}"
            alt="{{ $title }} - {{ $beforeLabel }}"
            class="absolute inset-0 w-full h-full object-cover"
            loading="lazy"
        />
    </div>

    <!-- Labels -->
    <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-charcoal-deep/80 backdrop-blur-md text-[11px] font-bold uppercase tracking-widest text-offwhite border border-white/15 pointer-events-none">
        {{ $beforeLabel }}
    </span>
    <span class="absolute top-4 right-4 px-3 py-1 rounded-full bg-gold/90 backdrop-blur-md text-[11px] font-bold uppercase tracking-widest text-charcoal-deep shadow-lg pointer-events-none">
        {{ $afterLabel }}
    </span>

    <!-- Divider Handle -->
    <div
        class="absolute top-0 bottom-0 w-0.5 bg-gold shadow-[0_0_15px_rgba(184,137,77,0.9)] pointer-events-none"
        :style="`left: ${position}%;`"
    >
        <div class="absolute top-1/2 -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-gold text-charcoal-deep flex items-center justify-center shadow-2xl border-2 border-offwhite transition-transform group-hover:scale-110">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l-3 3 3 3m8-6l3 3-3 3" />
            </svg>
        </div>
    </div>
</div>

