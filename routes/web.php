<?php

use App\Http\Controllers\CrawlsiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Add the Inertia routes for Crawlsites
    Route::get('/crawlsites', [CrawlsiteController::class, 'index'])
        ->name('crawlsites.index');

    Route::get('/crawlsites/create', [CrawlsiteController::class, 'create'])
        ->name('crawlsites.create');

    Route::post('/crawlsites', [CrawlsiteController::class, 'store'])->name('crawlsites.store');
    Route::get('/crawlsites/{crawlsite}', [CrawlsiteController::class, 'show'])
        ->name('crawlsites.show');

    Route::get('/crawlsites/{crawlsite}/edit', [CrawlsiteController::class, 'edit'])
        ->name('crawlsites.edit');

    Route::put('/crawlsites/{crawlsite}', [CrawlsiteController::class, 'update'])->name('crawlsites.update');
    Route::delete('/crawlsites/{crawlsite}', [CrawlsiteController::class, 'destroy'])
        ->name('crawlsites.destroy');
});

require __DIR__.'/auth.php';
