<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Left: Interactive Controls -->
    <div class="lg:col-span-7 glass-card-light rounded-3xl p-6 sm:p-10 space-y-8 border border-black/5 shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Property Type</label>
                <select wire:model.live="propertyType" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm font-medium">
                    <option value="Apartment">Luxury Apartment</option>
                    <option value="Duplex">Duplex Residence</option>
                    <option value="Penthouse">Skyline Penthouse</option>
                    <option value="Office">Corporate Office</option>
                    <option value="Showroom">Retail / Showroom</option>
                </select>
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Project Scope</label>
                <select wire:model.live="roomScope" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm font-medium">
                    <option value="full_home">Full Home Turnkey</option>
                    <option value="living_dining">Living & Dining Zone</option>
                    <option value="master_suite">Master Bedroom & Walk-in</option>
                    <option value="kitchen_only">Modular Kitchen Atelier</option>
                    <option value="office_suite">Corporate Fit-out</option>
                </select>
            </div>
        </div>

        <!-- Area Slider -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <label class="text-xs uppercase tracking-widest font-bold text-charcoal/70">Total Floor Area</label>
                <span class="font-serif text-2xl font-bold text-gold">{{ number_format($areaSqft) }} <span class="text-xs font-sans text-charcoal/60">sq ft</span></span>
            </div>
            <input
                type="range"
                wire:model.live="areaSqft"
                min="300"
                max="10000"
                step="50"
                class="w-full accent-[#B8894D] h-2 rounded-lg bg-warmgray cursor-pointer"
            />
            <div class="flex justify-between text-[11px] text-charcoal/50">
                <span>300 sq ft</span>
                <span>5,000 sq ft</span>
                <span>10,000 sq ft</span>
            </div>
        </div>

        <!-- Finish Tier Selector -->
        <div class="space-y-3">
            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70">Material & Craftsmanship Tier</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach([
                    'standard' => ['label' => 'Signature Standard', 'desc' => 'Melamine & laminate joinery, quality fittings', 'rate' => $rates['standard']],
                    'premium'  => ['label' => 'Atelier Premium', 'desc' => 'Natural veneer, quartz counters, Blum soft-close', 'rate' => $rates['premium']],
                    'luxury'   => ['label' => 'Bespoke Luxury', 'desc' => 'Italian marble, fluted teak, brushed brass & automation', 'rate' => $rates['luxury']],
                ] as $tierKey => $tier)
                    <button
                        type="button"
                        wire:click="$set('finishTier', '{{ $tierKey }}')"
                        class="text-left p-4 rounded-2xl border transition-all {{ $finishTier === $tierKey ? 'bg-charcoal text-offwhite border-gold shadow-xl scale-[1.02]' : 'bg-white text-charcoal border-black/10 hover:border-gold/50' }}"
                    >
                        <div class="text-xs font-bold uppercase tracking-wider {{ $finishTier === $tierKey ? 'text-gold' : 'text-gold-dark' }}">
                            ৳{{ number_format($tier['rate']) }}/sqft
                        </div>
                        <div class="font-serif text-lg font-bold mt-1">{{ $tier['label'] }}</div>
                        <p class="text-[11px] mt-1.5 leading-relaxed {{ $finishTier === $tierKey ? 'text-offwhite/70' : 'text-charcoal/60' }}">
                            {{ $tier['desc'] }}
                        </p>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Optional Upgrades -->
        <div class="space-y-3 pt-2 border-t border-black/5">
            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70">Optional Architectural Modules</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="flex items-center space-x-3 p-3.5 rounded-xl bg-white border border-black/10 cursor-pointer hover:border-gold/50">
                    <input type="checkbox" wire:model.live="includeKitchen" class="rounded text-gold focus:ring-gold" />
                    <span class="text-xs font-medium">Modular Kitchen</span>
                </label>
                <label class="flex items-center space-x-3 p-3.5 rounded-xl bg-white border border-black/10 cursor-pointer hover:border-gold/50">
                    <input type="checkbox" wire:model.live="includeLighting" class="rounded text-gold focus:ring-gold" />
                    <span class="text-xs font-medium">Circadian Smart Lighting</span>
                </label>
                <label class="flex items-center space-x-3 p-3.5 rounded-xl bg-white border border-black/10 cursor-pointer hover:border-gold/50">
                    <input type="checkbox" wire:model.live="includeVr" class="rounded text-gold focus:ring-gold" />
                    <span class="text-xs font-medium">4K 3D & VR Twin</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Right: Live BDT Estimate Summary -->
    <div class="lg:col-span-5 glass-card-dark text-offwhite rounded-3xl p-8 sm:p-10 space-y-6 border border-gold/25 shadow-2xl sticky top-28">
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <span class="text-xs uppercase tracking-widest text-gold font-bold">Estimated Turnkey Investment</span>
            <span class="px-2.5 py-1 rounded-full bg-gold/20 text-gold-light text-[10px] font-bold">BDT (৳)</span>
        </div>

        <div>
            <div class="text-xs text-offwhite/60 mb-1">Projected Range ({{ number_format($areaSqft) }} sq ft • {{ ucfirst($finishTier) }})</div>
            <div class="font-serif text-3xl sm:text-4xl font-bold text-gold leading-tight">
                ৳{{ number_format($estimate['min']) }} – ৳{{ number_format($estimate['max']) }}
            </div>
            <div class="text-xs text-offwhite/50 mt-2">
                Approx. ৳{{ number_format($estimate['min'] / 100000, 1) }}L – ৳{{ number_format($estimate['max'] / 100000, 1) }} Lakh BDT
            </div>
        </div>

        <div class="space-y-3 pt-4 border-t border-white/10 text-xs">
            <div class="flex justify-between text-offwhite/75">
                <span>Base Rate ({{ ucfirst($finishTier) }})</span>
                <span class="font-semibold text-offwhite">৳{{ number_format($estimate['per_sqft']) }} / sq ft</span>
            </div>
            <div class="flex justify-between text-offwhite/75">
                <span>Architectural Modules & 3D VR</span>
                <span class="font-semibold text-offwhite">৳{{ number_format($estimate['addons']) }}</span>
            </div>
            <div class="flex justify-between text-offwhite/75">
                <span>Estimated Timeline</span>
                <span class="font-semibold text-gold-light">{{ $areaSqft > 3000 ? '12–18 Weeks' : '8–12 Weeks' }}</span>
            </div>
        </div>

        <p class="text-[11px] text-offwhite/50 leading-relaxed">
            *Indicative estimate only. Final Bill of Quantities (BOQ) is calibrated after physical site measurement and material selection at our Gulshan studio.
        </p>

        <a
            href="{{ route('booking', ['property_type' => $propertyType, 'area_sqft' => $areaSqft, 'budget_range' => '৳' . number_format($estimate['min'] / 100000, 0) . '–' . number_format($estimate['max'] / 100000, 0) . ' Lakh']) }}"
            class="gold-shimmer w-full py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs uppercase tracking-widest text-center block transition-all shadow-[0_10px_30px_rgba(184,137,77,0.35)]"
        >
            Book Consultation With This Estimate
        </a>
    </div>
</div>

