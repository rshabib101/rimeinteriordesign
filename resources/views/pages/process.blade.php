@extends('layouts.app', ['metaTitle' => 'Our Process | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Turnkey Methodology</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Five Steps to Architectural Certainty</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Precision engineering, milestone accountability, and a 5-year structural warranty.</p>
    </div>
</section>

<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-4xl mx-auto space-y-8">
        @foreach($processSteps as $step)
            <div class="glass-card-light rounded-3xl p-8 border border-black/5 shadow-xl flex flex-col sm:flex-row gap-6 items-start" data-reveal="up">
                <div class="w-16 h-16 rounded-2xl bg-charcoal text-gold font-serif text-3xl font-bold flex items-center justify-center shrink-0 border border-gold/30">
                    {{ $step['step'] ?? '0'.$loop->iteration }}
                </div>
                <div class="space-y-2 flex-grow">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">
                            {{ app()->getLocale() === 'bn' && !empty($step['title_bn']) ? $step['title_bn'] : ($step['title'] ?? '') }}
                        </h2>
                        <span class="px-3 py-1 rounded-full bg-gold/15 text-gold-dark text-xs font-bold uppercase shrink-0">{{ $step['duration'] ?? '' }}</span>
                    </div>
                    <p class="text-sm sm:text-base text-charcoal/75 leading-relaxed">{{ $step['description'] ?? '' }}</p>
                </div>
            </div>
        @endforeach

        <div class="text-center pt-8">
            <a href="{{ route('booking') }}" class="gold-shimmer inline-block px-9 py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs uppercase tracking-widest shadow-xl">
                Start Stage 01: Book Consultation
            </a>
        </div>
    </div>
</section>
@endsection

