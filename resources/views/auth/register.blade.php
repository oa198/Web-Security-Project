<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        :root {
            /* Light mode colors */
            --bg-color: #f6f6f6;
            --text-color: #333;
            --card-bg: white;
            --form-bg: white;
            --input-bg: #f0f0f0;
            --primary-color: #925fe2;
            --primary-dark: #7f49d3;
            --toggle-bg: #f0f0f0;
            --toggle-button: #925fe2;
            /* New variables */
            --black: rgba(0, 0, 0, 1);
            --darkpurple: rgba(120, 72, 199, 1);
            --descedent: rgba(32, 32, 32, 1);
            --purple: rgba(146, 95, 226, 1);
        }
        
        [data-theme="dark"] {
            /* Dark mode colors */
            --bg-color: #1c1d21;
            --text-color: white;
            --card-bg: #1c1d21;
            --form-bg: #1c1d21;
            --input-bg: #2a2a2a;
            --primary-color: #925fe2;
            --primary-dark: #7f49d3;
            --toggle-bg: #2a2a2a;
            --toggle-button: #925fe2;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .container {
            background-color: var(--purple);
            display: flex;
            flex-row: row;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
        }
        
        .register-wrapper {
            background-color: var(--purple);
            width: 1440px;
            height: 1024px;
            position: relative;
        }
        
        .content-container {
            position: relative;
            height: 1024px;
        }
        
        /* Vector images */
        .vector-2 {
            position: absolute;
            width: 402px;
            height: 342px;
            top: 0;
            left: 1038px;
            animation: floatAnimation 4s ease-in-out infinite;
        }
        
        .vector-3 {
            position: absolute;
            width: 763px;
            height: 616px;
            top: 408px;
            left: 677px;
            animation: floatAnimation 4s ease-in-out infinite;
            animation-delay: 0.5s;
        }
        
        .vector-4 {
            position: absolute;
            width: 421px;
            height: 389px;
            top: 245px;
            left: 459px;
            animation: floatAnimation 4s ease-in-out infinite;
            animation-delay: 1s;
        }
        
        .vector-5 {
            position: absolute;
            width: 177px;
            height: 200px;
            top: 175px;
            left: 1263px;
            animation: floatAnimation 4s ease-in-out infinite;
            animation-delay: 1.5s;
        }
        
        .vector {
            position: absolute;
            width: 297px;
            height: 221px;
            top: 0;
            left: 868px;
            animation: floatAnimation 4s ease-in-out infinite;
            animation-delay: 2s;
        }
        
        .image-decoration {
            position: absolute;
            width: 297px;
            height: 273px;
            top: 671px;
            left: 664px;
            animation: floatAnimation 4s ease-in-out infinite;
            animation-delay: 1s;
        }
        
        /* Left panel */
        .left-panel {
            position: absolute;
            width: 630px;
            height: 1024px;
            top: 0;
            left: 0;
            background-color: #1c1d21;
            border-radius: 24px 0 0 24px;
            overflow: hidden;
        }
        
        /* Register form */
        .register-form-container {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 40px;
            position: absolute;
            top: 200px;
            left: 128px;
            z-index: 2;
        }
        
        .form-content {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            position: relative;
        }
        
        .form-header {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            position: relative;
        }
        
        .form-title {
            font-weight: 700;
            font-size: 48px;
            position: relative;
            width: fit-content;
            margin-top: -1px;
            color: white;
            letter-spacing: 0;
        }
        
        .form-subtitle {
            position: relative;
            width: fit-content;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            letter-spacing: 0;
        }
        
        .form-fields {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            position: relative;
        }
        
        .field-container {
            flex-direction: column;
            width: 381px;
            align-items: flex-start;
            gap: 12px;
            position: relative;
            display: flex;
        }
        
        .field-label {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            letter-spacing: 0;
        }
        
        .field-input {
            width: 381px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            padding-bottom: 8px;
            color: white;
            font-size: 16px;
            outline: none;
        }
        
        .password-field-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .toggle-password {
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .eye-icon {
            width: 24px;
            height: 24px;
        }
        
        .register-button {
            display: flex;
            width: 393px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 0;
            background-color: #9c6fe4;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            margin-top: 16px;
        }
        
        .button-text {
            font-weight: 400;
            font-size: 16px;
            color: white;
            text-align: center;
        }
        
        /* Welcome section */
        .welcome-container {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            position: absolute;
            top: 155px;
            left: 730px;
            z-index: 2;
        }
        
        .welcome-title {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: 400;
            color: #eeeeee;
            font-size: 80px;
            letter-spacing: 0;
            line-height: 70px;
        }
        
        .welcome-bold {
            font-weight: 700;
        }
        
        .welcome-regular {
            font-weight: 400;
        }
        
        .welcome-subtitle {
            position: relative;
            width: fit-content;
            font-weight: 500;
            color: #eeeeee;
            font-size: 16px;
            letter-spacing: 0;
        }
        
        /* Login section */
        .login-container {
            display: inline-flex;
            align-items: center;
            gap: 67px;
            position: absolute;
            top: 872px;
            left: 128px;
            z-index: 2;
        }
        
        .login-text {
            position: relative;
            width: fit-content;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            letter-spacing: 0;
        }
        
        .login-button {
            display: flex;
            width: 100px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            background-color: #333437;
            border-radius: 8px;
            text-decoration: none;
        }
        
        .login-button-text {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            margin-left: -4px;
            margin-right: -4px;
            font-weight: 400;
            color: white;
            font-size: 16px;
            letter-spacing: 0;
        }
        
        /* Social login section */
        .social-section {
            position: absolute;
            left: 128px;
            top: 730px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .social-line {
            width: 393px;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .social-buttons {
            display: flex;
            gap: 32px;
        }
        
        .social-button {
            width: 77px;
            height: 60px;
            background-color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .social-icon {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        
        .signin-text {
            font-weight: 400;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            position: absolute;
            top: -24px;
            left: 152px;
        }
        
        /* Element copy */
        .element-copy {
            position: absolute;
            width: 767px;
            height: 628px;
            top: 368px;
            left: 673px;
            object-fit: cover;
            z-index: 1;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 4px;
        }
        
        /* Captcha overlay styles */
        .captcha-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }
        
        .captcha-container {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 450px;
            width: 90%;
        }
        
        .captcha-title {
            margin-bottom: 20px;
            color: var(--text-color);
            font-size: 18px;
            font-weight: 500;
            text-align: center;
        }
        
        /* Animations */
        @keyframes floatAnimation {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 1440px) {
            .register-wrapper {
                width: 100%;
                height: auto;
                min-height: 100vh;
            }
            
            .content-container {
                height: auto;
                min-height: 100vh;
            }
            
            .left-panel {
                width: 50%;
            }
            
            .welcome-container {
                left: 55%;
            }
            
            .element-copy {
                width: 50%;
                left: 50%;
            }
        }
        
        @media (max-width: 992px) {
            .left-panel {
                width: 100%;
                border-radius: 24px;
            }
            
            .welcome-container,
            .element-copy,
            .vector-2,
            .vector-3,
            .vector-4,
            .vector-5,
            .vector,
            .image-decoration {
                display: none;
            }
            
            .register-form-container {
                position: relative;
                top: 100px;
                left: 0;
                width: 100%;
                padding: 0 20px;
                align-items: center;
            }
            
            .login-container {
                position: relative;
                top: auto;
                left: 0;
                width: 100%;
                padding: 20px;
                margin-top: 40px;
                justify-content: center;
            }
            
            .social-section {
                position: relative;
                top: auto;
                left: 0;
                width: 100%;
                padding: 20px;
                margin-top: 20px;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-wrapper">
            <div class="content-container">
                <!-- Vector decorations -->
                <img class="vector-2" alt="Vector" src="{{ asset('images/vector-2.svg') }}">
                <img class="vector-3" alt="Vector" src="{{ asset('images/vector-3.svg') }}">
                <img class="vector-4" alt="Vector" src="{{ asset('images/vector-4.svg') }}">
                <img class="vector-5" alt="Vector" src="{{ asset('images/vector-5.svg') }}">
                <img class="vector" alt="Vector" src="{{ asset('images/vector.svg') }}">
                <img class="image-decoration" alt="Vector" src="{{ asset('images/image.svg') }}">
                
                <!-- Left panel -->
                <div class="left-panel"></div>
                
                <!-- Register form -->
                <div class="register-form-container">
                    <form method="POST" action="{{ route('register.post') }}" id="register-form" onsubmit="return checkFormSubmission(event);">
                        @csrf
                        @if (session('google_email_conflict'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{ session('google_email_conflict') }}</li>
                                </ul>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-content">
                            <div class="form-header">
                                <div class="form-title">Register</div>
                                <div class="form-subtitle">Create your account</div>
                            </div>

                            <div class="form-fields">
                                <div class="field-container">
                                    <label for="name" class="field-label">Full Name</label>
                                    <input type="text" id="name" name="name" class="field-input" value="{{ old('name') }}" required onclick="event.stopPropagation();">
                                    @error('name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="field-container">
                                    <label for="email" class="field-label">Email</label>
                                    <input type="email" id="email" name="email" class="field-input" value="{{ old('email') }}" required onclick="event.stopPropagation();">
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="field-container">
                                    <div class="password-field-header">
                                        <label for="password" class="field-label">Password</label>
                                        <button type="button" id="togglePassword" class="toggle-password" aria-label="Toggle password visibility" onclick="event.preventDefault(); event.stopPropagation();">
                                            <img class="eye-icon" alt="Toggle password visibility" src="{{ asset('images/eye-slash-fill.svg') }}">
                                        </button>
                                    </div>
                                    <input type="password" id="password" name="password" class="field-input" required onclick="event.stopPropagation();">
                                    @error('password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="field-container">
                                    <div class="password-field-header">
                                        <label for="password_confirmation" class="field-label">Confirm Password</label>
                                        <button type="button" id="toggleConfirmPassword" class="toggle-password" aria-label="Toggle confirm password visibility" onclick="event.preventDefault(); event.stopPropagation();">
                                            <img class="eye-icon" alt="Toggle confirm password visibility" src="{{ asset('images/eye-slash-fill.svg') }}">
                                        </button>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="field-input" required onclick="event.stopPropagation();">
                                </div>
                                
                                <!-- Hidden Turnstile token field -->
                                <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">
                                @error('captcha')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <button type="button" id="pre-submit-button" class="register-button" onclick="event.preventDefault(); showCaptcha();">
                                <div class="button-text">Register</div>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Welcome section -->
                <div class="welcome-container">
                    <p class="welcome-title">
                        <span class="welcome-bold">Welcome to <br></span>
                        <span class="welcome-regular">Student Portal</span>
                    </p>
                    <p class="welcome-subtitle">Create an account to get started</p>
                </div>
                
                <!-- Social login section -->
                <div class="social-section">
                    <div class="social-line"></div>
                    <div class="signin-text">sign-up with</div>
                    <div class="social-buttons">
                        <a href="{{ route('google.login') }}" class="social-button">
                            <img class="social-icon" alt="Google" src="{{ asset('images/Social/google.png') }}">
                        </a>
                        <a href="{{ route('github.login') }}" class="social-button">
                            <img class="social-icon" alt="GitHub" src="{{ asset('images/Social/github.png') }}">
                        </a>
                        <a href="{{ route('linkedin.login') }}" class="social-button">
                            <img class="social-icon" alt="LinkedIn" src="{{ asset('images/Social/linkedin.png') }}">
                        </a>
                    </div>
                </div>
                
                <!-- Login section -->
                <div class="login-container">
                    <div class="login-text">Already have an account?</div>
                    <a href="{{ route('login') }}" class="login-button">
                        <div class="login-button-text">Login</div>
                    </a>
                </div>
                
                <!-- Element copy -->
                <img class="element-copy" alt="Element copy" src="{{ asset('images/1100924-01-copy-1.png') }}">
            </div>
        </div>
    </div>

    <!-- Captcha Overlay -->
    <div class="captcha-overlay" id="captcha-overlay">
        <div class="captcha-container">
            <div class="captcha-title">Please verify you're human</div>
            <div class="cf-turnstile" id="cf-turnstile-widget" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-callback="turnstileCallback" data-theme="dark"></div>
        </div>
    </div>

    <script>
        // Flag to prevent multiple form submissions
        let isSubmitting = false;
        
        // Function to show the captcha overlay
        function showCaptcha() {
            document.getElementById('captcha-overlay').style.display = 'flex';
            
            // Ensure the Turnstile widget is reset if it was previously loaded
            if (typeof turnstile !== 'undefined') {
                turnstile.reset();
            }
        }
        
        // Check if form should be submitted
        function checkFormSubmission(event) {
            // If already submitting or captcha verified, allow submission
            if (isSubmitting || sessionStorage.getItem('captcha_verified') === 'true') {
                // Clear the verification flag
                sessionStorage.removeItem('captcha_verified');
                return true;
            }
            
            // Otherwise prevent default form submission and show captcha
            event.preventDefault();
            showCaptcha();
            return false;
        }
        
        // Cloudflare Turnstile callback
        function turnstileCallback(token) {
            console.log('Turnstile callback received token:', token);
            document.getElementById('cf-turnstile-response').value = token;
            
            // Set a flag in session storage to indicate verification was completed
            sessionStorage.setItem('captcha_verified', 'true');
            isSubmitting = true;
            
            // Hide overlay after verification
            document.getElementById('captcha-overlay').style.display = 'none';
            
            // Submit the form automatically after verification
            document.getElementById('register-form').submit();
        }

        // Prevent any accidental form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Disable the default behavior of Enter key in inputs
            const allInputs = document.querySelectorAll('input');
            allInputs.forEach(function(input) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        return false;
                    }
                });
                
                // Explicitly stop propagation on the click event
                input.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
            
            // Add a capture phase click handler to the form to prevent clicks from reaching the form
            document.getElementById('register-form').addEventListener('click', function(e) {
                // Only stop if this is the form itself being clicked, not a child element
                if (e.target === this) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        });

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Change the eye icon based on password visibility
            const eyeIcon = this.querySelector('img');
            if (type === 'text') {
                eyeIcon.src = "{{ asset('images/eye-fill.svg') }}";
            } else {
                eyeIcon.src = "{{ asset('images/eye-slash-fill.svg') }}";
            }
        });

        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const passwordInput = document.getElementById('password_confirmation');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Change the eye icon based on password visibility
            const eyeIcon = this.querySelector('img');
            if (type === 'text') {
                eyeIcon.src = "{{ asset('images/eye-fill.svg') }}";
            } else {
                eyeIcon.src = "{{ asset('images/eye-slash-fill.svg') }}";
            }
        });
    </script>
</body>
</html> 