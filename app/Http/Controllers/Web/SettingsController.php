<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Show the profile settings page.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show the security settings page.
     */
    public function security()
    {
        return view('settings.security');
    }

    /**
     * Show the preferences settings page.
     */
    public function preferences()
    {
        return view('settings.preferences');
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()->route('settings.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('settings.security')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Toggle two-factor authentication.
     */
    public function toggle2FA(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();

        $message = $user->two_factor_enabled 
            ? 'Two-factor authentication enabled successfully.'
            : 'Two-factor authentication disabled successfully.';

        return redirect()->route('settings.security')
            ->with('success', $message);
    }

    /**
     * Destroy a user session.
     */
    public function destroySession($sessionId)
    {
        $user = Auth::user();
        
        // Find and delete the session
        $session = $user->sessions()->where('id', $sessionId)->first();
        
        if ($session) {
            $session->delete();
            return redirect()->route('settings.security')
                ->with('success', 'Session revoked successfully.');
        }

        return redirect()->route('settings.security')
            ->with('error', 'Session not found.');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'theme' => ['required', 'string', Rule::in(['light', 'dark', 'system'])],
            'font_size' => ['required', 'string', Rule::in(['small', 'medium', 'large'])],
            'language' => ['required', 'string', Rule::in(['en', 'es', 'fr'])],
            'timezone' => ['required', 'string', Rule::in(['UTC', 'EST', 'PST'])],
            'date_format' => ['required', 'string', Rule::in(['MM/DD/YYYY', 'DD/MM/YYYY', 'YYYY-MM-DD'])],
            'high_contrast' => ['boolean'],
            'reduced_motion' => ['boolean'],
            'screen_reader' => ['boolean'],
        ]);

        // Convert checkbox values to boolean
        $validated['high_contrast'] = $request->has('high_contrast');
        $validated['reduced_motion'] = $request->has('reduced_motion');
        $validated['screen_reader'] = $request->has('screen_reader');

        $user->update($validated);

        // Update session preferences
        Session::put('theme', $validated['theme']);
        Session::put('font_size', $validated['font_size']);

        return redirect()->route('settings.preferences')
            ->with('success', 'Preferences updated successfully.');
    }
} 