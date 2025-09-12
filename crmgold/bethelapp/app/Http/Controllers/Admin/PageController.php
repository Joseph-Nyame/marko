<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        $settings = Setting::pluck('value', 'key');
        return view('admin.pages.index', compact('pages', 'settings'));
    }

    public function create()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.pages.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug',
            'status' => 'required|in:draft,published',
            'meta_description' => 'nullable|string',
        ]);

        Page::create($request->all());
        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.pages.edit', compact('page', 'settings'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug,' . $page->id,
            'status' => 'required|in:draft,published',
            'meta_description' => 'nullable|string',
        ]);

        $page->update($request->all());
        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
