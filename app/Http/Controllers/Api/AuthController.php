<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string', 'max:255', 'unique:users,login'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'result' => []
                ], 401
            );
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $token = $user->createToken($request->login)->plainTextToken;

        return response()->json([
            'error' => null,
            'result' => [
                'login' => $user->login,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'token' => $token
            ]
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'result' => []
            ], 401
            );
        }

        $user = User::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'The provided credentials are incorrect.',
                'result' => []
                ], 401
            );
        }

        return response()->json([
            'error' => null,
            'result' => [
                'token' => $user->createToken($request->login)->plainTextToken
                ]
        ], 200);
    }
}
