<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function googleLogin(Request $request)
    {
        $token = $request->token;

        $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);

        try {
            $payload = $client->verifyIdToken($token);

            if (!$payload) {
                return response()->json(['message' => 'Invalid Google Token'], 401);
            }

            // Google user data
            $email = $payload['email'];
            $name  = $payload['name'];
            $googleId = $payload['sub'];

            // Check if user exists
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Create user automatically
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt(str()->random(16)),
                    'google_id' => $googleId,
                ]);
            }

            // Generate your app's JWT or Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
