@extends('layouts.app', ['metaTitle' => $pageTitle . ' | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-16 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto">
        <h1 class="font-serif text-4xl sm:text-5xl font-bold">{{ $pageTitle }}</h1>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-black/5 space-y-6 text-sm text-charcoal/80 leading-relaxed">
        @if($pageType === 'privacy')
            <h2 class="font-serif text-2xl font-bold text-charcoal">1. Information We Collect</h2>
            <p>When you book a consultation, request a cost estimate, or subscribe to our newsletter at Asad Interior Design, we collect your name, email address, phone number, project location, and optional floor plan files solely to provide architectural consultation services.</p>
            <h2 class="font-serif text-2xl font-bold text-charcoal">2. Confidentiality of Floor Plans</h2>
            <p>All uploaded residential and commercial CAD/PDF blueprints are treated under strict client confidentiality and are never shared with third parties outside our project engineering team.</p>
        @else
            <h2 class="font-serif text-2xl font-bold text-charcoal">1. Scope of Consultation &amp; Estimates</h2>
            <p>Online cost estimates displayed in Bangladeshi Taka (৳ BDT) serve as architectural guidance. Final binding quotations are issued via a written Bill of Quantities (BOQ) following physical site inspection.</p>
            <h2 class="font-serif text-2xl font-bold text-charcoal">2. Warranty &amp; Execution</h2>
            <p>Turnkey residential and commercial projects carry our standard 5-year structural workmanship warranty subject to normal residential/commercial care and usage.</p>
        @endif
    </div>
</section>
@endsection

