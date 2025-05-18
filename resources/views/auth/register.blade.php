<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        :root {
            --primary-color: #925fe2;
            --primary-dark: #7f49d3;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        .focus-ring {
            @apply focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Panel - Registration Form -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-md py-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
                    <p class="text-gray-600 mt-2">Join our student community today</p>
                </div>
                
                @if($errors->any())
                <div class="bg-red-50 text-red-500 px-4 py-3 rounded-lg mb-6">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-ring"
                                placeholder="Enter your full name"
                                required
                            />
                        </div>
                        
                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email address
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-ring"
                                placeholder="Enter your email"
                                required
                            />
                        </div>
                        
                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-ring"
                                    placeholder="Create a password"
                                    required
                                />
                                <button
                                    type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 toggle-password"
                                    onclick="togglePasswordVisibility('password', 'eyeIcon', 'eyeOffIcon')"
                                >
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
                        </div>
                        
                        <!-- Confirm Password Input -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-ring"
                                    placeholder="Confirm your password"
                                    required
                                />
                                <button
                                    type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 toggle-password"
                                    onclick="togglePasswordVisibility('password_confirmation', 'eyeIconConfirm', 'eyeOffIconConfirm')"
                                >
                                    <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg id="eyeOffIconConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- CAPTCHA -->
                        <div class="my-4">
                            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"></div>
                        </div>
                        
                        <!-- Register Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                        >
                            Create Account
                        </button>
                    </div>
                </form>
                
                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <div class="px-4 text-sm text-gray-500">or sign up with</div>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
                <!-- Social Login Buttons -->
                <div class="flex space-x-3">
                    <a href="{{ route('google.login') }}" class="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </a>
                    <a href="{{ route('github.login') }}" class="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('linkedin.login') }}" class="flex-1 flex justify-center items-center py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z" />
                        </svg>
                    </a>
                </div>
                
                <!-- Sign In -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-purple-600 font-medium hover:underline">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Welcome Banner -->
        <div class="hidden md:flex md:flex-1 bg-purple-600 text-white p-8 items-center justify-center">
            <div class="max-w-md">
                <h1 class="text-4xl font-bold mb-4">
                    Join our Student Community
                </h1>
                <p class="text-purple-100 text-lg mb-8">
                    Create an account to access courses, assignments, grades and more
                </p>
                
                <!-- Illustration -->
                <div class="flex justify-center">
                    <img 
                        src="https://images.pexels.com/photos/8617878/pexels-photo-8617878.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" 
                        alt="Students in a classroom" 
                        class="max-w-full h-auto rounded-lg"
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, eyeIconId, eyeOffIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const eyeOffIcon = document.getElementById(eyeOffIconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html> 