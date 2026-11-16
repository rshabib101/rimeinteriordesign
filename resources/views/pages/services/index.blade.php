@extends('layouts.app', ['metaTitle' => 'Services | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Design Disciplines</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Comprehensive Interior Architecture</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Every commission is delivered with transparent BDT budgeting, photorealistic 3D validation, and dedicated project supervision.</p>
    </div>
</section>

<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $service)
            <x-card-3d :dark="false" class="h-full flex flex-col">
                @if($service->banner_image)
                    <div class="h-44 rounded-xl overflow-hidden mb-5">
                        <img src="{{ \App\Support\MediaHelper::url($service->banner_image) }}" alt="{{ $service->localized_title }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>
                @endif
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-widest text-gold">0{{ $loop->iteration }}</span>
                    @if($service->starting_price_bdt)
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-black/5">From ৳{{ number_format((float) $service->starting_price_bdt) }}</span>
                    @endif
                </div>
                <h2 class="font-serif text-2xl font-bold text-charcoal mb-3">{{ $service->localized_title }}</h2>
                <p class="text-sm text-charcoal/70 leading-relaxed mb-6 flex-grow">{{ $service->localized_short_description }}</p>
                <a href="{{ route('services.show', $service->slug) }}" class="text-xs font-bold uppercase tracking-widest text-gold hover:text-gold-dark">
                    View Scope &amp; Deliverables &rarr;
                </a>
            </x-card-3d>
        @endforeach
    </div>
</section>
@endsection

