@props([
    'subtitle' => null,
    'title' => '',
    'titleAccent' => null,
    'description' => null,
    'align' => 'center',
    'dark' => false,
])

<div {{ $attributes->merge(['class' => 'max-w-3xl mb-16 ' . ($align === 'center' ? 'mx-auto text-center' : ($align === 'right' ? 'ml-auto text-right' : 'text-left'))]) }} data-reveal="up">
    @if($subtitle)
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest mb-4 {{ $dark ? 'bg-gold/15 text-gold-light border border-gold/30' : 'bg-gold/10 text-gold-dark border border-gold/20' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
            <span>{{ $subtitle }}</span>
        </div>
    @endif

    <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight leading-tight {{ $dark ? 'text-offwhite' : 'text-charcoal' }}">
        {{ $title }}
        @if($titleAccent)
            <span class="text-gold-gradient italic font-serif">{{ $titleAccent }}</span>
        @endif
    </h2>

    @if($description)
        <p class="mt-4 text-base sm:text-lg leading-relaxed {{ $dark ? 'text-offwhite/70' : 'text-charcoal/70' }}">
            {{ $description }}
        </p>
    @endif

    <!-- Decorative Gold Accent Line -->
    <div class="mt-5 flex items-center {{ $align === 'center' ? 'justify-center' : ($align === 'right' ? 'justify-end' : 'justify-start') }} space-x-2">
        <span class="h-[1px] w-12 bg-gold/40"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
        <span class="h-[1px] w-6 bg-gold/20"></span>
    </div>
</div>

