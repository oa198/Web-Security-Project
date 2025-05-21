@extends('layouts.app')

@section('title', 'Preferences - Student Portal')

@section('page_title', 'Preferences')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border">
        <!-- Settings Navigation -->
        <div class="border-b">
            <nav class="flex -mb-px">
                <a href="{{ route('settings.profile') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Profile Settings
                </a>
                <a href="{{ route('settings.security') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Security
                </a>
                <a href="{{ route('settings.preferences') }}" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Preferences
                </a>
            </nav>
        </div>

        <!-- Preferences Section -->
        <div class="p-6">
            <form action="{{ route('preferences.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Display Settings -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Display Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="theme" class="block text-sm font-medium text-gray-700">Theme</label>
                            <select id="theme" name="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="light" {{ auth()->user()->theme === 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ auth()->user()->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="system" {{ auth()->user()->theme === 'system' ? 'selected' : '' }}>System</option>
                            </select>
                        </div>

                        <div>
                            <label for="font_size" class="block text-sm font-medium text-gray-700">Font Size</label>
                            <select id="font_size" name="font_size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="small" {{ auth()->user()->font_size === 'small' ? 'selected' : '' }}>Small</option>
                                <option value="medium" {{ auth()->user()->font_size === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="large" {{ auth()->user()->font_size === 'large' ? 'selected' : '' }}>Large</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Language & Region -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Language & Region</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                            <select id="language" name="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="en" {{ auth()->user()->language === 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ auth()->user()->language === 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ auth()->user()->language === 'fr' ? 'selected' : '' }}>French</option>
                            </select>
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                            <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="UTC" {{ auth()->user()->timezone === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="EST" {{ auth()->user()->timezone === 'EST' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="PST" {{ auth()->user()->timezone === 'PST' ? 'selected' : '' }}>Pacific Time</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700">Date Format</label>
                            <select id="date_format" name="date_format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="MM/DD/YYYY" {{ auth()->user()->date_format === 'MM/DD/YYYY' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="DD/MM/YYYY" {{ auth()->user()->date_format === 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="YYYY-MM-DD" {{ auth()->user()->date_format === 'YYYY-MM-DD' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Accessibility -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Accessibility</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="high_contrast" name="high_contrast" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ auth()->user()->high_contrast ? 'checked' : '' }}>
                            <label for="high_contrast" class="ml-2 block text-sm text-gray-900">High Contrast Mode</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="reduced_motion" name="reduced_motion" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ auth()->user()->reduced_motion ? 'checked' : '' }}>
                            <label for="reduced_motion" class="ml-2 block text-sm text-gray-900">Reduced Motion</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="screen_reader" name="screen_reader" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ auth()->user()->screen_reader ? 'checked' : '' }}>
                            <label for="screen_reader" class="ml-2 block text-sm text-gray-900">Screen Reader Optimized</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Theme preview
    document.getElementById('theme').addEventListener('change', function(e) {
        const theme = e.target.value;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (theme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            // System theme
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    });

    // Font size preview
    document.getElementById('font_size').addEventListener('change', function(e) {
        const size = e.target.value;
        document.documentElement.style.fontSize = size === 'small' ? '14px' : size === 'large' ? '18px' : '16px';
    });
</script>
@endpush
@endsection 