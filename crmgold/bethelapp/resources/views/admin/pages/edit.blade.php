@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Edit Page</h2>
        <form action="{{ route('pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Title</label>
                <input type="text" name="title" value="{{ $page->title }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Slug</label>
                <input type="text" name="slug" value="{{ $page->slug }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Meta Description</label>
                <textarea name="meta_description" class="w-full border p-2 rounded">{{ $page->meta_description }}</textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection
