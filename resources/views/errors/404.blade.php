@extends('layouts.app', ['metaTitle' => '404 — Space Not Found | Rime Interior Design'])

@section('content')
<section class="min-h-[75vh] flex items-center justify-center bg-charcoal-deep text-offwhite px-4 py-20 text-center">
    <div class="max-w-xl space-y-6">
        <div class="font-serif text-8xl font-bold text-gold">404</div>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold">This Room Is Still Unbuilt</h1>
        <p class="text-sm text-offwhite/70">The architectural page you are looking for may have moved or been archived.</p>
        <div class="pt-4 flex justify-center gap-4">
            <a href="{{ route('home') }}" class="gold-shimmer px-8 py-3.5 rounded-full bg-gold text-charcoal-deep font-bold text-xs uppercase tracking-widest">Return Home</a>
            <a href="{{ route('portfolio.index') }}" class="px-8 py-3.5 rounded-full border border-white/20 text-offwhite font-semibold text-xs uppercase tracking-widest hover:border-gold">Explore Portfolio</a>
        </div>
    </div>
</section>
@endsection

