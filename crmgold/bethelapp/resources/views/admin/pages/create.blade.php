@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Create Page</h2>
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Slug</label>
                <input type="text" name="slug" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Meta Description</label>
                <textarea name="meta_description" class="w-full border p-2 rounded"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
@endsection
