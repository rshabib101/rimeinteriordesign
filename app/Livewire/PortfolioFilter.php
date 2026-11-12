<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class PortfolioFilter extends Component
{
    #[Url]
    public string $category = 'all';

    #[Url]
    public string $roomType = 'all';

    #[Url]
    public string $style = 'all';

    #[Url]
    public string $search = '';

    public function resetFilters(): void
    {
        $this->category = 'all';
        $this->roomType = 'all';
        $this->style = 'all';
        $this->search = '';
    }

    public function render(): View
    {
        $query = Project::query()->published()->with('category');

        if ($this->category !== 'all') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->roomType !== 'all') {
            $query->where('room_type', $this->roomType);
        }

        if ($this->style !== 'all') {
            $query->where('style', $this->style);
        }

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term): void {
                $q->where('title', 'like', $term)
                    ->orWhere('title_bn', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('summary', 'like', $term);
            });
        }

        return view('livewire.portfolio-filter', [
            'projects'   => $query->get(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'roomTypes'  => [
                'living'     => 'Living Room',
                'bedroom'    => 'Bedroom',
                'kitchen'    => 'Kitchen',
                'office'     => 'Office',
                'dining'     => 'Dining Room',
                'full_house' => 'Full Residence',
            ],
            'styles' => ['Modern', 'Minimal', 'Classic', 'Scandinavian', 'Contemporary', 'Japandi'],
        ]);
    }
}

