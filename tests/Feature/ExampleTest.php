<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\BookingWizard;
use App\Livewire\ContactForm;
use App\Livewire\PortfolioFilter;
use App\Livewire\QuoteCalculator;
use App\Models\Inquiry;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_all_public_pages_render_successfully(): void
    {
        $routes = [
            '/',
            '/about',
            '/services',
            '/portfolio',
            '/3d-showcase',
            '/process',
            '/blog',
            '/cost-estimator',
            '/book-consultation',
            '/contact',
            '/faq',
            '/privacy-policy',
            '/terms',
            '/sitemap.xml',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
        }

        $service = Service::firstOrFail();
        $this->get(route('services.show', $service->slug))->assertStatus(200);

        $project = Project::published()->firstOrFail();
        $this->get(route('portfolio.show', $project->slug))->assertStatus(200);

        $post = Post::published()->firstOrFail();
        $this->get(route('blog.show', $post->slug))->assertStatus(200);
    }

    public function test_language_switcher_switches_locale(): void
    {
        $response = $this->get('/locale/bn');
        $response->assertSessionHas('locale', 'bn');
    }

    public function test_dynamic_settings_reflect_on_frontend(): void
    {
        Setting::set('tagline', 'Custom Architectural Studio Headline', 'hero');

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Custom Architectural Studio Headline');
    }

    public function test_portfolio_filter_livewire_filters_by_style(): void
    {
        Livewire::test(PortfolioFilter::class)
            ->set('style', 'Minimal')
            ->assertSee('Minimalist Sanctuary Villa')
            ->assertDontSee('The Brass & Oak Penthouse');
    }

    public function test_quote_calculator_calculates_using_admin_rates(): void
    {
        Setting::set('bdt_rate_premium', '3000', 'pricing');

        Livewire::test(QuoteCalculator::class)
            ->set('areaSqft', 2000)
            ->set('finishTier', 'premium')
            ->set('includeKitchen', false)
            ->set('includeLighting', false)
            ->set('includeVr', false)
            ->assertSee('৳3,000 / sq ft');
    }

    public function test_contact_form_creates_inquiry_and_honors_honeypot(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Test Client')
            ->set('email', 'client@example.com')
            ->set('phone', '+8801711111111')
            ->set('message', 'We want a full interior design for our Gulshan duplex.')
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('inquiries', [
            'email'  => 'client@example.com',
            'status' => 'New',
        ]);

        // Honeypot filled -> silently accepted without saving
        Livewire::test(ContactForm::class)
            ->set('name', 'Bot Name')
            ->set('email', 'bot@spam.example')
            ->set('phone', '+8801700000000')
            ->set('message', 'Spam message here')
            ->set('website', 'https://spam.example')
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseMissing('inquiries', ['email' => 'bot@spam.example']);
    }

    public function test_booking_wizard_submits_consultation(): void
    {
        $countBefore = Inquiry::count();

        Livewire::test(BookingWizard::class)
            ->set('property_type', 'Penthouse')
            ->call('nextStep')
            ->set('area_sqft', 3500)
            ->set('budget_range', '৳30–60 Lakh')
            ->call('nextStep')
            ->set('preferred_date', now()->addDays(4)->format('Y-m-d'))
            ->set('preferred_time', '02:30 PM')
            ->call('nextStep')
            ->set('name', 'Booking Client')
            ->set('email', 'booking@example.com')
            ->set('phone', '+8801811223344')
            ->call('submit')
            ->assertSet('completed', true);

        $this->assertSame($countBefore + 1, Inquiry::count());
    }

    public function test_admin_panel_login_and_authenticated_resources_are_accessible(): void
    {
        $this->get('/admin/login')->assertStatus(200);

        $admin = User::where('email', 'admin@rimeinterior.com')->firstOrFail();

        $this->actingAs($admin);

        foreach ([
            '/admin',
            '/admin/projects',
            '/admin/categories',
            '/admin/services',
            '/admin/posts',
            '/admin/inquiries',
            '/admin/testimonials',
            '/admin/team-members',
            '/admin/faqs',
            '/admin/newsletter-subscribers',
            '/admin/users',
            '/admin/manage-settings',
        ] as $adminUri) {
            $this->get($adminUri)->assertStatus(200);
        }
    }
}
