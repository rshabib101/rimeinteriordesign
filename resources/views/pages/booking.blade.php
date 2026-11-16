@extends('layouts.app', ['metaTitle' => 'Book Consultation | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Private Studio Appointment</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Book Your Design Consultation</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Share your floor plan, spatial ambitions, and preferred time slot to meet our principal architects at our Gulshan-2 studio or on-site.</p>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-5xl mx-auto">
        <livewire:booking-wizard />
    </div>
</section>
@endsection

