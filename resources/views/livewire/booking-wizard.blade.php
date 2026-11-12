<div class="max-w-3xl mx-auto">
    @if($completed)
        <div class="glass-card-dark text-offwhite rounded-3xl p-10 text-center space-y-6 border border-gold/30 shadow-2xl">
            <div class="w-20 h-20 rounded-full bg-gold/20 text-gold flex items-center justify-center mx-auto border border-gold/40">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="space-y-2">
                <span class="text-xs uppercase tracking-widest text-gold font-bold">Consultation Confirmed</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold">We Look Forward to Meeting You</h2>
            </div>
            <p class="text-sm text-offwhite/75 max-w-md mx-auto">
                Your studio appointment request has been logged directly with our lead architects for <strong class="text-gold-light">{{ $preferred_date }} at {{ $preferred_time }}</strong>.
            </p>
            <div class="inline-block px-6 py-3 rounded-2xl bg-white/5 border border-white/10 font-mono text-sm text-gold">
                Booking Reference: {{ $bookingNumber }}
            </div>
            <div class="pt-4">
                <a href="{{ route('home') }}" class="px-8 py-3.5 rounded-full bg-gold text-charcoal-deep font-bold text-xs uppercase tracking-widest">
                    Return to Home
                </a>
            </div>
        </div>
    @else
        <div class="glass-card-light rounded-3xl p-6 sm:p-10 border border-black/5 shadow-2xl space-y-8">
            <!-- Step Progress -->
            <div class="flex items-center justify-between border-b border-black/5 pb-6">
                @foreach([1 => 'Space & Service', 2 => 'Scale & Budget', 3 => 'Date & Floor Plan', 4 => 'Contact Details'] as $sNum => $sLabel)
                    <div class="flex items-center space-x-2">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all {{ $step >= $sNum ? 'bg-gold text-charcoal-deep shadow-md' : 'bg-warmgray text-charcoal/50' }}">
                            {{ $sNum }}
                        </span>
                        <span class="hidden sm:inline text-xs font-semibold {{ $step >= $sNum ? 'text-charcoal' : 'text-charcoal/40' }}">{{ $sLabel }}</span>
                    </div>
                @endforeach
            </div>

            @if($rateLimitError)
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">{{ $rateLimitError }}</div>
            @endif

            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off" />
            </div>

            <!-- Step 1 -->
            @if($step === 1)
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-3">Select Design Discipline</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($services as $service)
                                <button
                                    type="button"
                                    wire:click="$set('service_id', {{ $service->id }})"
                                    class="text-left p-4 rounded-2xl border transition-all {{ $service_id === $service->id ? 'bg-charcoal text-offwhite border-gold shadow-lg' : 'bg-white text-charcoal border-black/10 hover:border-gold/40' }}"
                                >
                                    <div class="font-serif text-lg font-bold">{{ $service->localized_title }}</div>
                                    @if($service->starting_price_bdt)
                                        <div class="text-xs text-gold mt-1">From ৳{{ number_format((float) $service->starting_price_bdt) }}</div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-3">Property Type</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach(['Apartment', 'Duplex', 'Penthouse', 'Villa', 'Office', 'Showroom'] as $prop)
                                <button
                                    type="button"
                                    wire:click="$set('property_type', '{{ $prop }}')"
                                    class="py-3 px-4 rounded-xl border text-xs font-semibold transition-all {{ $property_type === $prop ? 'bg-gold text-charcoal-deep border-gold shadow' : 'bg-white text-charcoal border-black/10' }}"
                                >
                                    {{ $prop }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 2 -->
            @if($step === 2)
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-xs uppercase tracking-widest font-bold text-charcoal/70">Approximate Area (sq ft)</label>
                            <span class="font-serif text-2xl font-bold text-gold">{{ number_format($area_sqft) }} sq ft</span>
                        </div>
                        <input type="number" wire:model="area_sqft" min="100" max="100000" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm font-semibold" />
                        @error('area_sqft') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-3">Estimated Budget Range (BDT ৳)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach(['Under ৳5 Lakh', '৳5–15 Lakh', '৳15–30 Lakh', '৳30–60 Lakh', '৳60+ Lakh'] as $range)
                                <button
                                    type="button"
                                    wire:click="$set('budget_range', '{{ $range }}')"
                                    class="p-3.5 rounded-xl border text-xs font-semibold text-left transition-all {{ $budget_range === $range ? 'bg-charcoal text-gold border-gold shadow' : 'bg-white text-charcoal border-black/10' }}"
                                >
                                    {{ $range }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 3 -->
            @if($step === 3)
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Preferred Date *</label>
                            <input type="date" wire:model="preferred_date" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                            @error('preferred_date') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Preferred Time *</label>
                            <select wire:model="preferred_time" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm">
                                <option value="11:30 AM">11:30 AM (Morning Studio Session)</option>
                                <option value="02:30 PM">02:30 PM (Afternoon Consultation)</option>
                                <option value="05:00 PM">05:00 PM (Evening Review)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Floor Plan / Layout Upload (Optional PDF/JPG/PNG, max 10MB)</label>
                        <input type="file" wire:model="floor_plan" accept=".pdf,.jpg,.jpeg,.png,.webp" class="w-full px-4 py-3 rounded-xl bg-white border border-dashed border-gold/50 text-xs" />
                        <div wire:loading wire:target="floor_plan" class="text-xs text-gold mt-2">Uploading floor plan...</div>
                        @error('floor_plan') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Step 4 -->
            @if($step === 4)
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Your Name *</label>
                            <input type="text" wire:model="name" placeholder="Full Name" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                            @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Phone / WhatsApp *</label>
                            <input type="tel" wire:model="phone" placeholder="+880 17..." class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                            @error('phone') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Email Address *</label>
                        <input type="email" wire:model="email" placeholder="you@domain.com" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                        @error('email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Additional Notes / Location</label>
                        <textarea wire:model="message" rows="3" placeholder="e.g. Gulshan-2 site, handover expected next month..." class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm"></textarea>
                    </div>
                </div>
            @endif

            <!-- Navigation Footer -->
            <div class="flex items-center justify-between pt-6 border-t border-black/5">
                @if($step > 1)
                    <button type="button" wire:click="previousStep" class="px-6 py-3 rounded-full border border-charcoal/20 text-xs font-bold uppercase tracking-wider hover:border-charcoal transition-all">
                        Previous
                    </button>
                @else
                    <div></div>
                @endif

                @if($step < 4)
                    <button type="button" wire:click="nextStep" class="gold-shimmer px-8 py-3.5 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep text-xs font-bold uppercase tracking-widest shadow-lg">
                        Continue &rarr;
                    </button>
                @else
                    <button type="button" wire:click="submit" wire:loading.attr="disabled" class="gold-shimmer px-8 py-3.5 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep text-xs font-bold uppercase tracking-widest shadow-lg">
                        <span wire:loading.remove>Confirm Appointment</span>
                        <span wire:loading>Booking...</span>
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>

