<?php

use App\Models\Page;
use App\Models\Setting;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/', function () {
    $slug = 'home';
    $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();
    $blocks = $page->blocks()->orderBy('order')->get();
    dd($blocks);
    $settings = Setting::pluck('value', 'key')->toArray();
    $menu = MenuItem::orderBy('order')->get();
    return view('frontend.page', compact('page', 'blocks', 'settings', 'menu'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{slug?}', [FrontendController::class, 'show'])->name('page.show')->where('slug', '.*');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
// Admin Routes (protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('pages', PageController::class);
    Route::resource('blocks', BlockController::class);  // Nested under pages in views later
    Route::resource('menus', MenuController::class);
    Route::resource('settings', SettingController::class);
    Route::get('preview/{slug}', [FrontendController::class, 'preview'])->name('admin.preview');
    Route::post('blocks/reorder', [BlockController::class, 'reorder'])->name('blocks.reorder');
});

require __DIR__.'/auth.php';
