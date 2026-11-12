<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuoteCalculator extends Component
{
    public string $propertyType = 'Apartment';

    public string $roomScope = 'full_home';

    public int $areaSqft = 2200;

    public string $finishTier = 'premium';

    public bool $includeKitchen = true;

    public bool $includeLighting = false;

    public bool $includeVr = true;

    /**
     * @return array<string, int>
     */
    public function getRatesProperty(): array
    {
        return [
            'standard' => (int) Setting::get('bdt_rate_standard', '1800'),
            'premium'  => (int) Setting::get('bdt_rate_premium', '2800'),
            'luxury'   => (int) Setting::get('bdt_rate_luxury', '4200'),
        ];
    }

    /**
     * @return array{min: int, max: int, per_sqft: int, addons: int}
     */
    public function getEstimateProperty(): array
    {
        $rates = $this->rates;
        $baseRate = $rates[$this->finishTier] ?? $rates['premium'];

        $scopeMultiplier = match ($this->roomScope) {
            'living_dining' => 0.45,
            'master_suite'  => 0.35,
            'kitchen_only'  => 0.30,
            'office_suite'  => 1.05,
            default         => 1.0,
        };

        $area = max(150, min(25000, $this->areaSqft));
        $baseTotal = (int) round($area * $baseRate * $scopeMultiplier);

        $addons = 0;
        if ($this->includeKitchen && $this->roomScope !== 'kitchen_only') {
            $addons += match ($this->finishTier) {
                'luxury'   => 480000,
                'premium'  => 320000,
                default    => 200000,
            };
        }
        if ($this->includeLighting) {
            $addons += (int) round($area * 160);
        }
        if ($this->includeVr) {
            $addons += 60000;
        }

        $total = $baseTotal + $addons;

        return [
            'min'      => (int) round($total * 0.92),
            'max'      => (int) round($total * 1.12),
            'per_sqft' => $baseRate,
            'addons'   => $addons,
        ];
    }

    public function render(): View
    {
        return view('livewire.quote-calculator', [
            'rates'    => $this->rates,
            'estimate' => $this->estimate,
        ]);
    }
}

