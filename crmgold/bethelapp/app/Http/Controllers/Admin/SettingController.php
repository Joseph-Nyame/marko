<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created setting in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'nullable|string',
        ]);

        Setting::create($request->all());
        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified setting in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key,' . $setting->id,
            'value' => 'nullable|string',
        ]);

        $setting->update($request->all());
        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }

    /**
     * Remove the specified setting from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }
}
