<?php

use App\Models\NewsletterSubscriber;
use Livewire\Component;

new class extends Component
{
    public string $email = '';
    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => strtolower(trim($this->email))],
            ['ip_address' => request()->ip()]
        );

        $this->subscribed = true;
        $this->email = '';
    }
};
?>

<div class="relative w-full max-w-md">
    @if($subscribed)
        <div class="p-4 rounded-xl bg-sage/15 border border-sage/30 text-sage-light text-sm flex items-center space-x-3 transition-all duration-300">
            <svg class="w-5 h-5 text-sage shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>
                {{ app()->getLocale() === 'bn' ? 'ধন্যবাদ! আপনি সফলভাবে সাবস্ক্রাইব করেছেন।' : 'Thank you for joining our private design journal.' }}
            </span>
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-1">
                <input
                    type="email"
                    wire:model="email"
                    placeholder="{{ __('messages.footer.newsletter_placeholder') }}"
                    required
                    class="w-full px-4 py-3.5 rounded-lg bg-charcoal-card border border-white/10 text-offwhite text-sm placeholder-white/35 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-200"
                />
                @error('email')
                    <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <button
                type="submit"
                class="gold-shimmer px-6 py-3.5 rounded-lg bg-gold hover:bg-gold-hover text-charcoal-deep text-sm font-semibold tracking-wider uppercase transition-all duration-300 shadow-[0_10px_25px_rgba(184,137,77,0.25)] flex items-center justify-center space-x-2 shrink-0 cursor-pointer"
            >
                <span wire:loading.remove>{{ __('messages.cta.subscribe') }}</span>
                <span wire:loading class="inline-flex items-center space-x-2">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-charcoal-deep" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>...</span>
                </span>
            </button>
        </form>
    @endif
</div>
