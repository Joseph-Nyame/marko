@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Create Menu Item</h2>
        <form action="{{ route('menu.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Label</label>
                <input type="text" name="label" class="w-full border p-2 rounded" required>
                @error('label')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">URL</label>
                <input type="url" name="url" class="w-full border p-2 rounded" required>
                @error('url')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Order</label>
                <input type="number" name="order" class="w-full border p-2 rounded" min="0" required>
                @error('order')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>
@endsection
