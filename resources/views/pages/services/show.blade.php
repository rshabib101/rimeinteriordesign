@extends('layouts.app', ['metaTitle' => $service->localized_title . ' | Asad Interior Design', 'metaDescription' => $service->localized_short_description])

@section('content')
<section class="relative bg-charcoal-deep text-offwhite py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    @if($service->banner_image)
        <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image: url('{{ \App\Support\MediaHelper::url($service->banner_image) }}');"></div>
    @endif
    <div class="relative z-10 max-w-5xl mx-auto space-y-5">
        <a href="{{ route('services.index') }}" class="text-xs uppercase tracking-widest text-gold hover:underline">&larr; All Services</a>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">{{ $service->localized_title }}</h1>
        <p class="text-base sm:text-lg text-offwhite/80 max-w-2xl leading-relaxed">{{ $service->localized_short_description }}</p>
        @if($service->starting_price_bdt)
            <div class="inline-block px-5 py-2 rounded-full bg-gold/20 border border-gold/30 text-gold-light text-sm font-semibold">
                Starting Investment: ৳{{ number_format((float) $service->starting_price_bdt) }} BDT
            </div>
        @endif
    </div>
</section>

<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 space-y-8">
            @if($service->full_description)
                <div class="prose max-w-none bg-white rounded-3xl p-8 border border-black/5 shadow-lg">
                    {!! $service->full_description !!}
                </div>
            @endif

            @if($service->features)
                <div class="bg-white rounded-3xl p-8 border border-black/5 shadow-lg space-y-5">
                    <h2 class="font-serif text-3xl font-bold text-charcoal">Included Deliverables</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($service->features as $feature)
                            <div class="flex items-start space-x-3 p-4 rounded-2xl bg-[#F8F5F0]">
                                <span class="w-2 h-2 rounded-full bg-gold mt-2 shrink-0"></span>
                                <span class="text-sm text-charcoal/85">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($service->process_steps)
                <div class="bg-white rounded-3xl p-8 border border-black/5 shadow-lg space-y-5">
                    <h2 class="font-serif text-3xl font-bold text-charcoal">Execution Workflow</h2>
                    <div class="space-y-4">
                        @foreach($service->process_steps as $step)
                            <div class="p-4 rounded-2xl border border-black/5 flex items-start space-x-4">
                                <span class="font-serif text-2xl font-bold text-gold">0{{ $loop->iteration }}</span>
                                <div>
                                    <h3 class="font-serif text-xl font-bold">{{ $step['title'] ?? '' }}</h3>
                                    <p class="text-sm text-charcoal/70 mt-1">{{ $step['description'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card-dark text-offwhite rounded-3xl p-8 space-y-5 border border-gold/25">
                <h3 class="font-serif text-2xl font-bold text-gold">Commission This Service</h3>
                <p class="text-xs text-offwhite/75 leading-relaxed">Book an on-site evaluation or studio consultation in Dhaka with our architectural leads.</p>
                <a href="{{ route('booking', ['service_id' => $service->id]) }}" class="gold-shimmer block w-full py-3.5 rounded-full bg-gold text-charcoal-deep font-bold text-xs uppercase tracking-widest text-center">
                    Book Consultation
                </a>
                <a href="{{ route('calculator') }}" class="block w-full py-3.5 rounded-full border border-white/20 text-offwhite font-semibold text-xs uppercase tracking-widest text-center hover:border-gold">
                    Calculate BDT Estimate
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

