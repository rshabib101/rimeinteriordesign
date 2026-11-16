@extends('layouts.app', ['metaTitle' => 'Contact Us | Asad Interior Design'])

@section('content')
@php
    $studioPhone = \App\Models\Setting::get('phone', '+880 1711 000 000');
    $studioEmail = \App\Models\Setting::get('email', 'concierge@asadinterior.com');
    $studioAddress = \App\Models\Setting::get('address', 'Plot 42, Road 11, Block D, Gulshan-2, Dhaka 1212, Bangladesh');
    $studioHours = \App\Models\Setting::get('studio_hours', 'Saturday – Thursday: 10:30 AM – 7:30 PM');
    $mapEmbed = \App\Models\Setting::get('google_maps_embed');
@endphp

<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Concierge Desk</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Connect With Our Studio</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Have a floor plan ready or seeking a material consultation? Reach out to our Gulshan-2 architectural office.</p>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-5 space-y-6">
            <div class="glass-card-dark text-offwhite rounded-3xl p-8 space-y-6 border border-gold/25">
                <h2 class="font-serif text-3xl font-bold text-gold">Studio Coordinates</h2>
                <div class="space-y-4 text-sm text-offwhite/80">
                    <div>
                        <div class="text-[11px] uppercase tracking-widest text-gold-light font-bold">Address</div>
                        <p class="mt-1">{{ $studioAddress }}</p>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-widest text-gold-light font-bold">Direct Line</div>
                        <p class="mt-1">{{ $studioPhone }}</p>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-widest text-gold-light font-bold">Email</div>
                        <p class="mt-1">{{ $studioEmail }}</p>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-widest text-gold-light font-bold">Studio Hours</div>
                        <p class="mt-1">{{ $studioHours }}</p>
                    </div>
                </div>
            </div>

            @if(!empty($mapEmbed))
                <div class="rounded-3xl overflow-hidden shadow-xl border border-black/10 h-64">
                    <iframe
                        src="{{ $mapEmbed }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Asad Interior Design Studio Location"
                    ></iframe>
                </div>
            @endif
        </div>

        <div class="lg:col-span-7">
            <livewire:contact-form />
        </div>
    </div>
</section>
@endsection

