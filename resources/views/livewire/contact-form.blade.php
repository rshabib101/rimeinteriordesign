<div>
    @if($submitted)
        <div class="rounded-3xl bg-emerald-950/90 text-offwhite p-8 sm:p-10 border border-emerald-500/30 text-center space-y-4 shadow-2xl">
            <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="font-serif text-3xl font-bold text-gold">Inquiry Received</h3>
            <p class="text-sm text-offwhite/80 max-w-md mx-auto">
                Thank you for reaching out to Asad Interior Design. Our senior concierge team will respond within 24 hours.
            </p>
            @if($bookingNumber)
                <div class="inline-block px-4 py-2 rounded-full bg-white/10 text-xs font-mono text-gold-light">
                    Reference: {{ $bookingNumber }}
                </div>
            @endif
            <div>
                <button wire:click="$set('submitted', false)" class="text-xs underline text-gold hover:text-gold-light">
                    Send another message
                </button>
            </div>
        </div>
    @else
        <form wire:submit="submit" class="glass-card-light rounded-3xl p-6 sm:p-10 space-y-5 border border-black/5 shadow-xl">
            @if($rateLimitError)
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium">
                    {{ $rateLimitError }}
                </div>
            @endif

            <!-- Honeypot spam trap -->
            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Full Name *</label>
                    <input type="text" wire:model="name" placeholder="e.g. Farhana Ahmed" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                    @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Phone / WhatsApp *</label>
                    <input type="tel" wire:model="phone" placeholder="+880 1711 000 000" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                    @error('phone') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Email Address *</label>
                    <input type="email" wire:model="email" placeholder="you@domain.com" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm" />
                    @error('email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Service Interest</label>
                    <select wire:model="service_id" class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm">
                        <option value="">General Studio Inquiry</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->localized_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest font-bold text-charcoal/70 mb-2">Your Project Vision *</label>
                <textarea wire:model="message" rows="4" placeholder="Tell us about your apartment, villa, or office location, approximate sq ft, and desired timeline..." class="w-full px-4 py-3.5 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm"></textarea>
                @error('message') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="gold-shimmer w-full py-4 rounded-full bg-gold hover:bg-gold-hover text-charcoal-deep font-bold text-xs uppercase tracking-widest transition-all shadow-[0_10px_30px_rgba(184,137,77,0.3)]"
            >
                <span wire:loading.remove>{{ __('messages.cta.send_message') }}</span>
                <span wire:loading>Dispatching to Studio...</span>
            </button>
        </form>
    @endif
</div>

