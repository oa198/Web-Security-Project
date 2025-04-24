<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
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
            outline: none;
        }
        
        /* Remove any focus outlines that might show blue */
        *:focus {
            outline: none;
        }
        
        /* Improve the appearance of form elements */
        input, button {
            border: none;
            outline: none;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: var(--bg-color);
            transition: background-color 0.3s, color 0.3s;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
        }
        
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 600px;
            background-color: var(--card-bg);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }
        
        .left-panel {
            width: 50%;
            background-color: var(--card-bg);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .right-panel {
            width: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .illustration {
            width: 80%;
            max-width: 400px;
            height: auto;
            animation: fadeIn 1s ease-out forwards;
        }
        
        .form-title {
            margin-bottom: 30px;
        }
        
        .title-text {
            font-weight: 700;
            font-size: 36px;
            color: var(--text-color);
            margin-bottom: 10px;
        }
        
        .subtitle-text {
            font-weight: 400;
            font-size: 16px;
            color: var(--text-color);
            opacity: 0.7;
        }
        
        .form-group {
            margin-bottom: 24px;
            width: 100%;
        }
        
        .input-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .input-label span {
            color: var(--text-color);
            opacity: 0.7;
            font-size: 14px;
        }
        
        .input-field {
            width: 100%;
            background-color: var(--input-bg);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--text-color);
            font-size: 16px;
        }
        
        .text-link {
            color: var(--text-color);
            opacity: 0.7;
            font-size: 14px;
            text-decoration: none;
            display: block;
            margin-bottom: 24px;
            transition: opacity 0.2s;
        }
        
        .text-link:hover {
            opacity: 1;
        }
        
        .button-primary {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            font-size: 16px;
            font-weight: 500;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .button-primary:hover {
            background-color: var(--primary-dark);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
            }
            
            .left-panel, .right-panel {
                width: 100%;
            }
            
            .left-panel {
                padding: 40px 20px;
            }
            
            .right-panel {
                height: 300px;
                order: -1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-wrapper">
            <div class="left-panel">
                <div class="form-title">
                    <div class="title-text">Verify Email</div>
                    <div class="subtitle-text">Enter the code to continue</div>
                </div>
                
                <form action="{{ route('verification.verify', ['id' => auth()->user()->id, 'hash' => sha1(auth()->user()->email)]) }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <div class="input-label">
                            <span>Verification Code</span>
                            <img class="w-6 h-6" alt="Eye slash fill" src="/images/eye-slash-fill.svg" />
                        </div>
                        <input
                            type="text"
                            name="code"
                            class="input-field"
                            placeholder="Enter verification code"
                        />
                    </div>
                    
                    <a href="{{ route('verification.send') }}" 
                       onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                       class="text-link"
                    >
                        Resend code?
                    </a>
                    
                    <button 
                        type="submit"
                        class="button-primary"
                    >
                        Verify
                    </button>
                </form>
                
                <form id="resend-form" action="{{ route('verification.send') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
            
            <div class="right-panel">
                <img src="/images/boyss.png" alt="Student illustration" class="illustration" />
            </div>
        </div>
    </div>
</body>
</html>
