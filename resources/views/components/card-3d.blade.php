@props([
    'dark' => false,
    'hoverable' => true,
    'class' => '',
])

<div class="tilt-card-container {{ $class }}">
    <div {{ $attributes->merge(['class' => 'tilt-card rounded-2xl p-6 sm:p-8 transition-all duration-300 relative overflow-hidden group ' . ($dark ? 'glass-card-dark text-offwhite hover:border-gold/50' : 'glass-card-light text-charcoal hover:border-gold/40')]) }}>
        <!-- Subtle gold inner ambient reflection on hover -->
        <div class="absolute -inset-full bg-gradient-to-tr from-gold/0 via-gold/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

        <div class="tilt-card-content relative z-10">
            {{ $slot }}
        </div>
    </div>
</div>

