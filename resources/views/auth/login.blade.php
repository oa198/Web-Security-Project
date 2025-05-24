@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel - Login Form -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Welcome back!</h1>
                <p class="text-gray-600 mt-2">Sign in to access your account</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ $errors->first() }}
                            </h3>
                        </div>
                    </div>
                </div>
                @endif
                
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        required
                        autofocus
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Enter your password"
                            required
                        />
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 password-toggle"
                            onclick="togglePassword()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-off-icon h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                        />
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:underline">
                        Forgot Password?
                    </a>
                    @endif
                </div>
                
                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-purple-600 text-white font-medium rounded-lg py-2 px-4 hover:bg-purple-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                >
                    <span class="flex items-center justify-center h-10">
                        Sign in
                    </span>
                </button>
            </form>
            
            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <div class="px-4 text-sm text-gray-500">or sign in with</div>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>
            
            <!-- Social Login Buttons -->
            <div class="space-y-3">
                <a
                    href="{{ route('google.login') }}"
                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                    <img
                        src="https://raw.githubusercontent.com/devicons/devicon/master/icons/google/google-original.svg"
                        alt="Google"
                        class="w-5 h-5 mr-2"
                    />
                    Continue with Google
                </a>
                <a
                    href="{{ route('github.login') }}"
                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                    <img
                        src="https://raw.githubusercontent.com/devicons/devicon/master/icons/github/github-original.svg"
                        alt="GitHub"
                        class="w-5 h-5 mr-2"
                    />
                    Continue with GitHub
                </a>

                <a
                    href="{{ route('linkedin.login') }}"
                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                    <img
                        src="https://raw.githubusercontent.com/devicons/devicon/master/icons/linkedin/linkedin-original.svg"
                        alt="LinkedIn"
                        class="w-5 h-5 mr-2"
                    />
                    Continue with LinkedIn
                </a>
            </div>
            
            <!-- Sign Up -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-purple-600 font-medium hover:underline">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Right Panel - Welcome Banner -->
    <div class="hidden md:flex md:flex-1 bg-purple-600 text-white p-8 items-center justify-center">
        <div class="max-w-md">
            <h1 class="text-4xl font-bold mb-4">
                Welcome to Student Portal
            </h1>
            <p class="text-purple-100 text-lg mb-8">
                Login to access your account and student resources
            </p>
            
            <img 
                src="https://sut.edu.eg/wp-content/uploads/2024/07/2-2.png" 
                alt="Students working on laptops" 
                class="rounded-lg shadow-xl"
            />
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.querySelector('.eye-icon');
        const eyeOffIcon = document.querySelector('.eye-off-icon');
        
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
@endpush
@endsection