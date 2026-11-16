@extends('layouts.app')

@section('content')
@php
    $heroBadge = \App\Models\Setting::localized('hero_badge', 'Architecture & Interior Curation • Dhaka');
    $heroTitle = \App\Models\Setting::localized('tagline', __('messages.tagline'));
    $heroSubtitle = \App\Models\Setting::localized('hero_subtitle', __('messages.hero_subtitle'));
    $enable3d = \App\Models\Setting::get('hero_enable_3d', '1') === '1';
    $heroImage = \App\Support\MediaHelper::url(\App\Models\Setting::get('hero_image'));
    $aboutTitle = \App\Models\Setting::get('about_title', 'Where Spatial Poetry Meets Precision Craftsmanship');
    $aboutStory = \App\Models\Setting::get('about_story', '');
    $aboutImage = \App\Support\MediaHelper::url(\App\Models\Setting::get('about_image'));
    $studioPhone = \App\Models\Setting::get('phone', '+880 1711 000 000');
    $studioWhatsapp = preg_replace('/[^\d+]/', '', \App\Models\Setting::get('whatsapp', '+8801711000000'));
@endphp

<!-- 1. Interactive 3D Three.js Hero Section -->
<section class="relative min-h-[92vh] flex items-center overflow-hidden bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8">
    <!-- Background Gradient + Fallback Photography -->
    @if($heroImage)
        <div
            class="absolute inset-0 bg-cover bg-center opacity-20 mix-blend-luminosity pointer-events-none"
            style="background-image: url('{{ $heroImage }}');"
        ></div>
    @endif
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_75%_75%_at_70%_40%,rgba(184,137,77,0.22),rgba(18,18,18,0.95))]"></div>
    <div class="absolute inset-0 bg-subtle-pattern opacity-35 pointer-events-none"></div>

    <!-- Interactive Three.js WebGL 3D Canvas -->
    @if($enable3d)
        <div
            id="hero-3d-canvas"
            class="absolute inset-0 w-full h-full z-[1] pointer-events-auto opacity-90"
            aria-hidden="true"
        ></div>
    @endif

    <div class="relative z-10 max-w-7xl mx-auto w-full pointer-events-none">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-7 pointer-events-auto" data-reveal="up">
                <!-- Luxury Badge -->
                <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-gold/15 text-gold-light border border-gold/30 text-xs uppercase font-semibold tracking-widest backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                    <span>{{ $heroBadge }}</span>
                </div>

                <!-- Headline -->
                <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight leading-[1.06] text-offwhite">
                    {{ $heroTitle }}
                </h1>

                <!-- Subtitle -->
                <p class="max-w-xl text-base sm:text-lg text-offwhite/75 font-light leading-relaxed">
                    {{ $heroSubtitle }}
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center gap-4 pt-2">
                    <a
                        href="{{ route('portfolio.index') }}"
                        class="gold-shimmer w-full sm:w-auto px-8 py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs tracking-widest uppercase text-center transition-all duration-300 shadow-[0_10px_35px_rgba(184,137,77,0.35)] hover:-translate-y-0.5"
                    >
                        {{ __('messages.cta.explore_projects') }}
                    </a>
                    <a
                        href="{{ route('booking') }}"
                        class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/5 backdrop-blur-md border border-white/20 hover:border-gold hover:text-gold text-offwhite font-semibold text-xs tracking-widest uppercase text-center transition-all duration-300 hover:-translate-y-0.5"
                    >
                        {{ __('messages.cta.book_now') }}
                    </a>
                    <a
                        href="{{ route('showcase.3d') }}"
                        class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-gold-light hover:text-gold px-3 py-2"
                    >
                        <span>3D Studio</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Interactive Floating 3D Hint Card (Desktop right) -->
            <div class="hidden lg:flex lg:col-span-5 justify-end items-end min-h-[380px] pointer-events-none">
                <div class="glass-card-dark rounded-2xl p-4 border border-gold/25 max-w-xs pointer-events-auto shadow-2xl">
                    <div class="flex items-center space-x-3">
                        <span class="w-9 h-9 rounded-full bg-gold/20 text-gold flex items-center justify-center text-xs font-bold border border-gold/30">3D</span>
                        <div>
                            <div class="text-xs font-bold text-offwhite">Interactive Spatial Scene</div>
                            <div class="text-[11px] text-offwhite/60">Move cursor to orbit architectural vignette</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Stats Counters -->
        <div class="mt-16 pt-10 grid grid-cols-2 sm:grid-cols-4 gap-6 border-t border-white/10 text-center sm:text-left pointer-events-auto">
            <div class="space-y-1">
                <div class="font-serif text-3xl sm:text-4xl font-bold text-gold" data-counter="{{ \App\Models\Setting::get('stat_1_value', '150+') }}">
                    {{ \App\Models\Setting::get('stat_1_value', '150+') }}
                </div>
                <div class="text-xs uppercase tracking-wider text-offwhite/60">{{ \App\Models\Setting::get('stat_1_label', 'Projects Handed Over') }}</div>
            </div>
            <div class="space-y-1">
                <div class="font-serif text-3xl sm:text-4xl font-bold text-gold" data-counter="{{ \App\Models\Setting::get('stat_2_value', '8+') }}">
                    {{ \App\Models\Setting::get('stat_2_value', '8+') }}
                </div>
                <div class="text-xs uppercase tracking-wider text-offwhite/60">{{ \App\Models\Setting::get('stat_2_label', 'Years of Mastery') }}</div>
            </div>
            <div class="space-y-1">
                <div class="font-serif text-3xl sm:text-4xl font-bold text-gold" data-counter="{{ \App\Models\Setting::get('stat_3_value', '100%') }}">
                    {{ \App\Models\Setting::get('stat_3_value', '100%') }}
                </div>
                <div class="text-xs uppercase tracking-wider text-offwhite/60">{{ \App\Models\Setting::get('stat_3_label', 'Turnkey Accountability') }}</div>
            </div>
            <div class="space-y-1">
                <div class="font-serif text-3xl sm:text-4xl font-bold text-gold" data-counter="{{ \App\Models\Setting::get('stat_4_value', '5 Yrs') }}">
                    {{ \App\Models\Setting::get('stat_4_value', '5 Yrs') }}
                </div>
                <div class="text-xs uppercase tracking-wider text-offwhite/60">{{ \App\Models\Setting::get('stat_4_label', 'Craftsmanship Warranty') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- 2. About Studio Snippet -->
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0] text-charcoal relative">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 relative" data-reveal="right">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl aspect-[4/3] border border-black/5">
                <img
                    src="{{ $aboutImage ?? 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1400&q=85' }}"
                    alt="Asad Interior Design Studio"
                    class="w-full h-full object-cover"
                    loading="lazy"
                />
                <div class="absolute inset-0 bg-gradient-to-tr from-charcoal-deep/40 via-transparent to-transparent"></div>
            </div>
            <div class="glass-card-dark text-offwhite rounded-2xl p-5 absolute -bottom-6 right-4 sm:right-8 border border-gold/30 shadow-2xl max-w-[230px]">
                <div class="font-serif text-3xl font-bold text-gold">BUET &amp; Milan</div>
                <div class="text-xs text-offwhite/70 mt-1">Principal-led architectural heritage tailored for Dhaka living.</div>
            </div>
        </div>

        <div class="lg:col-span-6 space-y-6" data-reveal="left">
            <span class="inline-flex items-center px-3.5 py-1 rounded-full bg-gold/15 text-gold-dark text-xs font-bold uppercase tracking-widest border border-gold/30">
                About The Studio
            </span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal leading-tight">
                {{ $aboutTitle }}
            </h2>
            <p class="text-base text-charcoal/75 leading-relaxed">
                {{ $aboutStory }}
            </p>
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="p-4 rounded-2xl bg-white border border-black/5 shadow-sm">
                    <div class="text-xs uppercase tracking-widest text-gold-dark font-bold">Factory Joinery</div>
                    <div class="text-xs text-charcoal/65 mt-1">CNC precision &amp; Austrian Blum hardware</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-black/5 shadow-sm">
                    <div class="text-xs uppercase tracking-widest text-gold-dark font-bold">Transparent BDT</div>
                    <div class="text-xs text-charcoal/65 mt-1">Zero hidden BOQ escalations</div>
                </div>
            </div>
            <div class="pt-2">
                <a href="{{ route('about') }}" class="inline-flex items-center space-x-2 px-7 py-3.5 rounded-full bg-charcoal text-offwhite hover:bg-gold hover:text-charcoal-deep font-bold text-xs uppercase tracking-widest transition-all">
                    <span>Meet Our Architects</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 3. Featured Services (3D Tilt Cards) -->
<section id="services" class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F2ECE1]/60 text-charcoal relative">
    <div class="max-w-7xl mx-auto">
        <x-section-heading
            subtitle="Architectural Excellence"
            title="Our Bespoke"
            titleAccent="Design Disciplines"
            description="From spatial acoustics in high-rise duplexes to German-engineered modular joinery, we translate architectural ambition into enduring reality."
            align="center"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <x-card-3d :dark="false" class="h-full flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <span class="w-12 h-12 rounded-2xl bg-gold/15 text-gold flex items-center justify-center font-serif text-xl font-bold border border-gold/30">
                            0{{ $loop->iteration }}
                        </span>
                        @if($service->starting_price_bdt)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-black/5 text-charcoal/80">
                                From ৳{{ number_format((float) $service->starting_price_bdt) }}
                            </span>
                        @endif
                    </div>

                    <h3 class="font-serif text-2xl font-bold text-charcoal group-hover:text-gold transition-colors duration-300 mb-3">
                        {{ $service->localized_title }}
                    </h3>

                    <p class="text-sm text-charcoal/70 leading-relaxed mb-6 flex-grow">
                        {{ $service->localized_short_description }}
                    </p>

                    @if($service->features)
                        <ul class="space-y-2 mb-6 text-xs text-charcoal/80 border-t border-black/5 pt-4">
                            @foreach(array_slice($service->features, 0, 3) as $feature)
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0"></span>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-gold hover:text-gold-hover transition-colors">
                        <span>Explore Discipline</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </x-card-3d>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. Featured Portfolio -->
<section id="portfolio" class="py-24 px-4 sm:px-6 lg:px-8 bg-charcoal text-offwhite relative overflow-hidden">
    <div class="max-w-7xl mx-auto relative z-10">
        <x-section-heading
            subtitle="Curated Portfolio"
            title="Living Spaces"
            titleAccent="Crafted for Legacy"
            description="Explore our celebrated duplexes, minimalist apartments, and executive offices in Gulshan, Banani, and Baridhara."
            align="center"
            :dark="true"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($featuredProjects as $project)
                <a href="{{ route('portfolio.show', $project->slug) }}" class="block group">
                    <x-card-3d :dark="true" class="h-full">
                        <div class="relative h-72 rounded-xl overflow-hidden mb-6 group-hover:shadow-2xl transition-all duration-300">
                            <img
                                src="{{ \App\Support\MediaHelper::url($project->cover_image) }}"
                                alt="{{ $project->localized_title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal-deep/90 via-charcoal-deep/20 to-transparent"></div>
                            <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-charcoal-deep/80 backdrop-blur-md border border-white/10 text-[10px] font-bold uppercase tracking-wider text-gold">
                                {{ ucfirst($project->room_type) }} • {{ $project->style }}
                            </div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="text-xs text-gold font-medium mb-1">{{ $project->location }} • {{ number_format((int) $project->area_sqft) }} sq ft</div>
                                <h3 class="font-serif text-2xl font-bold text-offwhite group-hover:text-gold transition-colors">
                                    {{ $project->localized_title }}
                                </h3>
                            </div>
                        </div>

                        <p class="text-sm text-offwhite/70 leading-relaxed mb-6">
                            {{ $project->summary }}
                        </p>

                        <div class="flex items-center justify-between text-xs pt-4 border-t border-white/10">
                            <span class="text-offwhite/50">Completion: {{ $project->completion_year }}</span>
                            <span class="text-gold group-hover:text-gold-hover font-semibold inline-flex items-center space-x-1.5">
                                <span>{{ __('messages.cta.view_details') }}</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </x-card-3d>
                </a>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('portfolio.index') }}" class="gold-shimmer inline-flex items-center space-x-2 px-8 py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs uppercase tracking-widest shadow-xl">
                <span>View Full Portfolio Gallery</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- 5. Before / After Interactive Comparison -->
@if($comparisonProject)
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0] text-charcoal">
    <div class="max-w-6xl mx-auto">
        <x-section-heading
            subtitle="Spatial Metamorphosis"
            title="Before &"
            titleAccent="After Craft"
            description="Drag the slider to reveal how our architects transformed a bare structural shell into {{ $comparisonProject->localized_title }}."
            align="center"
        />

        <div data-reveal="up">
            <x-before-after
                :beforeImage="$comparisonProject->before_image"
                :afterImage="$comparisonProject->after_image"
                :title="$comparisonProject->localized_title"
                beforeLabel="Raw Shell"
                afterLabel="Asad Handover"
            />
        </div>
    </div>
</section>
@endif

<!-- 6. Interactive 3D & AR Furniture Preview -->
@if($showcase3dProject)
<section id="showcase3d" class="py-24 px-4 sm:px-6 lg:px-8 bg-charcoal-deep text-offwhite relative overflow-hidden">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-5 space-y-6" data-reveal="right">
            <span class="px-3.5 py-1 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">
                WebGL &amp; Augmented Reality
            </span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold leading-tight">
                Inspect Bespoke Form in <span class="text-gold italic">Real-Time 3D</span>
            </h2>
            <p class="text-sm sm:text-base text-offwhite/70 leading-relaxed">
                Every custom joinery piece and spatial layout is prototyped digitally before fabrication. Rotate, zoom, or project this piece directly into your room via mobile AR.
            </p>
            <div class="flex flex-wrap gap-3 pt-2">
                <a href="{{ route('showcase.3d') }}" class="gold-shimmer px-7 py-3.5 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs uppercase tracking-widest">
                    Open Full 3D Style Studio
                </a>
                <a href="{{ route('calculator') }}" class="px-7 py-3.5 rounded-full border border-white/20 hover:border-gold text-offwhite font-semibold text-xs uppercase tracking-widest">
                    Estimate in BDT
                </a>
            </div>
        </div>

        <div class="lg:col-span-7" data-reveal="left">
            <div class="glass-card-dark rounded-3xl border border-gold/25 h-[420px] sm:h-[480px] relative overflow-hidden p-4">
                <model-viewer
                    src="{{ \App\Support\MediaHelper::url($showcase3dProject->model_3d_path) }}"
                    alt="{{ $showcase3dProject->localized_title }} 3D Preview"
                    auto-rotate
                    camera-controls
                    ar
                    shadow-intensity="1.2"
                    exposure="1.05"
                    class="w-full h-full"
                ></model-viewer>
                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-[11px] text-offwhite/60 pointer-events-none">
                    <span>Drag to Orbit • Scroll to Zoom</span>
                    <span class="px-2.5 py-1 rounded-full bg-gold/20 text-gold border border-gold/30 font-semibold">AR Ready</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- 7. 5-Step Process Timeline -->
@if(!empty($processSteps))
<section id="process" class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0] text-charcoal">
    <div class="max-w-7xl mx-auto">
        <x-section-heading
            subtitle="Methodology"
            title="From Sketch to"
            titleAccent="White-Glove Handover"
            description="Our disciplined five-stage workflow ensures architectural precision, cost certainty, and predictable timelines."
            align="center"
        />

        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            @foreach($processSteps as $step)
                <div class="p-6 rounded-3xl bg-white border border-black/5 shadow-lg hover:border-gold/50 transition-all space-y-4" data-reveal="up">
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-3xl font-bold text-gold">{{ $step['step'] ?? '0'.$loop->iteration }}</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-cream text-charcoal/70">{{ $step['duration'] ?? '' }}</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">
                        {{ app()->getLocale() === 'bn' && !empty($step['title_bn']) ? $step['title_bn'] : ($step['title'] ?? '') }}
                    </h3>
                    <p class="text-xs text-charcoal/65 leading-relaxed">
                        {{ $step['description'] ?? '' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 8. Quick Cost Estimator Banner -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-charcoal text-offwhite">
    <div class="max-w-6xl mx-auto">
        <x-section-heading
            subtitle="Transparent Budgeting"
            title="Interactive BDT"
            titleAccent="Cost Estimator"
            description="Calibrate your projected interior design investment in Bangladeshi Taka (৳) using live studio finish rates."
            align="center"
            :dark="true"
        />
        <livewire:quote-calculator />
    </div>
</section>

<!-- 9. Client Testimonials Carousel (Swiper) -->
@if($testimonials->isNotEmpty())
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F2ECE1]/70 text-charcoal overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <x-section-heading
            subtitle="Client Voices"
            title="Trusted by Dhaka’s"
            titleAccent="Discerning Homeowners"
            align="center"
        />

        <div class="swiper testimonials-swiper pb-12">
            <div class="swiper-wrapper">
                @foreach($testimonials as $item)
                    <div class="swiper-slide h-auto">
                        <div class="bg-white rounded-3xl p-8 border border-black/5 shadow-lg h-full flex flex-col justify-between space-y-6">
                            <div class="space-y-4">
                                <div class="flex text-gold text-sm">
                                    @for($i = 0; $i < ($item->rating ?? 5); $i++)
                                        <span>★</span>
                                    @endfor
                                </div>
                                <p class="text-sm text-charcoal/80 leading-relaxed italic">
                                    “{{ $item->localized_quote }}”
                                </p>
                            </div>
                            <div class="flex items-center space-x-3 pt-4 border-t border-black/5">
                                @if($item->client_avatar)
                                    <img src="{{ \App\Support\MediaHelper::url($item->client_avatar) }}" alt="{{ $item->client_name }}" class="w-11 h-11 rounded-full object-cover" loading="lazy" />
                                @endif
                                <div>
                                    <div class="font-serif text-lg font-bold text-charcoal leading-tight">{{ $item->client_name }}</div>
                                    <div class="text-[11px] text-charcoal/55">{{ $item->client_designation }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

<!-- 10. Latest Design Journal Posts -->
@if($posts->isNotEmpty())
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0] text-charcoal">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <x-section-heading
                subtitle="The Journal"
                title="Notes on Space,"
                titleAccent="Light & Material"
            />
            <a href="{{ route('blog.index') }}" class="text-xs font-bold uppercase tracking-widest text-gold hover:text-gold-dark mb-12">
                All Articles &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group block rounded-3xl overflow-hidden bg-white border border-black/5 shadow-lg hover:shadow-2xl transition-all">
                    <div class="h-52 overflow-hidden">
                        <img src="{{ \App\Support\MediaHelper::url($post->cover_image) }}" alt="{{ $post->localized_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" />
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-[11px] text-gold-dark font-bold uppercase tracking-wider">
                            <span>{{ $post->category }}</span>
                            <span>{{ $post->published_at?->format('M d, Y') }}</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-charcoal group-hover:text-gold transition-colors leading-snug">
                            {{ $post->localized_title }}
                        </h3>
                        <p class="text-xs text-charcoal/65 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 11. Call To Action Banner -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-gold/15 via-gold/5 to-gold/15 border-y border-gold/25 relative overflow-hidden">
    <div class="max-w-4xl mx-auto text-center space-y-6" data-reveal="up">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-dark text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">
            Private Architecture Consultation
        </span>
        <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal">
            Ready to Inhabit Your Vision?
        </h2>
        <p class="text-base sm:text-lg text-charcoal/70 max-w-2xl mx-auto leading-relaxed">
            Visit our private studio in Gulshan-2, Dhaka or book a personalized 3D spatial assessment with our principal design team.
        </p>
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a
                href="{{ route('booking') }}"
                class="gold-shimmer px-8 py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-sm tracking-wider uppercase transition-all duration-300 shadow-[0_10px_35px_rgba(184,137,77,0.35)]"
            >
                {{ __('messages.cta.book_now') }}
            </a>
            <a
                href="https://wa.me/{{ ltrim($studioWhatsapp, '+') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="px-8 py-4 rounded-full bg-charcoal text-offwhite hover:bg-charcoal-card font-medium text-sm tracking-wider uppercase transition-all duration-300"
            >
                WhatsApp: {{ $studioPhone }}
            </a>
        </div>
    </div>
</section>
@endsection
