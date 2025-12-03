<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client as GuzzleClient;

class AuthController extends Controller
{
    public function googleLogin(Request $request)
    {
        $token = $request->token;
        $proxy = 'http://mis:c%40sp3r2021@10.7.7.121:3128';

        $httpClient = new GuzzleClient([
            'proxy'  => $proxy,
            'verify' => false,
            'timeout' => 10,
        ]);

        $client = new GoogleClient();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setHttpClient($httpClient);

        try {
            $payload = $client->verifyIdToken($token);

            if (!$payload) {
                return response()->json(['message' => 'Invalid Google Token'], 401);
            }

            $email = $payload['email'];
            $name  = $payload['name'];
            $googleId = $payload['sub'];

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'       => $name,
                    'password'   => bcrypt(str()->random(16)),
                    'google_id'  => $googleId,
                    'remember_token' => str()->random(60),
                ]
            );

            // Generate remember token if missing (returning users)
            if (!$user->remember_token) {
                $user->remember_token = str()->random(60);
                $user->save();
            }

            // Create token
            $authToken = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token'    => $authToken,
                'remember_token'  => $user->remember_token,
                'token_type'      => 'Bearer',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
