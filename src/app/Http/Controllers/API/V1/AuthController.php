<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\RegisterRequest;
use App\Mail\NewUserSignedUp;
use App\Models\User;
use App\Notifications\LoggedInAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create(array_merge(
            $request->only('name', 'email'),
            [
                'password' => bcrypt($request->password)
            ],
        ));

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            Mail::to($user)->send(new NewUserSignedUp($user));
            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ],422);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;


        $admins = User::where('role_id', 2)->get();
        if ($user->roles_id === 2) {
            Notification::send($admins, new LoggedInAdminNotification($user));
        }


        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    }

}
