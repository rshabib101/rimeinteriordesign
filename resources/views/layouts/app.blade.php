@php
    $siteName = \App\Models\Setting::get('site_name', 'Rime Interior Design');
    $noticeText = \App\Models\Setting::get('notice_bar_text', 'Accepting Q1 & Q2 2027 Projects');
    $studioPhone = \App\Models\Setting::get('phone', '+880 1711 000 000');
    $studioEmail = \App\Models\Setting::get('email', 'concierge@rimeinterior.com');
    $studioWhatsapp = preg_replace('/[^\d+]/', '', \App\Models\Setting::get('whatsapp', '+8801711000000'));
    $studioAddress = \App\Models\Setting::get('address', 'Plot 42, Road 11, Block D, Gulshan-2, Dhaka 1212, Bangladesh');
    $instagramUrl = \App\Models\Setting::get('instagram_url', 'https://instagram.com');
    $facebookUrl = \App\Models\Setting::get('facebook_url', 'https://facebook.com');
    $linkedinUrl = \App\Models\Setting::get('linkedin_url', 'https://linkedin.com');
    $defaultMetaTitle = \App\Models\Setting::get('seo_meta_title', __('messages.meta.home_title'));
    $defaultMetaDesc = \App\Models\Setting::get('seo_meta_description', __('messages.meta.home_desc'));
    $gaId = \App\Models\Setting::get('ga_measurement_id');
    $fbPixelId = \App\Models\Setting::get('fb_pixel_id');
    $navServices = \App\Models\Service::active()->take(6)->get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? $defaultMetaTitle }}</title>
    <meta name="description" content="{{ $metaDescription ?? $defaultMetaDesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? $defaultMetaTitle }}">
    <meta property="og:description" content="{{ $metaDescription ?? $defaultMetaDesc }}">
    <meta property="og:image" content="{{ $metaImage ?? asset('images/og-rime.jpg') }}">

    <!-- Structured Data (LocalBusiness) -->
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'InteriorDesigner',
            'name' => $siteName,
            'url' => url('/'),
            'telephone' => $studioPhone,
            'email' => $studioEmail,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $studioAddress,
                'addressLocality' => 'Dhaka',
                'addressCountry' => 'BD',
            ],
            'priceRange' => '৳৳৳',
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @stack('structured-data')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Hind+Siliguri:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @if(!empty($gaId))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ e($gaId) }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ e($gaId) }}');
        </script>
    @endif

    @if(!empty($fbPixelId))
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ e($fbPixelId) }}');
            fbq('track', 'PageView');
        </script>
    @endif
</head>
<body class="bg-[#F8F5F0] text-[#1C1C1C] font-sans antialiased selection:bg-gold selection:text-white transition-colors duration-300 min-h-screen flex flex-col overflow-x-hidden">

    <!-- Top Notice / Announcement Bar -->
    <div class="bg-charcoal-deep text-offwhite/80 py-2 px-4 text-xs font-medium border-b border-white/5 relative z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-widest bg-gold/20 text-gold-light border border-gold/30">
                    Gulshan Studio
                </span>
                <span class="hidden sm:inline truncate max-w-md">{{ $studioAddress }}</span>
            </div>
            <div class="flex items-center space-x-5">
                <div class="flex items-center space-x-2 text-offwhite/70">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ $noticeText }}</span>
                </div>
                <div class="hidden md:flex items-center space-x-3 text-gold-light font-serif">
                    <span>Currency:</span>
                    <span class="font-sans font-bold text-offwhite">৳ BDT</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header
        x-data="{
            scrolled: false,
            mobileOpen: false,
            servicesDropdown: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 30;
                }, { passive: true });
            }
        }"
        :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-md py-3.5 border-b border-black/5' : 'bg-[#F8F5F0]/80 backdrop-blur-sm py-4 border-b border-black/5'"
        class="sticky top-0 z-50 transition-all duration-300 w-full"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">

                <!-- Brand Logo / Monogram -->
                <a href="{{ route('home') }}" class="group flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full border border-gold/40 flex items-center justify-center bg-gradient-to-br from-gold/15 to-transparent group-hover:border-gold transition-all duration-300">
                        <span class="font-serif text-xl font-bold text-gold">R</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-2xl font-bold tracking-tight text-charcoal group-hover:text-gold transition-colors duration-300 leading-none">
                            RIME
                        </span>
                        <span class="text-[9px] uppercase tracking-[0.3em] font-medium text-charcoal/60 mt-0.5">
                            Interior Design
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium text-charcoal/85">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.home') }}
                    </a>

                    <!-- Services Dropdown -->
                    <div class="relative" @mouseenter="servicesDropdown = true" @mouseleave="servicesDropdown = false">
                        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 flex items-center space-x-1 py-1">
                            <span>{{ __('messages.nav.services') }}</span>
                            <svg class="w-3.5 h-3.5 text-charcoal/50 transition-transform duration-200" :class="servicesDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <div
                            x-show="servicesDropdown"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute top-full left-0 w-72 rounded-2xl bg-white/95 backdrop-blur-xl shadow-2xl border border-black/5 p-3 grid gap-1 z-50"
                            style="display: none;"
                        >
                            @foreach($navServices as $navService)
                                <a href="{{ route('services.show', $navService->slug) }}" class="p-2.5 rounded-xl hover:bg-gold/10 hover:text-gold flex items-center space-x-3 transition-colors">
                                    <span class="w-2 h-2 rounded-full bg-gold shrink-0"></span>
                                    <div>
                                        <div class="font-medium text-xs">{{ $navService->localized_title }}</div>
                                        @if($navService->starting_price_bdt)
                                            <div class="text-[10px] text-charcoal/50">From ৳{{ number_format((float) $navService->starting_price_bdt) }}</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('portfolio.index') }}" class="{{ request()->routeIs('portfolio.*') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.portfolio') }}
                    </a>

                    <a href="{{ route('showcase.3d') }}" class="{{ request()->routeIs('showcase.3d') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1 flex items-center space-x-1.5">
                        <span>{{ __('messages.nav.showcase_3d') }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-gold text-charcoal-deep font-sans">
                            3D / AR
                        </span>
                    </a>

                    <a href="{{ route('process') }}" class="{{ request()->routeIs('process') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.process') }}
                    </a>

                    <a href="{{ route('calculator') }}" class="{{ request()->routeIs('calculator') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.calculator') }}
                    </a>

                    <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.blog') }}
                    </a>

                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.about') }}
                    </a>

                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-gold font-semibold' : 'hover:text-gold' }} transition-colors duration-200 py-1">
                        {{ __('messages.nav.contact') }}
                    </a>
                </nav>

                <!-- Actions: Language Switcher & Book Consultation CTA -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="flex items-center p-1 rounded-full bg-black/5 border border-black/5 text-xs font-semibold">
                        <a
                            href="{{ route('locale.switch', 'en') }}"
                            class="px-2.5 py-1 rounded-full transition-all duration-200 {{ app()->getLocale() === 'en' ? 'bg-gold text-charcoal-deep shadow-sm' : 'text-charcoal/70 hover:text-charcoal' }}"
                        >
                            EN
                        </a>
                        <a
                            href="{{ route('locale.switch', 'bn') }}"
                            class="px-2.5 py-1 rounded-full transition-all duration-200 {{ app()->getLocale() === 'bn' ? 'bg-gold text-charcoal-deep shadow-sm' : 'text-charcoal/70 hover:text-charcoal' }}"
                        >
                            বাং
                        </a>
                    </div>

                    <a
                        href="{{ route('booking') }}"
                        class="gold-shimmer px-5 py-2.5 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-semibold text-xs tracking-wider uppercase transition-all duration-300 shadow-[0_4px_20px_rgba(184,137,77,0.3)] hover:shadow-[0_6px_25px_rgba(184,137,77,0.45)] hover:-translate-y-0.5 flex items-center space-x-2"
                    >
                        <span>{{ __('messages.cta.book_now') }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center space-x-3 lg:hidden">
                    <a
                        href="{{ route('locale.switch', app()->getLocale() === 'en' ? 'bn' : 'en') }}"
                        class="px-2.5 py-1 rounded-full bg-black/5 text-xs font-bold text-gold border border-gold/20"
                    >
                        {{ app()->getLocale() === 'en' ? 'বাং' : 'EN' }}
                    </a>

                    <button
                        @click="mobileOpen = !mobileOpen"
                        type="button"
                        class="p-2 rounded-xl text-charcoal hover:text-gold hover:bg-black/5 transition-colors focus:outline-none"
                        aria-label="Toggle navigation menu"
                    >
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Fullscreen Luxury Mobile Menu -->
        <div
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="lg:hidden fixed inset-x-0 top-[70px] bg-charcoal-deep/98 text-offwhite backdrop-blur-2xl border-b border-white/10 p-6 shadow-2xl z-50 max-h-[calc(100vh-76px)] overflow-y-auto"
            style="display: none;"
        >
            <div class="flex flex-col space-y-3 text-base font-medium">
                <a @click="mobileOpen = false" href="{{ route('home') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.home') }}</a>
                <a @click="mobileOpen = false" href="{{ route('about') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.about') }}</a>
                <a @click="mobileOpen = false" href="{{ route('services.index') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.services') }}</a>
                <a @click="mobileOpen = false" href="{{ route('portfolio.index') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.portfolio') }}</a>
                <a @click="mobileOpen = false" href="{{ route('showcase.3d') }}" class="py-2 border-b border-white/5 text-gold flex items-center justify-between">
                    <span>{{ __('messages.nav.showcase_3d') }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gold text-charcoal">3D / AR</span>
                </a>
                <a @click="mobileOpen = false" href="{{ route('process') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.process') }}</a>
                <a @click="mobileOpen = false" href="{{ route('calculator') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.calculator') }}</a>
                <a @click="mobileOpen = false" href="{{ route('blog.index') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.blog') }}</a>
                <a @click="mobileOpen = false" href="{{ route('faq') }}" class="py-2 border-b border-white/5 hover:text-gold">FAQ</a>
                <a @click="mobileOpen = false" href="{{ route('contact') }}" class="py-2 border-b border-white/5 hover:text-gold">{{ __('messages.nav.contact') }}</a>

                <div class="pt-4 flex flex-col space-y-3">
                    <a
                        @click="mobileOpen = false"
                        href="{{ route('booking') }}"
                        class="w-full py-3.5 rounded-xl bg-gold text-charcoal-deep text-center font-bold tracking-wider uppercase text-xs"
                    >
                        {{ __('messages.cta.book_now') }}
                    </a>
                    <div class="text-xs text-white/50 text-center pt-2">
                        {{ $studioPhone }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- WhatsApp Floating Action Button -->
    <aside aria-label="Quick contact" class="fixed bottom-6 right-6 z-40 flex flex-col items-end space-y-3">
        <a
            href="https://wa.me/{{ ltrim($studioWhatsapp, '+') }}?text={{ urlencode('Hello Rime Interior Studio, I would like to schedule a consultation.') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="group relative flex items-center justify-center w-14 h-14 rounded-full bg-emerald-600 text-white shadow-2xl hover:bg-emerald-500 hover:scale-105 transition-all duration-300"
            title="Chat with an Architect on WhatsApp"
        >
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-400 rounded-full animate-ping"></span>
            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.529 1.831.814 2.791.814 3.183 0 5.769-2.587 5.77-5.767 0-3.18-2.587-5.766-5.77-5.766zm9.969 5.766c0 5.514-4.486 10-10 10-1.748 0-3.385-.45-4.819-1.241l-7.181 1.881 1.916-6.994c-.878-1.488-1.386-3.228-1.386-5.083 0-5.514 4.486-10 10-10s10 4.486 10 10z"/>
            </svg>
            <span class="absolute right-16 px-3 py-1.5 rounded-lg bg-charcoal text-offwhite text-xs font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none shadow-xl border border-white/10">
                Chat with an Architect
            </span>
        </a>
    </aside>

    <!-- Master Footer -->
    <footer class="bg-charcoal-deep text-offwhite pt-20 pb-12 border-t border-white/10 relative overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gold/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16">

                <!-- Col 1: Studio Brand & Story -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full border border-gold/40 flex items-center justify-center bg-gradient-to-br from-gold/20 to-transparent">
                            <span class="font-serif text-xl font-bold text-gold">R</span>
                        </div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-offwhite uppercase">
                            {{ $siteName }}
                        </span>
                    </div>

                    <p class="text-sm text-offwhite/65 leading-relaxed max-w-sm">
                        {{ __('messages.footer.tagline') }}
                    </p>

                    <div class="space-y-2.5 text-xs text-offwhite/70">
                        <div class="flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-gold shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $studioAddress }}</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $studioPhone }}</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $studioEmail }}</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="space-y-4">
                    <h3 class="font-serif text-lg font-semibold text-gold tracking-wide">
                        {{ __('messages.footer.quick_links') }}
                    </h3>
                    <ul class="space-y-2.5 text-xs text-offwhite/65">
                        <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.home') }}</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.about') }}</a></li>
                        <li><a href="{{ route('portfolio.index') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.portfolio') }}</a></li>
                        <li><a href="{{ route('showcase.3d') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.showcase_3d') }}</a></li>
                        <li><a href="{{ route('process') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.process') }}</a></li>
                        <li><a href="{{ route('calculator') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.calculator') }}</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-gold transition-colors">FAQ</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-gold transition-colors">{{ __('messages.nav.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Col 3: Expertise -->
                <div class="space-y-4">
                    <h3 class="font-serif text-lg font-semibold text-gold tracking-wide">
                        {{ __('messages.footer.services_title') }}
                    </h3>
                    <ul class="space-y-2.5 text-xs text-offwhite/65">
                        @foreach($navServices as $navService)
                            <li><a href="{{ route('services.show', $navService->slug) }}" class="hover:text-gold transition-colors">{{ $navService->localized_title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Social -->
                <div class="lg:col-span-1 space-y-4">
                    <h3 class="font-serif text-lg font-semibold text-gold tracking-wide">
                        {{ __('messages.footer.newsletter_title') }}
                    </h3>
                    <p class="text-xs text-offwhite/65 leading-relaxed">
                        {{ __('messages.footer.newsletter_desc') }}
                    </p>

                    <livewire:newsletter-form />

                    <div class="pt-2 flex items-center space-x-3 text-offwhite/70">
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center hover:border-gold hover:text-gold transition-colors" aria-label="Instagram">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center hover:border-gold hover:text-gold transition-colors" aria-label="Facebook">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.597 0 9 1.583 9 4.615V8z"/></svg>
                            </a>
                        @endif
                        @if($linkedinUrl)
                            <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center hover:border-gold hover:text-gold transition-colors" aria-label="LinkedIn">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-offwhite/50 space-y-4 sm:space-y-0">
                <div>
                    &copy; {{ date('Y') }} {{ $siteName }}. {{ __('messages.footer.rights_reserved') }}
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('privacy') }}" class="hover:text-gold transition-colors">{{ __('messages.footer.privacy') }}</a>
                    <a href="{{ route('terms') }}" class="hover:text-gold transition-colors">{{ __('messages.footer.terms') }}</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
