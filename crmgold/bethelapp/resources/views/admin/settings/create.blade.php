@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Create Setting</h2>
        <form action="{{ route('settings.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Key</label>
                <input type="text" name="key" class="w-full border p-2 rounded" required>
                @error('key')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Value</label>
                <input type="text" name="value" class="w-full border p-2 rounded">
                @error('value')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>
@endsection
