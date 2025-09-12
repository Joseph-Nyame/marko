<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ $settings['site_name'] ?? 'Bethel Gold' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        /* Minimal admin styles */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container flex justify-between items-center">
            <h1 class="text-xl">Admin - {{ $settings['site_name'] ?? 'Bethel Gold' }}</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('pages.index') }}" class="hover:text-yellow-400">Pages</a></li>
                    <li><a href="{{ route('blocks.index') }}" class="hover:text-yellow-400">Blocks</a></li>
                    <li><a href="{{ route('menus.index') }}" class="hover:text-yellow-400">Menus</a></li>
                    <li><a href="{{ route('settings.index') }}" class="hover:text-yellow-400">Settings</a></li>
                    <li><a href="{{ route('logout') }}" class="hover:text-yellow-400">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mt-6">
        @yield('content')
    </main>
</body>
</html>
