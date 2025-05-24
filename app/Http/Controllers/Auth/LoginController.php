<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
   

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $key = Str::lower($request->input('email')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Please try again in 1 minute.']);
        }
        RateLimiter::hit($key, 60);

        // Check if user is an admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Check if user is a regular user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Redirect the user to Google's OAuth consent screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after OAuth consent.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Retrieve Google user data with state validation
            $googleUser = Socialite::driver('google')->user();

            // Find user by google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Check if email is already registered
                $existingUser = User::where('email', $googleUser->getEmail())->first();
                if ($existingUser) {
                    Log::warning('Google login attempted with registered email', [
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                    ]);
                    return redirect()->route('login')->withErrors([
                        'email' => 'This email is already registered. Please link your Google account in settings or use your existing login method.',
                    ]);
                }

                // Validate avatar URL
                $avatar = $googleUser->getAvatar();
                if ($avatar && !Str::startsWith($avatar, 'https://lh3.googleusercontent.com/')) {
                    $avatar = null;
                }

                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'avatar' => $avatar,
                    'email_verified_at' => now(),
                    'password' => null,
                ]);

                Log::info('New user created via Google login', [
                    'email' => $user->email,
                    'google_id' => $user->google_id,
                ]);
            } elseif ($user->email !== $googleUser->getEmail()) {
                // Handle email mismatch (e.g., Google account email changed)
                Log::warning('Google login email mismatch', [
                    'user_id' => $user->id,
                    'google_email' => $googleUser->getEmail(),
                    'stored_email' => $user->email,
                ]);
                return redirect()->route('login')->withErrors([
                    'email' => 'The email associated with this Google account has changed. Please update your account settings.',
                ]);
            } else {
                // Update tokens for existing user
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
                ]);
            }

            // Log in the user and regenerate session
            Auth::login($user, true);
            session()->regenerate();

            Log::info('User logged in via Google', [
                'email' => $user->email,
                'google_id' => $user->google_id,
            ]);

            return redirect()->route('dashboard');
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Invalid OAuth state during Google login', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid login attempt. Please try again.',
            ]);
        } catch (\Exception $e) {
            Log::error('Google login failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Provide more specific error message for debugging
            $errorMessage = 'Unable to login with Google: ' . $e->getMessage();
            
            // In production, you might want to use a generic message instead
            // $errorMessage = 'Unable to login with Google. Please try again later.';
            
            return redirect()->route('login')->withErrors([
                'email' => $errorMessage,
            ]);
        }
    }

    /**
     * Redirect the user to GitHub's OAuth consent screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle the callback from GitHub after OAuth consent.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGithubCallback()
    {
        try {
            // Retrieve GitHub user data with state validation
            $githubUser = Socialite::driver('github')->user();

            // Find user by github_id
            $user = User::where('github_id', $githubUser->getId())->first();

            if (!$user) {
                // Check if email is already registered
                // Note: GitHub might not provide an email if user has set it as private
                $email = $githubUser->getEmail() ?? null;
                
                if ($email) {
                    $existingUser = User::where('email', $email)->first();
                    if ($existingUser) {
                        Log::warning('GitHub login attempted with registered email', [
                            'email' => $email,
                            'github_id' => $githubUser->getId(),
                        ]);
                        return redirect()->route('login')->withErrors([
                            'email' => 'This email is already registered. Please link your GitHub account in settings or use your existing login method.',
                        ]);
                    }
                }

                // Validate avatar URL
                $avatar = $githubUser->getAvatar();
                if ($avatar && !Str::startsWith($avatar, 'https://avatars.githubusercontent.com/')) {
                    $avatar = null;
                }

                // Create new user
                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'email' => $email ?? $githubUser->getId() . '@github.noemail',
                    'github_id' => $githubUser->getId(),
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken,
                    'avatar' => $avatar,
                    'email_verified_at' => $email ? now() : null,
                    'password' => null,
                ]);

                Log::info('New user created via GitHub login', [
                    'email' => $user->email,
                    'github_id' => $user->github_id,
                ]);
            } else {
                // Update tokens for existing user
                $user->update([
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken ?? $user->github_refresh_token,
                ]);
            }

            // Log in the user and regenerate session
            Auth::login($user, true);
            session()->regenerate();

            Log::info('User logged in via GitHub', [
                'email' => $user->email,
                'github_id' => $user->github_id,
            ]);

            return redirect()->route('dashboard');
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Invalid OAuth state during GitHub login', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid login attempt. Please try again.',
            ]);
        } catch (\Exception $e) {
            Log::error('GitHub login failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Provide more specific error message for debugging
            $errorMessage = 'Unable to login with GitHub: ' . $e->getMessage();
            
            // In production, you might want to use a generic message instead
            // $errorMessage = 'Unable to login with GitHub. Please try again later.';
            
            return redirect()->route('login')->withErrors([
                'email' => $errorMessage,
            ]);
        }
    }

    /**
     * Redirect the user to LinkedIn's OAuth consent screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')
            ->stateless() // Using stateless mode to avoid CSRF token issues
            ->scopes(['r_liteprofile']) // Only request the profile scope which should be authorized
            ->redirect();
    }

    /**
     * Handle the callback from LinkedIn after OAuth consent.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLinkedinCallback(Request $request)
    {
        try {
            // Debug logging - capture all incoming parameters
            Log::info('LinkedIn callback received parameters', [
                'all_params' => $request->all(),
                'query_string' => $request->getQueryString(),
                'has_code' => $request->has('code'),
                'code_value' => $request->input('code')
            ]);
            
            // Check if there's a code parameter in the request
            if (!$request->has('code')) {
                Log::error('LinkedIn callback missing code parameter', [
                    'request_params' => $request->all()
                ]);
                return redirect()->route('login')->withErrors([
                    'email' => 'Authentication error: Missing required parameters from LinkedIn. Please try again.'
                ]);
            }

            // Retrieve LinkedIn user data without state validation
            $linkedinUser = Socialite::driver('linkedin')->stateless()->user();

            // Find user by linkedin_id
            $user = User::where('linkedin_id', $linkedinUser->getId())->first();

            if (!$user) {
                // Check if email is already registered
                if ($linkedinUser->getEmail()) {
                    $existingUser = User::where('email', $linkedinUser->getEmail())->first();
                    if ($existingUser) {
                        Log::warning('LinkedIn login attempted with registered email', [
                            'email' => $linkedinUser->getEmail(),
                            'linkedin_id' => $linkedinUser->getId(),
                        ]);
                        return redirect()->route('login')->withErrors([
                            'email' => 'This email is already registered. Please link your LinkedIn account in settings or use your existing login method.',
                        ]);
                    }
                }

                // Validate avatar URL
                $avatar = $linkedinUser->getAvatar();
                if ($avatar && !Str::startsWith($avatar, 'https://media.licdn.com/')) {
                    $avatar = null;
                }

                // Create new user
                $user = User::create([
                    'name' => $linkedinUser->getName(),
                    'email' => $linkedinUser->getEmail(),
                    'linkedin_id' => $linkedinUser->getId(),
                    'avatar' => $avatar,
                    'email_verified_at' => now(),
                    'password' => null,
                ]);

                Log::info('New user created via LinkedIn login', [
                    'email' => $user->email,
                    'linkedin_id' => $user->linkedin_id,
                ]);
            } elseif ($user->email !== $linkedinUser->getEmail() && $linkedinUser->getEmail()) {
                // Handle email mismatch (e.g., LinkedIn account email changed)
                Log::warning('LinkedIn login email mismatch', [
                    'user_id' => $user->id,
                    'linkedin_email' => $linkedinUser->getEmail(),
                    'stored_email' => $user->email,
                ]);
                return redirect()->route('login')->withErrors([
                    'email' => 'The email associated with this LinkedIn account has changed. Please update your account settings.',
                ]);
            }

            // Store LinkedIn token and refresh token
            $user->linkedin_token = $linkedinUser->token;
            $user->linkedin_refresh_token = $linkedinUser->refreshToken ?? null;
            $user->save();
            
            // Log token storage
            Log::info('LinkedIn tokens stored for user', [
                'user_id' => $user->id,
                'token_length' => $linkedinUser->token ? strlen($linkedinUser->token) : 0,
                'has_refresh_token' => !empty($linkedinUser->refreshToken)
            ]);
            
            // Log in the user and regenerate session
            Auth::login($user, true);
            session()->regenerate();

            Log::info('User logged in via LinkedIn', [
                'user_id' => $user->id,
                'linkedin_id' => $user->linkedin_id,
            ]);

            return redirect()->route('dashboard');
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Invalid OAuth state during LinkedIn login', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid login attempt. Please try again.',
            ]);
        } catch (\Exception $e) {
            Log::error('LinkedIn login failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Provide more specific error message for debugging
            $errorMessage = 'Unable to login with LinkedIn: ' . $e->getMessage();
            
            // In production, you might want to use a generic message instead
            // $errorMessage = 'Unable to login with LinkedIn. Please try again later.';
            
            return redirect()->route('login')->withErrors([
                'email' => $errorMessage,
            ]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
} 