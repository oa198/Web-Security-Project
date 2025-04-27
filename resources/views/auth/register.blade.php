<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
    <style>
        :root {
            /* Light mode colors */
            --bg-color: #f5f5f9;
            --panel-bg: #ffffff;
            --text-color: #1c1d21;
            --text-secondary: rgba(28, 29, 33, 0.7);
            --text-muted: rgba(28, 29, 33, 0.5);
            --primary-color: #9c6fe4;
            --primary-hover: #8055d0;
            --button-secondary: #e2e2e2;
            --button-secondary-hover: #d1d1d1;
            --separator-color: rgba(28, 29, 33, 0.2);
            --error-color: #ef4444;
            --success-color: #22c55e;
            --social-button-bg: #9c6fe4;
            --social-button-border: rgba(156, 111, 228, 0.2);
            --social-button-shadow: rgba(156, 111, 228, 0.2);
            --eye-icon-filter: invert(42%) sepia(47%) saturate(804%) hue-rotate(223deg) brightness(93%) contrast(91%);
            --captcha-bg: #ffffff;
            --captcha-border: #e2e2e2;
        }
        
        .dark {
            /* Dark mode colors */
            --bg-color: #925fe2;
            --panel-bg: #1c1d21;
            --text-color: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            --primary-color: #9c6fe4;
            --primary-hover: #8055d0;
            --button-secondary: #333437;
            --button-secondary-hover: #444548;
            --separator-color: rgba(255, 255, 255, 0.2);
            --error-color: #ef4444;
            --success-color: #22c55e;
            --social-button-bg: #ffffff;
            --social-button-border: rgba(0, 0, 0, 0.05);
            --social-button-shadow: rgba(0, 0, 0, 0.1);
            --captcha-bg: #1c1d21;
            --captcha-border: #9c6fe4;
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
            background-color: var(--bg-color);
            height: 100vh;
            width: 100vw;
            transition: background-color 0.3s ease;
        }
        
        .container {
            display: flex;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
        }
        
        .register-wrapper {
            width: 100%;
            max-width: 1440px;
            height: 100vh;
            position: relative;
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }
        
        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--panel-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
            color: var(--text-color);
            transition: background-color 0.3s ease;
        }
        
        .theme-toggle svg {
            width: 20px;
            height: 20px;
            fill: var(--text-color);
        }
        
        .left-panel {
            position: relative;
            width: 50%;
            max-width: 630px;
            height: 100%;
            background-color: var(--panel-bg);
            border-radius: 0 24px 24px 0;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        
        .register-form {
            position: absolute;
            top: 230px;
            left: 128px;
            display: flex;
            flex-direction: column;
            gap: 36px;
        }
        
        .form-header {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .form-title {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .title-text {
            font-weight: 700;
            font-size: 48px;
            color: var(--text-color);
            transition: color 0.3s ease;
        }
        
        .subtitle-text {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .form-fields {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 24px;
        }
        
        .field-container {
            display: flex;
            flex-direction: column;
            width: 381px;
            gap: 8px;
        }
        
        .field-label {
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .field-input-container {
            position: relative;
        }
        
        .field-input {
            width: 381px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid var(--text-muted);
            padding-bottom: 8px;
            color: var(--text-color);
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease, color 0.3s ease;
        }
        
        .field-header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: center;
        }
        
        .toggle-password {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }
        
        .eye-icon {
            width: 24px;
            height: 24px;
            fill: var(--text-muted);
            filter: var(--eye-icon-filter);
        }
        
        .register-button {
            display: flex;
            width: 393px;
            align-items: center;
            justify-content: center;
            padding: 12px 0;
            background-color: var(--primary-color);
            border-radius: 12px;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        
        .register-button:hover {
            background-color: var(--primary-hover);
        }
        
        .welcome-container {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 600px;
            margin-bottom: 50px;
        }
        
        .right-panel {
            position: relative;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 50px;
        }
        
        .welcome-title {
            font-size: 80px;
            line-height: 1.1;
            color: var(--text-color);
            transition: color 0.3s ease;
        }
        
        .welcome-bold {
            font-weight: 700;
        }
        
        .welcome-regular {
            font-weight: 400;
        }
        
        .welcome-subtitle {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .login-container {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 24px;
            bottom: 48px;
            left: 128px;
        }
        
        .login-text {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background-color: var(--button-secondary);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-color);
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .login-button:hover {
            background-color: var(--button-secondary-hover);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 14px;
            margin-top: 4px;
            display: block;
        }
        
        .illustration {
            width: 100%;
            max-width: 767px;
            height: auto;
            object-fit: contain;
        }
        
        /* Captcha overlay */
        #captcha-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.75);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            backdrop-filter: blur(3px);
        }
        
        .captcha-modal {
            background-color: var(--captcha-bg);
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 28rem;
            width: 100%;
            border: 1px solid var(--captcha-border);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        .captcha-title {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: 1.25rem;
            color: var(--text-color);
            transition: color 0.3s ease;
        }
        
        .captcha-container {
            margin-bottom: 1.5rem;
        }
        
        .captcha-buttons {
            display: flex;
            justify-content: flex-end;
        }
        
        .cancel-button {
            padding: 0.5rem 1rem;
            background-color: var(--button-secondary);
            color: var(--text-color);
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .cancel-button:hover {
            background-color: var(--button-secondary-hover);
        }
        
        .alert {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: var(--text-color);
            font-size: 14px;
            width: 381px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.2);
            border-left: 4px solid var(--error-color);
        }
        
        .alert-success {
            background-color: rgba(34, 197, 94, 0.2);
            border-left: 4px solid var(--success-color);
        }
        
        .alert ul {
            margin-left: 20px;
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .register-form {
                left: 80px;
            }
            
            .login-container {
                left: 80px;
            }
            
            .social-buttons-container {
                left: 80px;
            }
            
            .welcome-title {
                font-size: 60px;
            }
        }
        
        @media (max-width: 992px) {
            .register-wrapper {
                flex-direction: column;
                height: auto;
            }
            
            .left-panel {
                width: 100%;
                max-width: 100%;
                height: auto;
                min-height: 100vh;
                border-radius: 0;
                padding: 40px 0;
            }
            
            .register-form {
                position: relative;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                width: 80%;
                max-width: 450px;
            }
            
            .field-container,
            .field-input,
            .register-button,
            .alert {
                width: 100%;
            }
            
            .social-buttons-container {
                position: relative;
                left: 50%;
                bottom: auto;
                transform: translateX(-50%);
                margin-top: 40px;
                margin-bottom: 40px;
                align-items: center;
            }
            
            .separator {
                width: 300px;
            }
            
            .login-container {
                position: relative;
                bottom: auto;
                left: 50%;
                transform: translateX(-50%);
                margin-top: 0;
                margin-bottom: 40px;
            }
            
            .right-panel {
                width: 100%;
                padding: 50px 20px;
                order: -1;
            }
            
            .welcome-container {
                align-items: center;
                text-align: center;
                margin-bottom: 30px;
            }
            
            .illustration {
                max-width: 90%;
                margin-bottom: 30px;
            }
        }
        
        @media (max-width: 576px) {
            .register-form {
                width: 90%;
            }
            
            .welcome-title {
                font-size: 40px;
            }
            
            .social-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .login-container {
                flex-direction: column;
                gap: 16px;
            }
        }
        
        .social-buttons-container {
            position: absolute;
            left: 128px;
            bottom: 128px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .signin-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 12px;
            transition: color 0.3s ease;
        }
        
        .separator {
            width: 100%;
            height: 1px;
            background-color: var(--separator-color);
            margin-bottom: 12px;
            transition: background-color 0.3s ease;
        }
        
        .social-buttons {
            display: flex;
            gap: 16px;
        }
        
        .social-button {
            width: 77px;
            height: 60px;
            background-color: var(--social-button-bg);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
            box-shadow: 0 2px 8px var(--social-button-shadow);
            border: 1px solid var(--social-button-border);
        }
        
        .social-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .social-icon {
            width: auto;
            height: auto;
            max-width: 40px;
            max-height: 40px;
            filter: var(--social-icon-filter);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-wrapper">
            <!-- Theme toggle button -->
            <button class="theme-toggle" id="theme-toggle" title="Toggle dark/light mode">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="theme-icon sun-icon">
                    <path d="M12 3V2m0 20v-1m9-9h1M2 12h1m15.5-6.5L20 4M4 20l1.5-1.5M4 4l1.5 1.5m13 13L20 20M12 5a7 7 0 100 14 7 7 0 000-14z" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="theme-icon moon-icon" style="display: none;">
                    <path d="M12 3a9 9 0 109 9 9.75 9.75 0 01-9-9z" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
            </button>

            <div class="left-panel">
                <div class="register-form">
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
                    
                    <div class="form-header">
                            <div class="form-title">
                                <div class="title-text">Register</div>
                                <div class="subtitle-text">Create your account</div>
                            </div>
                            
                        <form id="registration-form" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="form-fields">
                                <div class="field-container">
                                    <div class="field-label">Full Name</div>
                                    <div class="field-input-container">
                                        <input type="text" id="name" name="name" class="field-input" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="field-container">
                                    <div class="field-label">Email</div>
                                    <div class="field-input-container">
                                        <input type="email" id="email" name="email" class="field-input" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="field-container">
                                    <div class="field-header">
                                        <div class="field-label">Password</div>
                                        <button type="button" id="togglePassword" class="toggle-password">
                                            <img src="{{ asset('images/eye-slash-fill.svg') }}" alt="Toggle password" class="eye-icon">
                                        </button>
                                    </div>
                                    <div class="field-input-container">
                                        <input type="password" id="password" name="password" class="field-input" required>
                                    </div>
                                    @error('password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                    <span id="password-error" class="error-message" style="display: none;"></span>
                                </div>
                                
                                <div class="field-container">
                                    <div class="field-header">
                                        <div class="field-label">Confirm Password</div>
                                        <button type="button" id="toggleConfirmPassword" class="toggle-password">
                                            <img src="{{ asset('images/eye-slash-fill.svg') }}" alt="Toggle confirm password" class="eye-icon">
                                        </button>
                                    </div>
                                    <div class="field-input-container">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="field-input" required>
                                    </div>
                                </div>
                                
                                <!-- Hidden Turnstile token field -->
                                <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">
                                @error('captcha')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                        </div>
                        
                            <button type="button" id="pre-submit-button" class="register-button">Register</button>
                    </form>
                    </div>
                </div>
                
                <!-- Social login -->
                <div class="social-buttons-container">
                    <div class="signin-text">sign-in with</div>
                    <div class="separator"></div>
                    <div class="social-buttons">
                        <div class="social-button">
                            <object data="{{ asset('images/google.svg') }}" type="image/svg+xml" width="40" height="40" class="social-icon"></object>
                        </div>
                        <div class="social-button">
                            <object data="{{ asset('images/Github.svg') }}" type="image/svg+xml" width="40" height="40" class="social-icon"></object>
                        </div>
                        <div class="social-button">
                            <object data="{{ asset('images/LinkedIn.svg') }}" type="image/svg+xml" width="40" height="40" class="social-icon"></object>
                        </div>
                    </div>
                </div>
                
                <div class="login-container">
                    <div class="login-text">Already have an account?</div>
                    <a href="{{ route('login') }}" class="login-button">Login</a>
                </div>
            </div>
            
            <div class="right-panel">
                <div class="welcome-container">
                    <p class="welcome-title">
                        <span class="welcome-bold">Welcome to <br></span>
                        <span class="welcome-regular">student portal</span>
                    </p>
                    <p class="welcome-subtitle">Create an account to get started</p>
                </div>
                
                <img class="illustration" src="{{ asset('images/boyss.png') }}" alt="Students illustration">
            </div>
        </div>
                </div>
    
    <!-- Captcha Overlay -->
    <div id="captcha-overlay">
        <div class="captcha-modal">
            <h3 class="captcha-title">Verify you're human</h3>
            <div id="captcha-container" class="captcha-container"></div>
            <div class="captcha-buttons">
                <button type="button" id="close-captcha" class="cancel-button">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme toggle functionality
            const themeToggle = document.getElementById('theme-toggle');
            const htmlEl = document.documentElement;
            const sunIcon = document.querySelector('.sun-icon');
            const moonIcon = document.querySelector('.moon-icon');
            
            // Check for saved theme preference or use system preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                htmlEl.className = savedTheme;
                updateThemeIcon(savedTheme);
            } else {
                // Check system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                htmlEl.className = prefersDark ? 'dark' : '';
                updateThemeIcon(prefersDark ? 'dark' : '');
            }
            
            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    sunIcon.style.display = 'block';
                    moonIcon.style.display = 'none';
                } else {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'block';
                }
            }
            
            themeToggle.addEventListener('click', function() {
                if (htmlEl.classList.contains('dark')) {
                    htmlEl.classList.remove('dark');
                    localStorage.setItem('theme', '');
                    updateThemeIcon('');
                } else {
                    htmlEl.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    updateThemeIcon('dark');
                }
            });
            
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Change eye icon
            const eyeIcon = this.querySelector('img');
            if (type === 'text') {
                eyeIcon.src = "{{ asset('images/eye-fill.svg') }}";
            } else {
                eyeIcon.src = "{{ asset('images/eye-slash-fill.svg') }}";
            }
        });

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.setAttribute('type', type);
                
                // Change eye icon
            const eyeIcon = this.querySelector('img');
            if (type === 'text') {
                eyeIcon.src = "{{ asset('images/eye-fill.svg') }}";
            } else {
                eyeIcon.src = "{{ asset('images/eye-slash-fill.svg') }}";
            }
        });

            // Captcha setup
            let captchaWidgetId;
            const preSubmitButton = document.getElementById('pre-submit-button');
            const captchaOverlay = document.getElementById('captcha-overlay');
            const closeButton = document.getElementById('close-captcha');
            const registrationForm = document.getElementById('registration-form');
            
            // Function to render the captcha
            function renderCaptcha() {
                if (captchaWidgetId) {
                    turnstile.reset(captchaWidgetId);
                } else {
                    captchaWidgetId = turnstile.render('#captcha-container', {
                        sitekey: '{{ env('TURNSTILE_SITE_KEY') }}',
                        callback: function(token) {
                            document.getElementById('cf-turnstile-response').value = token;
                            captchaOverlay.style.display = 'none';
                            registrationForm.submit();
                        },
                        'theme': htmlEl.classList.contains('dark') ? 'dark' : 'light'
                    });
                }
            }
            
            // Show captcha overlay when submit button is clicked
            preSubmitButton.addEventListener('click', function() {
                // Validate password
                const password = passwordField.value;
                const passwordError = document.getElementById('password-error');
                
                if (password.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters';
                    passwordError.style.display = 'block';
                    return;
                }
                
                if (password !== confirmPasswordField.value) {
                    passwordError.textContent = 'Passwords do not match';
                    passwordError.style.display = 'block';
                    return;
                }
                
                passwordError.style.display = 'none';
                
                // Show captcha
                captchaOverlay.style.display = 'flex';
                renderCaptcha();
            });
            
            // Close captcha overlay when cancel button is clicked
            closeButton.addEventListener('click', function() {
                captchaOverlay.style.display = 'none';
            });
            
            // Update captcha theme when page theme changes
            themeToggle.addEventListener('click', function() {
                if (captchaWidgetId) {
                    setTimeout(() => {
                        turnstile.reset(captchaWidgetId);
                        renderCaptcha();
                    }, 100);
                }
            });
        });
    </script>
</body>
</html> 