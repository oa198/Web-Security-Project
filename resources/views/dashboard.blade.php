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
            --bg-color: #121212;
            --text-color: #e0e0e0;
            --secondary-text: #aaa;
            --card-bg: #1e1e1e;
            --card-hover-shadow: rgba(255, 255, 255, 0.1);
            --sidebar-bg: #985ce4;
            --sidebar-text: #f0f0f0;
            --input-bg: #2a2a2a;
            --circle-bg: #333;
            --section-title: #e0e0e0;
            --welcome-card: #985ce4;
            --toggle-bg: #2a2a2a;
            --toggle-button: #985ce4;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-color);
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
            background-color: var(--toggle-bg, #f0f0f0);
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s, transform 0.2s;
        }
        
        .theme-toggle-button {
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: var(--toggle-button, var(--purple));
            top: 3px;
            left: 3px;
            transition: transform 0.3s, background-color 0.3s;
        }
        
        [data-theme="dark"] .theme-toggle-button {
            transform: translateX(26px);
        }
        
        /* User dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 150px;
            background-color: white;
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
            color: #000;
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
    </style>
</head>
<body class="bg-white">
    @if(session('info'))
    <div class="fixed top-5 right-5 p-4 bg-purple text-white rounded-lg shadow-lg z-50">
        {{ session('info') }}
    </div>
    @endif
    
    <div class="flex flex-row justify-center w-full">
        <div class="w-[1440px] h-[1024px] relative">
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
            <div class="absolute w-[444px] h-[57px] top-[33px] left-[343px] bg-neutral-100 rounded-[28px] shadow-[0px_4px_9.7px_#00000040]">
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
                
                <p class="absolute h-[38px] top-[47px] left-[1054px] font-normal text-base leading-[19.4px]">
                    <span class="font-semibold text-[#000000]">
                        {{ Auth::user()->name ?? 'Nischal Basavaraju' }}
                        <br />
                    </span>
                    <span class="text-[#6b6b6b]">
                        2nd Year, Btech, CSE
                    </span>
                </p>
                
                <div class="user-dropdown" id="userDropdown">
                    <a href="{{ url('/profile') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
            
            <!-- Settings Icon -->
            <div class="absolute w-[29px] h-[29px] top-[50px] left-[1363px]">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
            </div>
            
            <!-- Welcome Card -->
            <div class="absolute w-[1056px] h-[235px] top-[119px] left-[343px]">
                <div class="absolute w-[1049px] h-[235px] top-0 left-0 bg-purple rounded-[16px]"></div>
                
                <p class="absolute top-[171px] left-[70px] font-normal text-white text-base leading-[19.4px] whitespace-nowrap">
                    Always stay updated in your student portal
                </p>
                
                <p class="absolute top-[135px] left-[70px] font-semibold text-white text-2xl leading-[29.2px] whitespace-nowrap">
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
                
                <img class="absolute w-[466px] h-[235px] top-0 left-[590px] object-cover" alt="Welcome" src="{{ asset('images/image 3.png') }}">
            </div>
            
            <!-- Basic Info Section -->
            <div class="absolute h-6 top-[393px] left-[365px] font-semibold text-[#000000] text-xl leading-[24.3px] whitespace-nowrap">
                Basic Info
            </div>
            
            <div class="absolute w-[371px] h-[276px] top-[430px] left-[343px] bg-neutral-100 rounded-[28px] shadow-[0px_4px_5.5px_#00000040]">
                <div class="gap-[7px] relative w-[306px] h-[43px] top-[117px] left-[22px] flex flex-col items-start">
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                        <span class="font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                            Credits&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;40
                            <br />
                        </span>
                    </p>
                    
                    <p class="relative self-stretch font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                        <span class="font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                            <br />
                        </span>
                    </p>
                    
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                        <span class="font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                            CGPA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.3
                            <br />
                        </span>
                    </p>
                    
                    <p class="relative self-stretch font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                        <span class="font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                            <br />
                        </span>
                    </p>
                    
                    <p class="mb-[-15.00px] relative self-stretch font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                        <span class="font-normal text-[#4d4d4d] text-2xl leading-[29.2px]">
                            Semester&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            3rd
                        </span>
                    </p>
                </div>
            </div>
            
            <!-- Attendance Section -->
            <div class="absolute h-6 top-[393px] left-[811px] font-semibold text-[#000000] text-xl leading-[24.3px] whitespace-nowrap">
                Attendance
            </div>
            
            <div class="absolute w-[293px] h-[286px] top-[428px] left-[734px] bg-purple rounded-full flex items-center justify-center">
                <div class="w-[230px] h-[230px] bg-white rounded-full flex items-center justify-center">
                    <div class="font-semibold text-black text-xl">90.5%</div>
                </div>
            </div>
            
            <!-- Other Images -->
            <img class="absolute w-[328px] h-[599px] top-[377px] left-[1064px] object-cover" alt="Image 4" src="{{ asset('images/image 4.png') }}">
            <img class="absolute w-[721px] h-[229px] top-[746px] left-[332px] object-cover" alt="Image 5" src="{{ asset('images/image 5.png') }}">
        </div>
    </div>

    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
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