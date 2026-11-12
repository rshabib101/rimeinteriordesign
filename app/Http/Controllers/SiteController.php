<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    public function home(): View
    {
        $services = Service::active()->take(6)->get();
        $featuredProjects = Project::featured()->with('category')->take(4)->get();
        $comparisonProject = Project::published()
            ->whereNotNull('before_image')
            ->whereNotNull('after_image')
            ->first();
        $showcase3dProject = Project::published()
            ->whereNotNull('model_3d_path')
            ->first();
        $testimonials = Testimonial::featured()->get();
        $posts = Post::published()->with('author')->take(3)->get();
        $processSteps = Setting::json('process_steps_json');

        return view('pages.home', compact(
            'services',
            'featuredProjects',
            'comparisonProject',
            'showcase3dProject',
            'testimonials',
            'posts',
            'processSteps'
        ));
    }

    public function about(): View
    {
        $teamMembers = TeamMember::active()->get();
        $awards = Setting::json('awards_json');

        return view('pages.about', compact('teamMembers', 'awards'));
    }

    public function services(): View
    {
        $services = Service::active()->get();

        return view('pages.services.index', compact('services'));
    }

    public function serviceShow(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $otherServices = Service::active()->where('id', '!=', $service->id)->take(3)->get();

        return view('pages.services.show', compact('service', 'otherServices'));
    }

    public function portfolio(): View
    {
        return view('pages.portfolio.index');
    }

    public function projectShow(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_published', true)->with('category')->firstOrFail();
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('pages.portfolio.show', compact('project', 'relatedProjects'));
    }

    public function showcase3d(): View
    {
        $projects = Project::published()->whereNotNull('model_3d_path')->get();

        return view('pages.showcase3d', compact('projects'));
    }

    public function process(): View
    {
        $processSteps = Setting::json('process_steps_json');

        return view('pages.process', compact('processSteps'));
    }

    public function blog(Request $request): View
    {
        $query = Post::published()->with('author');

        if ($request->filled('category')) {
            $query->where('category', (string) $request->string('category'));
        }

        if ($request->filled('search')) {
            $term = '%' . trim((string) $request->string('search')) . '%';
            $query->where(function ($q) use ($term): void {
                $q->where('title', 'like', $term)
                    ->orWhere('excerpt', 'like', $term)
                    ->orWhere('content', 'like', $term);
            });
        }

        if ($request->filled('tag')) {
            $tag = (string) $request->string('tag');
            $query->whereJsonContains('tags', $tag);
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Post::published()->distinct()->pluck('category');

        return view('pages.blog.index', compact('posts', 'categories'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->with('author')->firstOrFail();
        $post->increment('views_count');
        $relatedPosts = Post::published()->where('id', '!=', $post->id)->take(3)->get();

        return view('pages.blog.show', compact('post', 'relatedPosts'));
    }

    public function calculator(): View
    {
        return view('pages.calculator');
    }

    public function booking(): View
    {
        return view('pages.booking');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function faq(): View
    {
        $faqs = Faq::active()->get();
        $categories = $faqs->pluck('category')->unique()->values();

        return view('pages.faq', compact('faqs', 'categories'));
    }

    public function privacy(): View
    {
        return view('pages.legal', [
            'pageTitle' => 'Privacy Policy',
            'pageType'  => 'privacy',
        ]);
    }

    public function terms(): View
    {
        return view('pages.legal', [
            'pageTitle' => 'Terms of Service',
            'pageType'  => 'terms',
        ]);
    }

    public function sitemap(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function (): string {
            $urls = [
                ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
                ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('services.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['loc' => route('portfolio.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['loc' => route('showcase.3d'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('process'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['loc' => route('blog.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['loc' => route('calculator'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('booking'), 'priority' => '0.9', 'changefreq' => 'monthly'],
                ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('faq'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ];

            foreach (Service::active()->get() as $service) {
                $urls[] = [
                    'loc'        => route('services.show', $service->slug),
                    'lastmod'    => $service->updated_at?->toAtomString(),
                    'priority'   => '0.8',
                    'changefreq' => 'monthly',
                ];
            }

            foreach (Project::published()->get() as $project) {
                $urls[] = [
                    'loc'        => route('portfolio.show', $project->slug),
                    'lastmod'    => $project->updated_at?->toAtomString(),
                    'priority'   => '0.8',
                    'changefreq' => 'monthly',
                ];
            }

            foreach (Post::published()->get() as $post) {
                $urls[] = [
                    'loc'        => route('blog.show', $post->slug),
                    'lastmod'    => $post->updated_at?->toAtomString(),
                    'priority'   => '0.7',
                    'changefreq' => 'weekly',
                ];
            }

            return view('seo.sitemap', compact('urls'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}

