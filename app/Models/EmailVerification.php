<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpVerification;

class EmailVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'email',
        'otp',
        'expires_at',
        'verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
    ];

    /**
     * Get the user that owns the email verification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a new OTP for the user.
     *
     * @param User $user
     * @return self
     */
    public static function generateOtp(User $user)
    {
        try {
            // Log OTP generation attempt
            Log::info('Generating new OTP', ['user_id' => $user->id, 'email' => $user->email]);
            
            // First, invalidate any existing OTPs for this user
            $invalidated = self::where('user_id', $user->id)
                ->where('verified', false)
                ->update(['verified' => true]);
                
            Log::info('Invalidated existing OTPs', ['count' => $invalidated]);

            // Generate a random 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Create a new OTP record
            $verification = self::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
                'verified' => false,
            ]);
            
            Log::info('Created new OTP record', [
                'verification_id' => $verification->id,
                'otp' => $otp,  // Only log this in development environment
                'expires_at' => $verification->expires_at
            ]);

            // Send the OTP via email
            Mail::to($user->email)->send(new OtpVerification($verification));
            Log::info('OTP email sent successfully', ['email' => $user->email]);

            return $verification;
        } catch (\Exception $e) {
            Log::error('Error generating OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Verify the OTP code.
     *
     * @param string $email
     * @param string $otp
     * @return bool
     */
    public static function verifyOtp(string $email, string $otp)
    {
        try {
            Log::info('Verifying OTP', ['email' => $email, 'otp_length' => strlen($otp)]);
            
            // First check if there are any active verification records for this email
            $activeVerifications = self::where('email', $email)
                ->where('verified', false)
                ->where('expires_at', '>', now())
                ->count();
            
            if ($activeVerifications === 0) {
                Log::warning('No active verification records found', ['email' => $email]);
                return false;
            }
            
            // Now try to find a matching OTP
            $verification = self::where('email', $email)
                ->where('otp', $otp)
                ->where('verified', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$verification) {
                Log::warning('Invalid OTP attempt', [
                    'email' => $email,
                    'provided_otp' => $otp,
                    'active_verifications_exist' => ($activeVerifications > 0)
                ]);
                return false;
            }

            Log::info('Valid OTP found', ['verification_id' => $verification->id]);
            
            // Mark the OTP as verified
            $verification->update(['verified' => true]);

            // Verify the user's email
            $user = $verification->user;
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                Log::info('User email marked as verified', ['user_id' => $user->id]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Error verifying OTP', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Check if an OTP is valid.
     *
     * @param string $email
     * @param string $otp
     * @return bool
     */
    public static function isValidOtp(string $email, string $otp)
    {
        return self::where('email', $email)
            ->where('otp', $otp)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
