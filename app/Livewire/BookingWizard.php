<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookingWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    #[Url]
    public ?int $service_id = null;

    #[Url]
    public string $property_type = 'Apartment';

    #[Url]
    public int $area_sqft = 2200;

    #[Url]
    public string $budget_range = '৳15–30 Lakh';

    public string $preferred_date = '';

    public string $preferred_time = '11:30 AM';

    /** @var mixed */
    public $floor_plan = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $message = '';

    public string $website = '';

    public bool $completed = false;

    public ?string $bookingNumber = null;

    public ?string $rateLimitError = null;

    public function mount(): void
    {
        if (empty($this->preferred_date)) {
            $this->preferred_date = now()->addDays(3)->format('Y-m-d');
        }
        if (empty($this->service_id)) {
            $this->service_id = Service::active()->value('id');
        }
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'service_id'    => ['nullable', 'exists:services,id'],
                'property_type' => ['required', 'string', 'max:100'],
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'area_sqft'    => ['required', 'integer', 'min:100', 'max:100000'],
                'budget_range' => ['required', 'string', 'max:100'],
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'preferred_date' => ['required', 'date'],
                'preferred_time' => ['required', 'string', 'max:50'],
                'floor_plan'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
            ]);
        }

        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submit(): void
    {
        $this->rateLimitError = null;

        if ($this->website !== '') {
            $this->completed = true;
            return;
        }

        $key = 'booking-wizard:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->rateLimitError = 'Rate limit exceeded. Please try again in a few minutes.';
            return;
        }
        RateLimiter::hit($key, 300);

        $validated = $this->validate([
            'service_id'     => ['nullable', 'exists:services,id'],
            'property_type'  => ['required', 'string', 'max:100'],
            'area_sqft'      => ['required', 'integer', 'min:100', 'max:100000'],
            'budget_range'   => ['required', 'string', 'max:100'],
            'preferred_date' => ['required', 'date'],
            'preferred_time' => ['required', 'string', 'max:50'],
            'floor_plan'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
            'name'           => ['required', 'string', 'min:2', 'max:120'],
            'email'          => ['required', 'email', 'max:150'],
            'phone'          => ['required', 'string', 'min:6', 'max:30'],
            'message'        => ['nullable', 'string', 'max:2000'],
        ]);

        $floorPlanPath = null;
        if ($this->floor_plan) {
            $floorPlanPath = $this->floor_plan->store('floor-plans', 'public');
        }

        $inquiry = Inquiry::create([
            'service_id'      => $validated['service_id'],
            'property_type'   => $validated['property_type'],
            'area_sqft'       => $validated['area_sqft'],
            'budget_range'    => $validated['budget_range'],
            'preferred_date'  => $validated['preferred_date'],
            'preferred_time'  => $validated['preferred_time'],
            'floor_plan_path' => $floorPlanPath,
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'],
            'message'         => $validated['message'] ?? null,
            'status'          => 'New',
        ]);

        $this->bookingNumber = $inquiry->booking_number;
        $this->completed = true;
    }

    public function render(): View
    {
        return view('livewire.booking-wizard', [
            'services' => Service::active()->get(),
        ]);
    }
}

