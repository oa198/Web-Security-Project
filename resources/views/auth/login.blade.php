<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light mode colors */
            --bg-color: #f5f5f9;
            --panel-bg: #ffffff;
            --text-color: #1c1d21;
            --text-secondary: rgba(28, 29, 33, 0.7);
            --text-muted: rgba(28, 29, 33, 0.5);
            --primary-color: #985ce4;
            --primary-hover: #8055d0;
            --button-secondary: #e2e2e2;
            --button-secondary-hover: #d1d1d1;
            --separator-color: rgba(28, 29, 33, 0.2);
            --error-color: #ef4444;
            --success-color: #22c55e;
            --social-button-bg: #985ce4;
            --social-button-border: rgba(152, 92, 228, 0.2);
            --social-button-shadow: rgba(152, 92, 228, 0.2);
            --eye-icon-filter: invert(42%) sepia(67%) saturate(823%) hue-rotate(223deg) brightness(91%) contrast(91%);
        }
        
        .dark {
            /* Dark mode colors */
            --bg-color: #985ce4;
            --panel-bg: #1c1d21;
            --text-color: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            --primary-color: #985ce4;
            --primary-hover: #8055d0;
            --button-secondary: #333437;
            --button-secondary-hover: #444548;
            --separator-color: rgba(255, 255, 255, 0.2);
            --error-color: #ef4444;
            --success-color: #22c55e;
            --social-button-bg: #ffffff;
            --social-button-border: rgba(0, 0, 0, 0.05);
            --social-button-shadow: rgba(0, 0, 0, 0.1);
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
            flex-direction: row;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 1440px;
            height: 100vh;
            display: flex;
            flex-direction: row;
            position: relative;
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
        
        .social-buttons-container {
            position: absolute;
            left: 128px;
            top: 748px;
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
        
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 48px;
            position: absolute;
            top: 314px;
            left: 128px;
            width: 393px;
        }
        
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            width: 100%;
        }
        
        .form-inner {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            width: 100%;
        }
        
        .header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .title {
            font-weight: 700;
            font-size: 48px;
            color: var(--text-color);
            transition: color 0.3s ease;
        }
        
        .subtitle {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .fields {
            display: flex;
            flex-direction: column;
            gap: 24px;
            width: 100%;
        }
        
        .field {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 8px;
        }
        
        .field-label {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .field-input-container {
            position: relative;
            width: 100%;
        }
        
        .field-input-visible {
            background-color: transparent;
            border: none;
            border-bottom: 1px solid var(--text-muted);
            padding-bottom: 8px;
            outline: none;
            color: var(--text-color);
            width: 100%;
            font-size: 16px;
            transition: border-color 0.3s ease, color 0.3s ease;
        }
        
        .field-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .eye-toggle {
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
        
        .forgot-password {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 16px;
            text-decoration: none;
            margin-top: 16px;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .login-button {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            padding: 14px 0;
            background-color: var(--primary-color);
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .login-button:hover {
            background-color: var(--primary-hover);
        }
        
        .login-text {
            font-weight: 500;
            font-size: 16px;
            color: white;
        }
        
        .separator {
            width: 100%;
            height: 1px;
            background-color: var(--separator-color);
            margin: 12px 0;
            transition: background-color 0.3s ease;
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
        
        .welcome-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            max-width: 600px;
            margin-bottom: 50px;
        }
        
        .welcome-title {
            font-weight: 400;
            color: var(--text-color);
            font-size: 80px;
            line-height: 1.1;
            transition: color 0.3s ease;
        }
        
        .welcome-title .bold {
            font-weight: 700;
        }
        
        .welcome-subtitle {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .signup-container {
            display: flex;
            align-items: center;
            gap: 24px;
            position: absolute;
            bottom: 48px;
            left: 128px;
        }
        
        .signup-text {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .signup-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background-color: var(--button-secondary);
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        
        .signup-button:hover {
            background-color: var(--button-secondary-hover);
        }
        
        .signup-button-text {
            font-weight: 500;
            color: var(--text-color);
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .illustration {
            width: 100%;
            max-width: 767px;
            height: auto;
            object-fit: contain;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 14px;
            margin-top: 4px;
        }
        
        .alert {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: var(--text-color);
            font-size: 14px;
            width: 100%;
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
            .login-form {
                left: 80px;
                width: calc(100% - 160px);
            }
            
            .social-buttons-container {
                left: 80px;
            }
            
            .signup-container {
                left: 80px;
            }
            
            .welcome-title {
                font-size: 60px;
            }
        }
        
        @media (max-width: 992px) {
            .login-wrapper {
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
            
            .login-form {
                position: relative;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                width: 80%;
                max-width: 450px;
            }
            
            .social-buttons-container {
                position: relative;
                top: auto;
                left: 50%;
                transform: translateX(-50%);
                margin-top: 580px;
                align-items: center;
            }
            
            .signup-container {
                position: relative;
                bottom: auto;
                left: 50%;
                transform: translateX(-50%);
                margin-top: 40px;
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
            .login-form {
                width: 90%;
            }
            
            .welcome-title {
                font-size: 40px;
            }
            
            .social-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .signup-container {
                flex-direction: column;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-wrapper">
            <!-- Theme toggle button -->
            <button class="theme-toggle" id="theme-toggle" title="Toggle dark/light mode">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="theme-icon sun-icon">
                    <path d="M12 3V2m0 20v-1m9-9h1M2 12h1m15.5-6.5L20 4M4 20l1.5-1.5M4 4l1.5 1.5m13 13L20 20M12 5a7 7 0 100 14 7 7 0 000-14z" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="theme-icon moon-icon" style="display: none;">
                    <path d="M12 3a9 9 0 109 9 9.75 9.75 0 01-9-9z" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <!-- Left panel -->
            <div class="left-panel">
                <!-- Login form -->
                <div class="login-form">
                    <!-- Alerts -->
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

                    <div class="form-container">
                        <div class="form-inner">
                            <div class="header">
                                <div class="title">Login</div>
                                <div class="subtitle">Enter your account details</div>
                            </div>

                            <div class="fields">
                                <form method="POST" action="{{ route('login.post') }}" id="login-form">
                                    @csrf
                                    <div class="field">
                                        <div class="field-label">Username</div>
                                        <div class="field-input-container">
                                            <input type="text" name="email" class="field-input-visible" value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="field" style="margin-top: 16px;">
                                        <div class="field-header">
                                            <div class="field-label">Password</div>
                                            <button type="button" id="togglePassword" class="eye-toggle">
                                                <img class="eye-icon" src="{{ asset('images/eye-slash-fill.svg') }}" alt="Show/hide password" />
                                            </button>
                                        </div>
                                        <div class="field-input-container">
                                            <input type="password" id="password" name="password" class="field-input-visible" required>
                                        </div>
                                        @error('password')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <a href="{{ route('password.forgot') }}" class="forgot-password">Forgot Password?</a>

                                    <button type="submit" class="login-button" style="margin-top: 24px;">
                                        <span class="login-text">Login</span>
                                    </button>
                                </form>
                            </div>
                        </div>
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

                <!-- Signup container -->
                <div class="signup-container">
                    <div class="signup-text">Don't have an account?</div>
                    <a href="{{ route('register') }}" class="signup-button">
                        <span class="signup-button-text">Sign up</span>
                    </a>
                </div>
            </div>

            <!-- Right panel -->
            <div class="right-panel">
                <div class="welcome-container">
                    <h1 class="welcome-title">
                        <span class="bold">Welcome to </span><br>
                        <span>student portal</span>
                    </h1>
                    <p class="welcome-subtitle">Login to access your account</p>
                </div>
                <img class="illustration" src="{{ asset('images/boyss.png') }}" alt="Students illustration" onerror="this.src='{{ asset('images/1100924-01-copy-1.png') }}'; this.onerror='';">
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
            const passwordField = document.getElementById('password');
            
            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    
                    // Change eye icon
                    const eyeIcon = this.querySelector('img');
                    if (eyeIcon) {
                        if (type === 'text') {
                            eyeIcon.src = "{{ asset('images/eye-fill.svg') }}";
                        } else {
                            eyeIcon.src = "{{ asset('images/eye-slash-fill.svg') }}";
                        }
                    }
                });
            }
        });
    </script>
</body>
</html> 