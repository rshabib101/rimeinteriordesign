@extends('layouts.app', ['metaTitle' => 'BDT Cost Estimator | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Instant Budget Planner</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">Interior Cost Estimator (BDT ৳)</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Estimate turnkey interior architecture and modular cabinetry costs in Bangladesh based on square footage and finish tier.</p>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-6xl mx-auto">
        <livewire:quote-calculator />
    </div>
</section>
@endsection

