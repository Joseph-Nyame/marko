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
    $settings = Setting::pluck('value', 'key')->toArray();
    $menu = MenuItem::orderBy('order')->get();
    return view('frontend.page', compact('page', 'blocks', 'settings', 'menu'));
});

Route::get('/dashboard', function () {
    $pages = Page::all();
    $settings = Setting::pluck('value', 'key');
    return view('admin.pages.index', compact('pages', 'settings'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('pages', PageController::class);
    Route::resource('blocks', BlockController::class);  // Nested under pages in views later
    // Route::resource('menus', MenuController::class);
    // Route::resource('settings', SettingController::class);
    Route::get('preview/{slug}', [FrontendController::class, 'preview'])->name('admin.preview');
    Route::post('blocks/reorder', [BlockController::class, 'reorder'])->name('blocks.reorder');

    Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menu/{menuItem}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menu/{menuItem}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menu/{menuItem}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/menu/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');
});


require __DIR__.'/auth.php';


Route::get('/{slug?}', [FrontendController::class, 'show'])->name('page.show')->where('slug', '.*');
