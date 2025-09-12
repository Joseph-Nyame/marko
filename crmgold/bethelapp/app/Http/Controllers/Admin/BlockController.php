<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::with('page')->get();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
    {
        $pages = Page::all();
        return view('admin.blocks.create', compact('pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'type' => 'required|in:hero,section_title,text_image,grid,contact,steps,testimonials,live_prices',
            'content.headline' => 'required_if:type,hero,text_image|string|nullable',
            'content.subtext' => 'required_if:type,hero|string|nullable',
            'content.cta_text' => 'required_if:type,hero|string|nullable',
            'content.cta_url' => 'required_if:type,hero|string|nullable',
            'content.background_image' => 'required_if:type,hero|image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.title' => 'required_if:type,section_title|string|nullable',
            'content.subtitle' => 'required_if:type,section_title|string|nullable',
            'content.text.*' => 'required_if:type,text_image|string|nullable',
            'content.image' => 'required_if:type,text_image|image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.image_position' => 'required_if:type,text_image|in:left,right|nullable',
            'content.items.*.icon' => 'required_if:type,grid|string|nullable',
            'content.items.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.items.*.title' => 'required_if:type,grid|string|nullable',
            'content.items.*.description' => 'required_if:type,grid|string|nullable',
            'content.info.*.icon' => 'required_if:type,contact|string|nullable',
            'content.info.*.detail' => 'required_if:type,contact|string|nullable',
            'content.form.fields' => 'required_if:type,contact|string|nullable',
            'content.steps.*.title' => 'required_if:type,steps|string|nullable',
            'content.steps.*.description' => 'required_if:type,steps|string|nullable',
            'content.items.*.quote' => 'required_if:type,testimonials|string|nullable',
            'content.items.*.client' => 'required_if:type,testimonials|string|nullable',
            'content.prices.gold' => 'required_if:type,live_prices|numeric|nullable',
            'content.prices.silver' => 'required_if:type,live_prices|numeric|nullable',
            'content.prices.platinum' => 'required_if:type,live_prices|numeric|nullable',
            'content.calculator' => 'nullable',
            'status' => 'required|in:draft,published',
        ]);

        $content = $request->input('content', []);

        // Handle file uploads
        if ($request->hasFile('content.background_image')) {
            $content['background_image'] = '/storage/' . $request->file('content.background_image')->store('images', 'public');
        }
        if ($request->hasFile('content.image')) {
            $content['image'] = '/storage/' . $request->file('content.image')->store('images', 'public');
        }
        if ($request->hasFile('content.items')) {
            foreach ($request->file('content.items') as $index => $item) {
                if (isset($item['image']) && $item['image']->isValid()) {
                    $content['items'][$index]['image'] = '/storage/' . $item['image']->store('images', 'public');
                }
            }
        }

        Block::create([
            'page_id' => $request->page_id,
            'type' => $request->type,
            'content' => $content,
            'order' => Block::where('page_id', $request->page_id)->max('order') + 1,
            'status' => $request->status,
        ]);

        return redirect()->route('blocks.index')->with('success', 'Block created successfully.');
    }

    public function edit(Block $block)
    {
        $pages = Page::all();
        return view('admin.blocks.edit', compact('block', 'pages'));
    }

    public function update(Request $request, Block $block)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'type' => 'required|in:hero,section_title,text_image,grid,contact,steps,testimonials,live_prices',
            'content.headline' => 'required_if:type,hero,text_image|string|nullable',
            'content.subtext' => 'required_if:type,hero|string|nullable',
            'content.cta_text' => 'required_if:type,hero|string|nullable',
            'content.cta_url' => 'required_if:type,hero|string|nullable',
            'content.background_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.title' => 'required_if:type,section_title|string|nullable',
            'content.subtitle' => 'required_if:type,section_title|string|nullable',
            'content.text.*' => 'required_if:type,text_image|string|nullable',
            'content.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.image_position' => 'required_if:type,text_image|in:left,right|nullable',
            'content.items.*.icon' => 'required_if:type,grid|string|nullable',
            'content.items.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'content.items.*.title' => 'required_if:type,grid|string|nullable',
            'content.items.*.description' => 'required_if:type,grid|string|nullable',
            'content.info.*.icon' => 'required_if:type,contact|string|nullable',
            'content.info.*.detail' => 'required_if:type,contact|string|nullable',
            'content.form.fields' => 'required_if:type,contact|string|nullable',
            'content.steps.*.title' => 'required_if:type,steps|string|nullable',
            'content.steps.*.description' => 'required_if:type,steps|string|nullable',
            'content.items.*.quote' => 'required_if:type,testimonials|string|nullable',
            'content.items.*.client' => 'required_if:type,testimonials|string|nullable',
            'content.prices.gold' => 'required_if:type,live_prices|numeric|nullable',
            'content.prices.silver' => 'required_if:type,live_prices|numeric|nullable',
            'content.prices.platinum' => 'required_if:type,live_prices|numeric|nullable',
            'content.calculator' => 'nullable',
            'status' => 'required|in:draft,published',
        ]);

        $content = $request->input('content', []);

        // Handle file uploads
        if ($request->hasFile('content.background_image')) {
            // Optionally delete old image
            if (isset($block->content['background_image'])) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $block->content['background_image']));
            }
            $content['background_image'] = '/storage/' . $request->file('content.background_image')->store('images', 'public');
        } else {
            $content['background_image'] = $block->content['background_image'] ?? null;
        }

        if ($request->hasFile('content.image')) {
            if (isset($block->content['image'])) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $block->content['image']));
            }
            $content['image'] = '/storage/' . $request->file('content.image')->store('images', 'public');
        } else {
            $content['image'] = $block->content['image'] ?? null;
        }

        if ($request->hasFile('content.items')) {
            foreach ($request->file('content.items') as $index => $item) {
                if (isset($item['image']) && $item['image']->isValid()) {
                    if (isset($block->content['items'][$index]['image'])) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $block->content['items'][$index]['image']));
                    }
                    $content['items'][$index]['image'] = '/storage/' . $item['image']->store('images', 'public');
                } else {
                    $content['items'][$index]['image'] = $block->content['items'][$index]['image'] ?? null;
                }
            }
        }

        $block->update([
            'page_id' => $request->page_id,
            'type' => $request->type,
            'content' => $content,
            'status' => $request->status,
        ]);

        return redirect()->route('blocks.index')->with('success', 'Block updated successfully.');
    }

    public function destroy(Block $block)
    {
        // Delete associated images
        if (isset($block->content['background_image'])) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $block->content['background_image']));
        }
        if (isset($block->content['image'])) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $block->content['image']));
        }
        if (isset($block->content['items'])) {
            foreach ($block->content['items'] as $item) {
                if (isset($item['image'])) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $item['image']));
                }
            }
        }

        $block->delete();
        return redirect()->route('blocks.index')->with('success', 'Block deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $blockIds = $request->input('order', []);
        foreach ($blockIds as $index => $blockId) {
            Block::where('id', $blockId)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}
