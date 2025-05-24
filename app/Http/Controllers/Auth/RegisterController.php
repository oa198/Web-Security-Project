<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Mail\VerificationEmail;
use App\Mail\ForgetPassEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
    // Advanced registration with verification
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request) {
        $key = 'register|' . \Str::lower($request->input('email')) . '|' . $request->ip();
        if (\RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many registration attempts. Please try again in 1 minute.']);
        }
        \RateLimiter::hit($key, 60);
        
        try {
            $request->validate([
                'first_name' => ['required', 'string', 'min:2'],
                'last_name' => ['required', 'string', 'min:2'],
                'email' => ['required', 'email', 'unique:users'],
                'national_id' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/'],
                'street' => ['required', 'string', 'min:5'],
                'city' => ['required', 'string', 'min:2'],
                'state' => ['required', 'string', 'min:2'],
                'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
                'password' => [
                    'required', 
                    'confirmed', 
                    PasswordRule::min(8)
                        ->numbers()
                        ->letters()
                        ->mixedCase()
                        ->symbols()
                ],
                'terms' => ['required', 'accepted'],
                'privacy' => ['required', 'accepted'],
            ], [
                'first_name.required' => 'Please enter your first name.',
                'first_name.min' => 'Your first name must be at least 2 characters.',
                'last_name.required' => 'Please enter your last name.',
                'last_name.min' => 'Your last name must be at least 2 characters.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered. Please try logging in or use a different email.',
                'national_id.required' => 'Please enter your National ID number.',
                'national_id.regex' => 'National ID must be exactly 10 digits.',
                'street.required' => 'Please enter your street address.',
                'street.min' => 'Street address must be at least 5 characters.',
                'city.required' => 'Please enter your city.',
                'state.required' => 'Please enter your state/province.',
                'zip_code.required' => 'Please enter your ZIP/postal code.',
                'zip_code.regex' => 'ZIP code must be in format 12345 or 12345-6789.',
                'password.required' => 'Please create a password.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.numbers' => 'Password must include at least one number.',
                'password.letters' => 'Password must include at least one letter.',
                'password.mixedCase' => 'Password must include both uppercase and lowercase letters.',
                'password.symbols' => 'Password must include at least one special character (e.g., !@#$%^&*).',
                'terms.accepted' => 'You must accept the Terms of Service.',
                'privacy.accepted' => 'You must accept the Privacy Policy.',
            ]);
            
            // Debug log the form data
            Log::info('Registration form data received', [
                'form_data' => $request->except(['password', 'password_confirmation']),
            ]);
            
            // Create the user account WITHOUT verifying email
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => null, // Email requires verification
            ]);
            
            // Create the address JSON for storage
            $address = json_encode([
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code
            ]);
            
            // Create application record instead of directly creating a student
            try {
                // Create a new application
                $application = new \App\Models\Application([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'notes' => 'Application submitted through registration form.'
                ]);
                
                $application->save();
                
                // Store additional applicant data in the user's profile or session
                // We can retrieve this later when the application is approved
                session(['applicant_data' => [
                    'national_id' => $request->national_id,
                    'address' => $address
                ]]);
                
                Log::info('Application created successfully', [
                    'user_id' => $user->id,
                    'application_id' => $application->id
                ]);
                
                // Notify admissions department about the new application
                try {
                    // This would be implemented with a notification or email
                    // Mail::to('admissions@university.edu')->send(new NewApplicationSubmitted($application));
                } catch (\Exception $e) {
                    Log::error('Failed to send notification about new application', [
                        'application_id' => $application->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to create application record', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // We'll still continue with user creation even if application creation fails
                // This ensures the user can at least log in
            }
            
            // Automatically log the user in
            Auth::login($user);
            // Assign applicant role instead of student
            $user->assignRole('applicant');
    
            // Generate OTP for email verification
            $verification = \App\Models\EmailVerification::generateOtp($user);
            
            // Redirect to OTP verification page
            return redirect()->route('verify.otp.form')
                            ->with('status', 'Registration successful! Please verify your email address with the OTP code sent to your email.');
                            
        } catch(\Exception $e) {
            Log::error('Registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            // In development environment, show the actual error for debugging
            if (config('app.debug')) {
                return redirect()->back()->withInput($request->except('password', 'password_confirmation'))
                                       ->withErrors('Error: ' . $e->getMessage());
            }
            
            return redirect()->back()->withInput($request->except('password', 'password_confirmation'))
                                   ->withErrors('An unexpected error occurred during registration.');
        }
    }

    public function verify(Request $request) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        } catch (\Exception $e) {
            return response('Invalid or expired verification link.', 400);
        }
    
        $user = User::where('id', $decryptedData['id'])
                    ->where('email', $decryptedData['email'])
                    ->first();
    
        if (!$user) {
            return response('User not found or already verified.', 404);
        }
    
        if ($user->email_verified_at) {
            return view('users.verified', compact('user'))->with('status', 'Your email is already verified.');
        }
    
        $user->email_verified_at = Carbon::now();
        $user->save();
    
        return view('users.verified', compact('user'))->with('status', 'Your email has been successfully verified.');
    }

    public function showForgotForm() {
        return view('auth.forgot-password');
    }

    
    public function sendResetLink(Request $request) {
    $key = \Str::lower($request->input('email')) . '|' . $request->ip();
    if (\RateLimiter::tooManyAttempts($key, 5)) {
        return back()->withErrors(['email' => 'Too many reset attempts. Please try again in 1 minute.']);
    }
    \RateLimiter::hit($key, 60);
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered in our system.']);
        }
        if ($user->email_verified_at == null) {
            return back()->withErrors(['email' => 'Your email is not verified.']);
        }
        $title = "Reset Password Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("ShowRestForm", ['token' => $token]);
        Mail::to($user->email)->send(new ForgetPassEmail($link, $user->name));
        return redirect()->route('login')->with('status', 'Password reset link sent to your email.');
    }

    public function showResetLink(Request $request) {
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        return view('auth.reset-password', compact('user'));
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => ['required', 'confirmed', PasswordRule::min(8)->numbers()->letters()->mixedCase()->symbols()],
            'token' => ['required'], 
        ]);
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired token.']);
        }
        $user->password = bcrypt($request->password); 
        $user->save();
        return redirect()->route('login')->with('status', 'Password reset successfully.');
    }

    /**
     * Verify Cloudflare Turnstile token
     *
     * @param string $token The token from the CAPTCHA
     * @param string $ip The user's IP address
     * @return array The response from Cloudflare
     */
    private function verifyTurnstile($token, $ip)
    {
        try {
            // Log the verification attempt for debugging
            Log::info('Attempting Turnstile verification', [
                'ip' => $ip,
                'token_length' => strlen($token),
                'secret_key' => substr(env('CF_TURNSTILE_SECRET'), 0, 5) . '...' // Log only first few chars for security
            ]);
            
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => env('CF_TURNSTILE_SECRET'),
                'response' => $token,
                'remoteip' => $ip
            ]);
            
            $result = $response->json();
            
            // Log the result
            if (!isset($result['success']) || $result['success'] !== true) {
                Log::warning('Turnstile verification failed', [
                    'response' => $result,
                    'ip' => $ip
                ]);
            } else {
                Log::info('Turnstile verification successful');
            }
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Turnstile verification exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return ['success' => false, 'error-codes' => ['connection_error']];
        }
    }
} 