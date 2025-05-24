<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Verify Your Email</h1>
        
        <p class="text-center mb-6">We sent a code to: <strong>{{ Auth::user()->email }}</strong></p>
        
        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('status') }}</div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        
        @error('otp')
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $message }}</div>
        @enderror
        
        <form action="/verify-otp" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="otp" class="block mb-2">Enter 6-digit code:</label>
                <input 
                    type="text" 
                    id="otp" 
                    name="otp" 
                    class="w-full p-3 border border-gray-300 rounded text-center text-xl tracking-widest" 
                    maxlength="6"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    required
                    autofocus
                >
            </div>
            
            <input type="submit" value="Verify Email" class="w-full cursor-pointer bg-purple-600 text-white p-3 rounded hover:bg-purple-700">
        </form>
        
        <div class="mt-6 flex justify-between">
            <span>Code expires in 10 min</span>
            
            <form action="/resend-otp" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="text-purple-600">Resend Code</button>
            </form>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800">Back to Login</a>
        </div>
    </div>
</body>
</html>
