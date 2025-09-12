<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function show($slug = 'home')
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $blocks = $page->blocks()->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $menu = MenuItem::orderBy('order')->get();
        return view('frontend.page', compact('page', 'blocks', 'settings', 'menu'));
    }

    public function preview($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $blocks = $page->blocks()->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $menu = MenuItem::orderBy('order')->get();
        return view('frontend.page', compact('page', 'blocks', 'settings', 'menu'));
    }
}
