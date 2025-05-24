@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row">
    <!-- Left Panel - Registration Form -->
    <div class="flex-1 flex items-center justify-center p-4 sm:p-6 md:p-8">
        <div class="w-full max-w-2xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Create an Account</h1>
                <p class="text-gray-600 mt-2">Join our student community</p>
            </div>
            
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @if($errors->has('password'))
                <div class="mt-2 text-sm text-red-700 font-medium">
                    <p><strong>Note:</strong> Password fields are empty for security reasons. Please enter your password again.</p>
                </div>
                @endif
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6" id="registerForm">
                @csrf
                
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name
                        </label>
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('first_name') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name
                        </label>
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('last_name') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Email and National ID -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="national_id" class="block text-sm font-medium text-gray-700">
                            National ID Number
                        </label>
                        <input
                            type="text"
                            id="national_id"
                            name="national_id"
                            value="{{ old('national_id') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('national_id') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('national_id')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Address Fields -->
                <div>
                    <label for="street" class="block text-sm font-medium text-gray-700">
                        Street Address
                    </label>
                    <input
                        type="text"
                        id="street"
                        name="street"
                        value="{{ old('street') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('street') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        required
                    />
                    @error('street')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City
                        </label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('city') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('city')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">
                            State
                        </label>
                        <input
                            type="text"
                            id="state"
                            name="state"
                            value="{{ old('state') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('state') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('state')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700">
                            ZIP Code
                        </label>
                        <input
                            type="text"
                            id="zip_code"
                            name="zip_code"
                            value="{{ old('zip_code') }}"
                            class="mt-1 block w-full px-3 py-2 border @error('zip_code') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required
                        />
                        @error('zip_code')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="mt-1 block w-full px-3 py-2 border @error('password') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                required
                            />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Password must have at least 8 characters, including uppercase, lowercase, number, and special character.</p>

                        @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                        
                        <!-- Password validation removed as requested -->
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm Password
                        </label>
                        <div>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="mt-1 block w-full px-3 py-2 border @error('password_confirmation') border-red-300 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                required
                            />
                        </div>
                        @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Terms and Privacy Policy -->
                <div class="space-y-4">
                    <div class="flex items-start">
                        <input
                            type="checkbox"
                            id="terms"
                            name="terms"
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            {{ old('terms') ? 'checked' : '' }}
                            required
                        />
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the 
                            <a href="#" class="text-purple-600 hover:underline">
                                Terms of Service
                            </a>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input
                            type="checkbox"
                            id="privacy"
                            name="privacy"
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            {{ old('privacy') ? 'checked' : '' }}
                            required
                        />
                        <label for="privacy" class="ml-2 block text-sm text-gray-700">
                            I agree to the 
                            <a href="#" class="text-purple-600 hover:underline">
                                Privacy Policy
                            </a>
                        </label>
                    </div>

                    @error('terms')
                    <p class="text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
    
                <!-- CAPTCHA removed as requested -->

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-purple-600 text-white font-medium rounded-lg py-2 px-4 hover:bg-purple-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                >
                    <span class="flex items-center justify-center h-10">
                        Create Account
                    </span>
                </button>

                <!-- Login Link -->
                <p class="text-center text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-purple-600 hover:underline font-medium">
                        Sign in
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Right Panel - Welcome Banner -->
    <div class="hidden lg:flex lg:flex-1 bg-purple-600 text-white p-8 items-center justify-center">
        <div class="max-w-md">
            <h1 class="text-4xl font-bold mb-4">
                Welcome to Student Portal
            </h1>
            <p class="text-purple-100 text-lg mb-8">
                Create your account to access student resources and manage your academic journey
            </p>
            
            <img 
                src="https://images.pexels.com/photos/8199562/pexels-photo-8199562.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" 
                alt="Students studying" 
                class="rounded-lg shadow-xl"
            />
        </div>
    </div>
</div>

@push('scripts')
<!-- Scripts section -->
@endpush
@endsection