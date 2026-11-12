<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public ?int $service_id = null;

    public string $message = '';

    /** Honeypot field: real users leave this blank. */
    public string $website = '';

    public bool $submitted = false;

    public ?string $bookingNumber = null;

    public ?string $rateLimitError = null;

    public function submit(): void
    {
        $this->rateLimitError = null;

        // Honeypot spam check
        if ($this->website !== '') {
            $this->submitted = true;
            return;
        }

        $key = 'contact-form:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->rateLimitError = 'Too many inquiries sent recently. Please try again in a few minutes or contact us on WhatsApp.';
            return;
        }
        RateLimiter::hit($key, 300);

        $validated = $this->validate([
            'name'       => ['required', 'string', 'min:2', 'max:120'],
            'email'      => ['required', 'email', 'max:150'],
            'phone'      => ['required', 'string', 'min:6', 'max:30'],
            'service_id' => ['nullable', 'exists:services,id'],
            'message'    => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $inquiry = Inquiry::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'service_id'    => $validated['service_id'],
            'property_type' => 'Consultation',
            'message'       => $validated['message'],
            'status'        => 'New',
        ]);

        $this->bookingNumber = $inquiry->booking_number;
        $this->submitted = true;
        $this->reset(['name', 'email', 'phone', 'service_id', 'message']);
    }

    public function render(): View
    {
        return view('livewire.contact-form', [
            'services' => Service::active()->get(),
        ]);
    }
}

