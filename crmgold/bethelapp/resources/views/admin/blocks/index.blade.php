@extends('admin.layouts.admin')

@section('content')

    <div class="bg-white p-6 rounded shadow">

        <a href="{{ route('blocks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Block</a>
            @foreach ($blocks as $block)
          <h2 class="text-2xl mb-4">Manage Blocks for {{ $block->page->title }}</h2>
              <div id="sortable-blocks">

                <div class="block-item p-4 border mb-2 bg-gray-50" data-id="{{ $block->id }}">
                    <h3>{{ $block->type }} (Order: {{ $block->order }}) - {{ $block->status }}</h3>
                    <p>{{ json_encode($block->content) }}</p>
                    <a href="{{ route('blocks.edit', $block) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('blocks.destroy', $block) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        Sortable.create(document.getElementById('sortable-blocks'), {
            handle: '.block-item',
            animation: 150,
            onEnd: function (evt) {
                const blockIds = Array.from(evt.from.children).map(item => item.dataset.id);
                fetch('/admin/blocks/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ blockIds }),
                }).then(response => response.json()).then(data => {
                    alert(data.message);
                });
            },
        });
    </script>
@endsection
