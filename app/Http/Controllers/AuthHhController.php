<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Services\AuthHhService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthHhController extends Controller
{
    private AuthHhService $authHhService;

    public function __construct(AuthHhService $authHhService)
    {
        $this->authHhService = $authHhService;
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code not provided'], 400);
        }

        try {
            $tokenResponse = Http::asForm()->post('https://api.hh.ru/token', [
                'client_id' => "MQE3L3RMQ7EH536Q84L3MUVKLQOOUDHF5OU69IMFQMRAATEQ9VI86QFDLOI89J60",
                'client_secret' => "U4RGNQGU9QN58MT63NREHN0QQACG98DIUVL24U7GHHRJ4J9VN4ESSJ3U5I8GNU6O",
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => "http://localhost:8081/api/hh/callback",
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('HH Token Request Error:', $tokenResponse->json());
                return response()->json(['error' => 'Failed to get token from HH.ru', 'hh_error' => $tokenResponse->json()], $tokenResponse->status());
            }

            $accessToken = $tokenResponse->json('access_token');
            $refreshToken = $tokenResponse->json('refresh_token');

            $userInfoResponse = Http::withToken($accessToken)->get('https://api.hh.ru/me');

            if (!$userInfoResponse->successful()) {
                Log::error('HH User Info Request Error:', $userInfoResponse->json());
                return response()->json(['error' => 'Failed to get user info from HH.ru', 'hh_error' => $userInfoResponse->json()], $userInfoResponse->status());
            }

            $hhUserData = $userInfoResponse->json();

            Log::info('HH User Data received in callback:', $hhUserData);

            // Authenticate or create user using your service
            if ($this->authHhService->checkUser($hhUserData)) {
                $this->authHhService->authUser($hhUserData);
                $tokens = Token::where('user_id', Auth::user()->id)->first();
                if ($tokens) {
                    // Update the existing tokens
                    $tokens->access_token = $accessToken;
                    $tokens->refresh_token = $refreshToken;
                    $tokens->save();
                } else {
                    // Create a new Token record
                    $tokens = new Token();
                    $tokens->user_id = Auth::user()->id;
                    $tokens->access_token = $accessToken;
                    $tokens->refresh_token = $refreshToken;
                    $tokens->save();
                }
            } else {
                $this->authHhService->createUser($hhUserData);
                $this->authHhService->authUser($hhUserData);
                $tokens = new Token();
                $tokens->user_id = Auth::user()->id;
                $tokens->access_token = $accessToken;
                $tokens->refresh_token = $refreshToken;
                $tokens->save();
            }

            // Redirect to frontend success page or return success JSON
            return redirect()->away(env('FRONTEND_URL') . '/hhAuthSuccess?success=true'); // Redirect with success parameter

            // Or, if you prefer JSON response:
            // return response()->json(['status' => 'success', 'message' => 'HH.ru authentication successful']);

        } catch (\Exception $e) {
            Log::error('Exception in HH callback:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred during HH.ru authentication', 'exception' => $e->getMessage()], 500);
        }
    }

    public function auth(Request $request)
    {
        $userData = $request->input('userData');

        Log::info('AuthHhController::auth() - userData: ' . json_encode($userData));

        $isAuthenticated = false;
        $isNewUser = false;

        if ($this->authHhService->checkUser($userData)) {
            $isAuthenticated = $this->authHhService->authUser($userData);
        } else {
            if ($this->authHhService->createUser($userData)) {
                $isAuthenticated = $this->authHhService->authUser($userData);
                $isNewUser = true;
            }
        }

        if ($isAuthenticated) {
            return [
                'status' => 'ok',
                'composables' => true,
                'user' => Auth::user(),
                'is_new_user' => $isNewUser,
            ];
        } else {
            return [
                'status' => 'ok',
                'composables' => false,
            ];
        }
    }

    public function logout(Request $request)
    {
        // Удаляем пользователя из сессии
        Auth::logout();

        // Удаляем все данные сессии
        $request->session()->invalidate();

        // Удаляем токены сессии
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}
