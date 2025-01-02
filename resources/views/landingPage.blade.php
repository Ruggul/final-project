<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex space-x-7">
                    <div>
                        <a href="#" class="flex items-center py-4">
                            <img src="/design/tradeGateLogo.png" alt="Logo" class="h-8 w-8 mr-2">
                            <span class="font-semibold text-gray-500 text-lg">Trade gate</span>
                        </a>
                    </div>
                </div>
                <!-- Login / Register -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="#" class="py-2 px-4 font-medium text-gray-500 hover:text-blue-500 transition duration-300">Login</a>
                    <a href="#" class="py-2 px-4 font-medium text-white bg-blue-500 rounded hover:bg-blue-400 transition duration-300">Register</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <i class="fas fa-bars text-gray-500 text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="hidden mobile-menu md:hidden">
            <ul class="px-4">
                <li><a href="#" class="block text-sm px-2 py-4 text-white bg-blue-500 font-semibold">Home</a></li>
                <li><a href="#" class="block text-sm px-2 py-4 hover:bg-blue-500 hover:text-white transition duration-300">About</a></li>
                <li><a href="#" class="block text-sm px-2 py-4 hover:bg-blue-500 hover:text-white transition duration-300">Services</a></li>
                <li><a href="#" class="block text-sm px-2 py-4 hover:bg-blue-500 hover:text-white transition duration-300">Contact</a></li>
                <li><a href="#" class="block text-sm px-2 py-4 hover:bg-blue-500 hover:text-white transition duration-300">Login</a></li>
                <li><a href="#" class="block text-sm px-2 py-4 hover:bg-blue-500 hover:text-white transition duration-300">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">Welcome to Our Website</h1>
                <h2 class="text-xl mb-8 text-gray-600">The best place to find what you need</h2>
                <button class="bg-blue-500 text-white font-bold rounded-full py-4 px-8 shadow-lg uppercase tracking-wider hover:bg-blue-400 transition duration-300">
                    Get Started
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Mobile Menu -->
    <script>
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</body>
</html>
