@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Manage Menu Items</h2>
        <a href="{{ route('menus.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Menu Item</a>
        <div id="sortable-menu-items">
            @foreach ($menuItems as $menuItem)
                <div class="menu-item p-4 border mb-2 bg-gray-50" data-id="{{ $menuItem->id }}">
                    <h3>{{ $menuItem->label }} (Order: {{ $menuItem->order }})</h3>
                    <p>URL: {{ $menuItem->url }}</p>
                    <a href="{{ route('menus.edit', $menuItem) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('menus.destroy', $menuItem) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        Sortable.create(document.getElementById('sortable-menu-items'), {
            handle: '.menu-item',
            animation: 150,
            onEnd: function (evt) {
                const menuItemIds = Array.from(evt.from.children).map(item => item.dataset.id);
                fetch('/admin/menu/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ menuItemIds }),
                }).then(response => response.json()).then(data => {
                    alert(data.message);
                });
            },
        });
    </script>
@endsection
