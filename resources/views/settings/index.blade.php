@extends('layouts.app')

@section('title', 'Settings - Student Portal')

@section('page_title', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border">
        <!-- Settings Navigation -->
        <div class="border-b">
            <nav class="flex -mb-px">
                <a href="{{ route('settings.profile') }}" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Profile Settings
                </a>
                <a href="{{ route('settings.security') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Security
                </a>
                <a href="{{ route('settings.preferences') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Preferences
                </a>
            </nav>
        </div>

        <!-- Profile Settings Section -->
        <div id="profile" class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Settings</h3>
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Section -->
        <div id="security" class="p-6 border-t hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Security Settings</h3>
            <div class="space-y-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Change Password</h4>
                    <form action="{{ route('password.update') }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <div class="border-t pt-6">
                    <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                    <p class="mt-1 text-sm text-gray-500">Add an extra layer of security to your account.</p>
                    <div class="mt-4">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Enable 2FA
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div id="notifications" class="p-6 border-t hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Preferences</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                        <p class="text-sm text-gray-500">Receive email notifications for important updates.</p>
                    </div>
                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out rounded-full">
                        <input type="checkbox" class="sr-only" id="email-notifications">
                        <label for="email-notifications" class="block w-12 h-6 bg-gray-200 rounded-full cursor-pointer"></label>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Assignment Reminders</h4>
                        <p class="text-sm text-gray-500">Get reminded about upcoming assignments.</p>
                    </div>
                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out rounded-full">
                        <input type="checkbox" class="sr-only" id="assignment-reminders">
                        <label for="assignment-reminders" class="block w-12 h-6 bg-gray-200 rounded-full cursor-pointer"></label>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Grade Updates</h4>
                        <p class="text-sm text-gray-500">Receive notifications when grades are posted.</p>
                    </div>
                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out rounded-full">
                        <input type="checkbox" class="sr-only" id="grade-updates">
                        <label for="grade-updates" class="block w-12 h-6 bg-gray-200 rounded-full cursor-pointer"></label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preferences Section -->
        <div id="preferences" class="p-6 border-t hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Display Preferences</h3>
            <div class="space-y-4">
                <div>
                    <label for="theme" class="block text-sm font-medium text-gray-700">Theme</label>
                    <select id="theme" name="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System</option>
                    </select>
                </div>

                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                    <select id="language" name="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="en">English</option>
                        <option value="es">Spanish</option>
                        <option value="fr">French</option>
                    </select>
                </div>

                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                    <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="UTC">UTC</option>
                        <option value="EST">Eastern Time</option>
                        <option value="PST">Pacific Time</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tab switching functionality
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            
            // Hide all sections
            document.querySelectorAll('div[id]').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show target section
            document.getElementById(targetId).classList.remove('hidden');
            
            // Update active tab
            document.querySelectorAll('nav a').forEach(tab => {
                tab.classList.remove('border-primary-500', 'text-primary-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            link.classList.remove('border-transparent', 'text-gray-500');
            link.classList.add('border-primary-500', 'text-primary-600');
        });
    });
</script>
@endpush
@endsection 