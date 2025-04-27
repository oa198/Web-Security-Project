<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        black: "rgba(0, 0, 0, 1)",
                        darkpurple: "rgba(120, 72, 199, 1)",
                        descedent: "rgba(32, 32, 32, 1)",
                        purple: "rgba(152, 92, 228, 1)",
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
        :root {
            --black: rgba(0, 0, 0, 1);
            --darkpurple: rgba(120, 72, 199, 1);
            --descedent: rgba(32, 32, 32, 1);
            --purple: rgba(152, 92, 228, 1);
            --shape-corner-extra-large: 28px;
            --shape-corner-large: 16px;
            --bg-white: #ffffff;
            --bg-neutral-100: #f5f5f5;
            --text-color: #000000;
            --text-secondary: #6b6b6b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        
        .text-purple {
            color: var(--purple);
        }
        
        .bg-purple {
            background-color: var(--purple);
        }
        
        [data-theme="dark"] {
            --bg-white: #121212;
            --bg-neutral-100: #222222;
            --text-color: #ffffff;
            --text-secondary: #aaaaaa;
            --sidebar-bg: #985ce4;
            --sidebar-text: #f0f0f0;
            --input-bg: #2a2a2a;
            --circle-bg: #333;
            --welcome-card: #985ce4;
            --toggle-bg: #2a2a2a;
            --toggle-button: #985ce4;
        }
        
        /* Dark mode overrides */
        [data-theme="dark"] body {
            background-color: var(--bg-white);
            color: var(--text-color);
        }

        [data-theme="dark"] .bg-white {
            background-color: var(--bg-white);
        }

        [data-theme="dark"] .bg-neutral-100 {
            background-color: var(--bg-neutral-100);
        }

        [data-theme="dark"] .text-black {
            color: var(--text-color);
        }

        [data-theme="dark"] .text-secondary {
            color: var(--text-secondary);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-white);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--purple);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--darkpurple);
        }
        
        /* Notification dot */
        .notification-dot {
            position: absolute;
            top: 1.5px;
            left: 7px;
            width: 8px;
            height: 8px;
            background-color: #ff0000;
            border-radius: 50%;
        }
        
        /* Theme toggle */
        .theme-toggle {
            width: 50px;
            height: 24px;
            background-color: #f0f0f0;
            border-radius: 12px;
            position: absolute;
            cursor: pointer;
            top: 50px;
            right: 80px;
            z-index: 10;
            transition: background-color 0.3s;
        }

        [data-theme="dark"] .theme-toggle {
            background-color: #2a2a2a;
        }
        
        .theme-toggle-button {
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: var(--purple);
            top: 3px;
            left: 3px;
            transition: transform 0.3s;
        }
        
        [data-theme="dark"] .theme-toggle-button {
            transform: translateX(26px);
        }
        
        /* Sun and moon icons */
        .sun-icon, .moon-icon {
            position: absolute;
            width: 14px;
            height: 14px;
            top: 5px;
        }
        
        .sun-icon {
            right: 5px;
        }
        
        .moon-icon {
            left: 5px;
        }
        
        [data-theme="dark"] .sun-icon {
            opacity: 0.5;
        }
        
        [data-theme="light"] .moon-icon {
            opacity: 0.5;
        }
        
        /* User dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 150px;
            background-color: var(--bg-white);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 1000;
        }
        
        .user-dropdown.active {
            display: flex;
        }
        
        .dropdown-item {
            padding: 12px 16px;
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover {
            background-color: rgba(152, 92, 228, 0.1);
        }
        
        .dropdown-divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 0;
        }
        
        [data-theme="dark"] .dropdown-divider {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 1280px) {
            .dashboard-container {
                transform: scale(0.9);
                transform-origin: top left;
            }
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                transform: scale(0.8);
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                transform: scale(0.7);
            }
            .welcome-text {
                max-width: 90%;
            }
        }

        @media (max-width: 640px) {
            .dashboard-container {
                transform: scale(0.6);
            }
            .welcome-image {
                opacity: 0.5;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                transform: scale(0.5);
            }
            .theme-toggle {
                top: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body class="bg-white transition-colors duration-300">
    @if(session('info'))
    <div class="fixed top-5 right-5 p-4 bg-purple text-white rounded-lg shadow-lg z-50">
        {{ session('info') }}
    </div>
    @endif
    
    <div class="flex flex-row justify-center w-full overflow-x-hidden min-h-screen">
        <div class="w-[1440px] h-[1024px] relative dashboard-container">
            <!-- Theme Toggle Button -->
            <div class="theme-toggle" id="themeToggle">
                        <div class="theme-toggle-button"></div>
                <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                </svg>
                <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
            </div>
            
            <!-- Sidebar -->
            <div class="absolute w-[265px] h-[958px] top-[33px] left-[35px] rounded-[28px]">
                <div class="flex flex-col w-[265px] h-[958px] items-start gap-9 px-[53px] py-[42px] absolute top-0 left-0 bg-purple rounded-[28px]">
                    <img class="relative w-[158px] h-[150px] object-cover" alt="Logo" src="{{ asset('images/image 1.png') }}" />
                    
                    <div class="inline-flex flex-col items-center gap-[49px] relative flex-[0_0_auto]">
                        <div class="w-28 h-[546px] gap-2.5 flex flex-col items-start">
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="font-semibold leading-[22.4px]">
                                    Dashboard
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="font-light leading-[22.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Personal Info
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Mess info
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Academics
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Clubs
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Achievements
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Research work
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Internships
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Skills
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    <br />
                                </span>
                            </p>
                            <p class="relative self-stretch font-normal text-white text-base leading-4">
                                <span class="leading-[19.4px]">
                                    Projects
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('logout') }}" class="absolute h-[19px] top-[902px] left-[54px] font-normal text-white text-base leading-[19.4px] whitespace-nowrap">
                    Logout
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="absolute w-[444px] h-[57px] top-[33px] left-[343px] bg-neutral-100 rounded-[28px] shadow-[0px_4px_9.7px_#00000040] transition-colors duration-300">
                <form action="{{ url('/search') }}" method="GET">
                    <input type="text" name="query" placeholder="Search" class="absolute h-[19px] top-[18px] left-[20px] w-[90%] font-normal text-[#787878] text-base leading-[19.4px] bg-transparent border-none focus:outline-none">
                </form>
            </div>
            
            <!-- Notification Icon -->
            <div class="absolute w-[41px] h-8 top-[47px] left-[1314px] bg-[url(/notifications.svg)] bg-[100%_100%]">
                <div class="relative w-2 h-2 top-1.5 left-[7px] bg-[#ff0000] rounded"></div>
            </div>
            
            <!-- User Profile Section -->
            <div class="user-dropdown-container">
                <img class="absolute w-12 h-[50px] top-[38px] left-[994px] object-cover cursor-pointer" id="userAvatar" alt="User" src="{{ asset('images/image 2.png') }}" />
                
                <p class="absolute h-[38px] top-[47px] left-[1054px] font-normal text-base leading-[19.4px] transition-colors duration-300">
                    <span class="font-semibold text-[var(--text-color)]">
                            {{ Auth::user()->name ?? 'Nischal Basavaraju' }}
                        <br />
                        </span>
                    <span class="text-[var(--text-secondary)]">
                            2nd Year, Btech, CSE
                        </span>
                    </p>
                    
                <div class="user-dropdown" id="userDropdown">
                    <a href="{{ url('/profile') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
            
            <!-- Settings Icon -->
            <div class="absolute w-[29px] h-[29px] top-[50px] left-[1363px] text-[var(--text-color)] transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                </div>
            
            <!-- Welcome Card -->
            <div class="absolute w-[1056px] h-[235px] top-[119px] left-[343px]">
                <div class="absolute w-[1049px] h-[235px] top-0 left-0 bg-purple rounded-[16px]"></div>
                
                <p class="absolute top-[171px] left-[70px] font-normal text-white text-base leading-[19.4px] whitespace-nowrap welcome-text">
                    Always stay updated in your student portal
                </p>
                
                <p class="absolute top-[135px] left-[70px] font-semibold text-white text-2xl leading-[29.2px] whitespace-nowrap welcome-text">
                    Welcome back, {{ Auth::user()->name ?? 'Nischal Basavaraju' }}!!
                </p>
                
                <div class="absolute top-[43px] left-[70px] font-normal text-white text-base leading-[19.4px] whitespace-nowrap">
                    10th October, 2024
                </div>
                
                <div class="absolute top-[37px] left-[233px] flex items-center">
                    <span class="text-white mr-2">Calendar</span>
                    <svg width="24" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke="white" stroke-width="2"/>
                        <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M3 10H21" stroke="white" stroke-width="2"/>
                            </svg>
                </div>
                
                <img class="absolute w-[466px] h-[235px] top-0 left-[590px] object-cover welcome-image" alt="Welcome" src="{{ asset('images/image 3.png') }}">
                    </div>
            
            <!-- Basic Info Section -->
            <div class="absolute h-6 top-[393px] left-[365px] font-semibold text-[var(--text-color)] text-xl leading-[24.3px] whitespace-nowrap transition-colors duration-300">
                Basic Info
                    </div>
            
            <div class="absolute w-[371px] h-[276px] top-[430px] left-[343px] bg-neutral-100 rounded-[28px] shadow-[0px_4px_5.5px_#00000040] transition-colors duration-300">
                <div class="gap-[7px] relative w-[306px] h-[43px] top-[117px] left-[22px] flex flex-col items-start">
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                        <span class="font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                            Credits&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;40
                            <br />
                        </span>
                    </p>
                    
                    <p class="relative self-stretch font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                        <span class="font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                            <br />
                        </span>
                    </p>
                    
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                        <span class="font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                            CGPA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.3
                            <br />
                        </span>
                    </p>
                    
                    <p class="relative self-stretch font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                        <span class="font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                            <br />
                        </span>
                    </p>
                    
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                        <span class="font-normal text-[var(--text-secondary)] text-2xl leading-[29.2px] transition-colors duration-300">
                            Semester&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            3rd
                        </span>
                    </p>
                </div>
            </div>
            
            <!-- Attendance Section -->
            <div class="absolute h-6 top-[393px] left-[811px] font-semibold text-[var(--text-color)] text-xl leading-[24.3px] whitespace-nowrap transition-colors duration-300">
                Attendance
                </div>
                
            <div class="absolute w-[293px] h-[286px] top-[428px] left-[734px] bg-purple rounded-full flex items-center justify-center">
                <div class="w-[230px] h-[230px] bg-[var(--bg-white)] rounded-full flex items-center justify-center transition-colors duration-300">
                    <div class="font-semibold text-[var(--text-color)] text-xl transition-colors duration-300">90.5%</div>
                </div>
            </div>
            
            <!-- Other Images -->
            <img class="absolute w-[328px] h-[599px] top-[377px] left-[1064px] object-cover" alt="Image 4" src="{{ asset('images/image 4.png') }}">
            <img class="absolute w-[721px] h-[229px] top-[746px] left-[332px] object-cover" alt="Image 5" src="{{ asset('images/image 5.png') }}">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme toggle functionality
            const themeToggle = document.getElementById('themeToggle');
            const htmlElement = document.documentElement;
            
            // Check if user has a saved preference
            const savedTheme = localStorage.getItem('theme') || 'light';
                htmlElement.setAttribute('data-theme', savedTheme);
            
            themeToggle.addEventListener('click', function() {
                const currentTheme = htmlElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
            
            // User dropdown functionality
            const userAvatar = document.getElementById('userAvatar');
            const userDropdown = document.getElementById('userDropdown');
            
            userAvatar.addEventListener('click', function(event) {
                event.stopPropagation();
                userDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userAvatar.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html> 