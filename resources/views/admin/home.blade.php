<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        @include('admin.components.sidebar')

        <div class="ml-64 flex-1">
            @include('admin.components.header')

            <main class="p-6">
                @include('admin.components.overview')
                @include('admin.components.users')
                @include('admin.components.products')
                @include('admin.components.statistics')
            </main>
        </div>
    </div>

    @include('admin.components.scripts')
</body>
</html>
