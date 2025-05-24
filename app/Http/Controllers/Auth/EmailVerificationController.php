<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    /**
     * Show OTP verification form.
     *
     * @return \Illuminate\View\View
     */
    public function showOtpForm()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP code submitted by the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        Log::info('OTP verification attempt received', [
            'request_data' => $request->all(),
            'has_otp' => $request->has('otp'),
            'otp_value' => $request->otp
        ]);
        
        try {
            // Validate the OTP input
            $request->validate([
                'otp' => 'required|string|size:6|regex:/^[0-9]{6}$/'
            ], [
                'otp.required' => 'Please enter the verification code',
                'otp.size' => 'The verification code must be 6 digits',
                'otp.regex' => 'The verification code must contain only numbers'
            ]);
            
            $user = Auth::user();
            $otp = $request->otp;
            
            Log::info('Processing OTP verification', [
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $otp
            ]);
            
            // Get latest active verification record
            $verificationRecord = EmailVerification::where('email', $user->email)
                ->where('verified', false)
                ->where('expires_at', '>', now())
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$verificationRecord) {
                Log::warning('No active verification record found', ['email' => $user->email]);
                return redirect()->back()->withErrors([
                    'otp' => 'No active verification code found or code has expired. Please request a new code.'
                ]);
            }
            
            // Compare OTP with the one in the database
            if ($verificationRecord->otp !== $otp) {
                Log::warning('Invalid OTP provided', [
                    'email' => $user->email,
                    'expected' => $verificationRecord->otp,
                    'provided' => $otp
                ]);
                return redirect()->back()->withErrors([
                    'otp' => 'Invalid verification code. Please try again.'
                ]);
            }

            // Mark verification as complete
            $verificationRecord->update(['verified' => true]);
            
            // Verify the user's email
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                Log::info('Email verified successfully', ['user_id' => $user->id]);
            }

            // Add a session flash message
            Session::flash('status', 'Your email has been verified successfully!'); 
            
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('OTP verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->withErrors([
                'otp' => 'An error occurred during verification. Please try again.'
            ]);
        }
    }

    /**
     * Resend OTP code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(Request $request)
    {
        try {
            $user = Auth::user();
            Log::info('OTP resend request', ['email' => $user->email]);
            
            // Generate new OTP
            $verification = EmailVerification::generateOtp($user);
            Log::info('New OTP generated successfully');
            
            return back()->with('status', 'A new verification code has been sent to your email address');
            
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'otp' => 'Failed to send verification code. Please try again later.'
            ]);
        }
    }
}
