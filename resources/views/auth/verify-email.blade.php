<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email - Student Portal</title>
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
        
        .verify-wrapper {
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
        
        .verify-form {
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
        
        .message {
            color: var(--text-secondary);
            font-size: 16px;
            line-height: 1.5;
            margin-top: 16px;
            margin-bottom: 24px;
            transition: color 0.3s ease;
        }
        
        .verify-button {
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
            margin-top: 16px;
        }
        
        .verify-button:hover {
            background-color: var(--primary-hover);
        }
        
        .button-text {
            font-weight: 500;
            font-size: 16px;
            color: white;
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
        
        .illustration {
            width: 100%;
            max-width: 767px;
            height: auto;
            object-fit: contain;
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
            .verify-form {
                left: 80px;
                width: calc(100% - 160px);
            }
            
            .welcome-title {
                font-size: 60px;
            }
        }
        
        @media (max-width: 992px) {
            .verify-wrapper {
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
            
            .verify-form {
                position: relative;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                width: 80%;
                max-width: 450px;
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
            .verify-form {
                width: 90%;
            }
            
            .welcome-title {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verify-wrapper">
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
                <!-- Verify form -->
                <div class="verify-form">
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
                                <div class="title">Verify Email</div>
                                <div class="subtitle">Confirm your email address</div>
                            </div>

                            <p class="message">
                                Thanks for signing up! Before getting started, please check your email for a verification link.
                                If you didn't receive the email, we will gladly send you another.
                            </p>

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="verify-button">
                                    <span class="button-text">Resend Verification Email</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right panel -->
            <div class="right-panel">
                <div class="welcome-container">
                    <h1 class="welcome-title">
                        <span class="bold">One more </span><br>
                        <span>step to go</span>
                    </h1>
                    <p class="welcome-subtitle">Verify your email to complete registration</p>
                </div>
                <img class="illustration" src="{{ asset('images/1100924-01-copy-1.png') }}" alt="Verification illustration" onerror="this.src='{{ asset('images/boyss.png') }}'; this.onerror='';">
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
        });
    </script>
</body>
</html>
