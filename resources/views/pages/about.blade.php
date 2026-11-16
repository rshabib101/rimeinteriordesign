@extends('layouts.app', ['metaTitle' => 'About Us | Asad Interior Design'])

@section('content')
@php
    $aboutTitle = \App\Models\Setting::get('about_title', 'Where Spatial Poetry Meets Precision Craftsmanship');
    $aboutStory = \App\Models\Setting::get('about_story', '');
    $aboutMission = \App\Models\Setting::get('about_mission', '');
    $aboutVision = \App\Models\Setting::get('about_vision', '');
    $aboutImage = \App\Support\MediaHelper::url(\App\Models\Setting::get('about_image'));
@endphp

<section class="bg-charcoal-deep text-offwhite py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 bg-subtle-pattern opacity-30"></div>
    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-5" data-reveal="up">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Our Heritage</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">{{ $aboutTitle }}</h1>
        <p class="text-base sm:text-lg text-offwhite/75 max-w-3xl mx-auto leading-relaxed">{{ $aboutStory }}</p>
    </div>
</section>

<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 rounded-3xl overflow-hidden shadow-2xl border border-black/5">
            <img src="{{ $aboutImage }}" alt="Asad Studio" class="w-full h-[420px] object-cover" loading="lazy" />
        </div>
        <div class="lg:col-span-6 space-y-6">
            <div class="glass-card-light rounded-3xl p-8 border border-black/5 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-gold-dark">Our Mission</span>
                <p class="text-base text-charcoal/80 leading-relaxed">{{ $aboutMission }}</p>
            </div>
            <div class="glass-card-light rounded-3xl p-8 border border-black/5 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-gold-dark">Our Vision</span>
                <p class="text-base text-charcoal/80 leading-relaxed">{{ $aboutVision }}</p>
            </div>
        </div>
    </div>
</section>

@if($teamMembers->isNotEmpty())
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-charcoal text-offwhite">
    <div class="max-w-7xl mx-auto">
        <x-section-heading
            subtitle="The Principals"
            title="Architects &"
            titleAccent="Craft Curators"
            align="center"
            :dark="true"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($teamMembers as $member)
                <x-card-3d :dark="true" class="text-center">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-2 border-gold/50 mb-5">
                        <img src="{{ \App\Support\MediaHelper::url($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-offwhite">{{ $member->name }}</h3>
                    <div class="text-xs text-gold font-semibold uppercase tracking-wider mt-1">{{ $member->localized_role }}</div>
                    <p class="text-xs text-offwhite/65 leading-relaxed mt-3">{{ $member->bio }}</p>
                </x-card-3d>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!empty($awards))
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-5xl mx-auto">
        <x-section-heading subtitle="Recognition" title="Honors &" titleAccent="Accolades" align="center" />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($awards as $award)
                <div class="p-6 rounded-3xl bg-white border border-black/5 shadow-lg space-y-2">
                    <div class="font-serif text-3xl font-bold text-gold">{{ $award['year'] ?? '' }}</div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">{{ $award['title'] ?? '' }}</h3>
                    <div class="text-xs text-charcoal/60">{{ $award['org'] ?? '' }} • {{ $award['category'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

