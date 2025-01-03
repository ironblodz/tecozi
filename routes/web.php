<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Portfolio\CategoriesController as PortfolioCategoriesController;
use App\Http\Controllers\Portfolio\ImagesController as PortfolioImagesController;
use App\Http\Controllers\Portfolio\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Portfolio;
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

    Route::get('/backoffice/contacts', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/backoffice/contacts/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/backoffice/contacts/store', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/backoffice/contacts/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::post('/backoffice/contacts/update', [ContactController::class, 'update'])->name('contact.update');
    Route::post('/backoffice/contacts/delete/', [ContactController::class, 'destroy'])->name('contact.destroy');

    Route::get('/backoffice/portfolios', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/backoffice/portfolios/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/backoffice/portfolios/store', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/backoffice/portfolios/edit/{id}', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::post('/backoffice/portfolios/update', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::post('/backoffice/portfolios/delete/', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::post('/backoffice/portfolios/toggle-highlight', [PortfolioController::class, 'toggleHighlight']);
    Route::post('/backoffice/portfolios/toggle-archive', [PortfolioController::class, 'toggleArchive']);


    Route::get('/backoffice/portfolios/categories', [PortfolioCategoriesController::class, 'index'])->name('portfolio.categories.index');
    Route::get('/backoffice/portfolios/categories/create', [PortfolioCategoriesController::class, 'create'])->name('portfolio.categories.create');
    Route::post('/backoffice/portfolios/categories/store', [PortfolioCategoriesController::class, 'store'])->name('portfolio.categories.store');
    Route::get('/backoffice/portfolios/categories/edit/{id}', [PortfolioCategoriesController::class, 'edit'])->name('portfolio.categories.edit');
    Route::post('/backoffice/portfolios/categories/update', [PortfolioCategoriesController::class, 'update'])->name('portfolio.categories.update');
    Route::post('/backoffice/portfolios/categories/delete/', [PortfolioCategoriesController::class, 'destroy'])->name('portfolio.categories.destroy');

    Route::post('/backoffice/portfolios/upload-image', [PortfolioImagesController::class, 'store'])->name('portfolio.images.store');
    Route::post('/backoffice/portfolios/remove-image', [PortfolioImagesController::class, 'remove'])->name('portfolio.images.remove');
});

Route::get('/api/portfolios', [PortfolioController::class, 'getPortfolios'])->name('portfolio.api');
Route::get('/api/categories', [PortfolioCategoriesController::class, 'getCategories'])->name('categories.api');
Route::get('/api/featured-portfolios', function () {
    // Supondo que você tenha uma coluna 'highlighted' no modelo Portfolio
    $featuredPortfolios = Portfolio::where('highlighted', true)->get();
    return response()->json($featuredPortfolios);
});


Route::get('/', function () {
    return Inertia::render('Home');
})->name('frontoffice.index');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/services', function () {
    return Inertia::render('Services');
})->name('services');

Route::get('/materials', function () {
    return Inertia::render('Material');
})->name('materials');

Route::get('/contacts', function () {
    return Inertia::render('Contact');
})->name('contacts');

Route::get('/portfolio', function () {
    return Inertia::render('Portfolio');
})->name('portfolio');


require __DIR__.'/auth.php';
