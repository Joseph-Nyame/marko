<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('order')->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|url',
            'order' => 'required|integer|min:0',
        ]);

        MenuItem::create([
            'label' => $request->label,
            'url' => $request->url,
            'order' => $request->order,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|url',
            'order' => 'required|integer|min:0',
        ]);

        $menuItem->update([
            'label' => $request->label,
            'url' => $request->url,
            'order' => $request->order,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        // Reorder remaining items to avoid gaps
        MenuItem::where('order', '>', $menuItem->order)->decrement('order');
        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $menuItemIds = $request->input('menuItemIds', []);
        foreach ($menuItemIds as $index => $menuItemId) {
            MenuItem::where('id', $menuItemId)->update(['order' => $index + 1]);
        }
        return response()->json(['message' => 'Menu items reordered successfully']);
    }
}
