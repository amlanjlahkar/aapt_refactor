<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MobileVerificationController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();

        if ($user->mobile_verified_at) {
            return redirect()->route('user.dashboard');
        }

        if (!session()->has('otp_sent') || !$user->mobile_otp || !$user->otp_expiry || Carbon::now()->gt($user->otp_expiry)) {
            try {
                $this->sendOtp($user);
                session(['otp_sent' => true]);
            } catch (\Exception $e) {
                // You can optionally log this error in production
            }
        }

        $maskedMobile = '+91******' . substr($user->mobile_no, -4);
        return view('otp.mobile_verify', ['maskedMobile' => $maskedMobile]);
    }

    public function resend(Request $request)
    {
        try {
            $user = Auth::user();

            $this->sendOtp($user);

            $message = config('app.debug') 
                ? "OTP sent (DEV: {$user->mobile_otp})"
                : "OTP sent to " . substr($user->mobile_no, 0, 5) . '****' . substr($user->mobile_no, -3);

            return back()->with('status', $message);

        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to send OTP. Please try again']);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_digit_1' => 'required|numeric|digits:1',
            'otp_digit_2' => 'required|numeric|digits:1',
            'otp_digit_3' => 'required|numeric|digits:1',
            'otp_digit_4' => 'required|numeric|digits:1',
            'otp_digit_5' => 'required|numeric|digits:1',
            'otp_digit_6' => 'required|numeric|digits:1',
        ]);

        $otp = implode('', [
            $request->input('otp_digit_1'),
            $request->input('otp_digit_2'),
            $request->input('otp_digit_3'),
            $request->input('otp_digit_4'),
            $request->input('otp_digit_5'),
            $request->input('otp_digit_6'),
        ]);

        $user = Auth::user();

        if ($user->mobile_verified_at) {
            return redirect()->route('user.dashboard')->with('status', 'Mobile number verified successfully!');
        }

        if (!$user->otp_expiry || Carbon::now()->gt($user->otp_expiry)) {
            session()->forget('otp_sent');
            return back()->withErrors(['otp' => 'OTP has expired or was not generated. Please request a new one.']);
        }

        if ($user->mobile_otp !== $otp) {
            return back()->withErrors(['otp' => 'Invalid OTP code. Please try again.']);
        }

        $user->update([
            'mobile_verified_at' => now(),
            'mobile_otp' => null,
            'otp_expiry' => null,
            'otp_sent_at' => null
        ]);

        session()->forget('otp_sent');

        return redirect()->route('user.dashboard')->with('status', 'Mobile number verified successfully!');
    }

    private function sendOtp($user)
    {
        $rawMobile = $user->mobile_no;

        $mobile = preg_replace('/^\+?91/', '', $rawMobile);
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($mobile) === 10) {
            $mobile = '+91' . $mobile;
        }

        if (!preg_match('/^\+91[6-9]\d{9}$/', $mobile)) {
            throw new \Exception('Invalid mobile number format');
        }

        if ($user->otp_sent_at && $user->otp_sent_at->addMinutes(2)->isFuture()) {
            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $apiKey = env('TWOFACTOR_API_KEY', 'TEST');
        $url = sprintf('https://2factor.in/API/V1/%s/SMS/%s/%s/OTP_VFY', $apiKey, urlencode($mobile), $otp);

        $response = Http::timeout(20)->get($url);
        $responseBody = $response->json();

        if (!$response->successful() || ($responseBody['Status'] ?? '') !== 'Success') {
            throw new \Exception('Failed to send OTP');
        }

        $user->update([
            'mobile_otp' => $otp,
            'otp_expiry' => now()->addMinutes(10),
            'otp_sent_at' => now(),
        ]);
    }
}
