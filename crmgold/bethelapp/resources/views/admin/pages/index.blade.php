@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Manage Pages</h2>
        <a href="{{ route('pages.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Create New Page</a>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Title</th>
                    <th class="p-2">Slug</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td class="p-2">{{ $page->title }}</td>
                        <td class="p-2">{{ $page->slug }}</td>
                        <td class="p-2">{{ $page->status }}</td>
                        <td class="p-2">
                            <a href="{{ route('pages.edit', $page) }}" class="text-blue-500">Edit</a>
                            <a href="{{ route('admin.preview', $page->slug) }}" class="text-green-500 ml-2">Preview</a>
                            <form action="{{ route('pages.destroy', $page) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('blocks.index', ['page_id' => $page->id]) }}" class="text-purple-500 ml-2">Manage Blocks</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
