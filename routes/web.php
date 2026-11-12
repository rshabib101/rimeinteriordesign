<?php

declare(strict_types=1);

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');

Route::get('/services', [SiteController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [SiteController::class, 'serviceShow'])->name('services.show');

Route::get('/portfolio', [SiteController::class, 'portfolio'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [SiteController::class, 'projectShow'])->name('portfolio.show');

Route::get('/3d-showcase', [SiteController::class, 'showcase3d'])->name('showcase.3d');
Route::get('/process', [SiteController::class, 'process'])->name('process');

Route::get('/blog', [SiteController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [SiteController::class, 'blogShow'])->name('blog.show');

Route::get('/cost-estimator', [SiteController::class, 'calculator'])->name('calculator');
Route::get('/book-consultation', [SiteController::class, 'booking'])->name('booking');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [SiteController::class, 'privacy'])->name('privacy');
Route::get('/terms', [SiteController::class, 'terms'])->name('terms');

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

Route::get('/locale/{lang}', function (string $lang) {
    if (in_array($lang, ['en', 'bn'], strict: true)) {
        Session::put('locale', $lang);
    }

    return back();
})->name('locale.switch');
