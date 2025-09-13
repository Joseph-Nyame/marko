@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Edit Menu Item</h2>
        <form action="{{ route('menus.update', $menuItem) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700">Label</label>
                <input type="text" name="label" value="{{ $menuItem->label }}" class="w-full border p-2 rounded" required>
                @error('label')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">URL</label>
                <input type="url" name="url" value="{{ $menuItem->url }}" class="w-full border p-2 rounded" required>
                @error('url')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Order</label>
                <input type="number" name="order" value="{{ $menuItem->order }}" class="w-full border p-2 rounded" min="0" required>
                @error('order')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection
