@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Manage Settings</h2>
        <a href="{{ route('settings.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Setting</a>
        <div>
            @foreach ($settings as $setting)
                <div class="setting-item p-4 border mb-2 bg-gray-50" data-id="{{ $setting->id }}">
                    <h3>{{ $setting->key }}</h3>
                    <p>Value: {{ $setting->value ?? 'No value set' }}</p>
                    <a href="{{ route('settings.edit', $setting) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
