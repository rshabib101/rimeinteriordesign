@extends('layouts.app', ['metaTitle' => 'Frequently Asked Questions | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Clarity &amp; Transparency</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Frequently Asked Questions</h1>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]" x-data="{ category: 'all', openId: {{ $faqs->first()?->id ?? 'null' }} }">
    <div class="max-w-4xl mx-auto space-y-8">
        <div class="flex flex-wrap justify-center gap-2">
            <button @click="category = 'all'" class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider" :class="category === 'all' ? 'bg-charcoal text-gold' : 'bg-white text-charcoal/70'">All</button>
            @foreach($categories as $cat)
                <button @click="category = '{{ $cat }}'" class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider" :class="category === '{{ $cat }}' ? 'bg-charcoal text-gold' : 'bg-white text-charcoal/70'">{{ ucfirst($cat) }}</button>
            @endforeach
        </div>

        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div
                    x-show="category === 'all' || category === '{{ $faq->category }}'"
                    class="bg-white rounded-2xl border border-black/5 shadow-md overflow-hidden"
                >
                    <button
                        type="button"
                        @click="openId = openId === {{ $faq->id }} ? null : {{ $faq->id }}"
                        class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-serif text-xl font-bold text-charcoal hover:text-gold transition-colors"
                    >
                        <span>{{ $faq->localized_question }}</span>
                        <span class="text-gold text-2xl leading-none" x-text="openId === {{ $faq->id }} ? '−' : '+'"></span>
                    </button>
                    <div x-show="openId === {{ $faq->id }}" x-collapse class="px-6 pb-6 text-sm text-charcoal/75 leading-relaxed border-t border-black/5 pt-4">
                        {{ $faq->localized_answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

