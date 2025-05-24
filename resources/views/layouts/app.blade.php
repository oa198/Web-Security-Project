<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                    },
                    borderRadius: {
                        'large': '16px',
                        'extra-large': '28px',
                    },
                    screens: {
                        'xs': '480px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1536px',
                    },
                },
            },
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #8b5cf6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6d28d9;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        @if(request()->is('login') || request()->is('register') || request()->is('password/*') || !auth()->check())
            <!-- Main Content for Auth Pages (Full Width) -->
            <main class="flex-1 min-w-0 overflow-auto">
        @else
            <!-- Sidebar for Authenticated Pages -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 min-w-0 overflow-auto">
                <!-- Top Navigation -->
                @include('layouts.header')
        @endif

            <!-- Page Content -->
            <div class="p-4 md:p-6 lg:p-8">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="py-4 px-6 text-center text-sm text-gray-500 border-t border-gray-200">
                © {{ date('Y') }} University Student Information System
            </footer>
        </main>
    </div>

    @yield('scripts')
</body>
</html> 