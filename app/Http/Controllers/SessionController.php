<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function login(Request $request) {
        $validate_data = Validator::make($request->all(), [
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'max:100']
        ]);

        if($validate_data->fails()) {
            $response_data['errors'] = $validate_data->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        $login_credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
        $user = User::where('email', $login_credentials['email'])->first();

        if(! $user) {
            $response_data['errors'] = 'User does not exist';
            return response()->json(['data' => $response_data], 404);
        }

        if (auth()->attempt($login_credentials) && $user->active_status) {
            /** @var User $user */
            $user = Auth::user(); 
            $token = $user->createToken('AccessToken')->accessToken;
            
            $response_data['user_name'] = $user->profile()->first()->name;
            $response_data['user_type'] = $user->profile_type;
            $response_data['user_id'] = $user->profile_id;
            $response_data['token'] = $token;
            $response_data['message'] = 'login successful';
            return response()->json(['data' => $response_data], 200);
        } elseif (! $user->active_status) {
            $response_data['errors'] = 'Login Denied';
            return response()->json(['data' => $response_data], 403);
        }

        $response_data['errors'] = 'Password mismatch';
        return response()->json(['data' => $response_data], 401);
    }
    public function logout(Request $request) {
        // $token = Auth::user()->token();
        // $token->revoke();
        if ($request->user()) { 
            $request->user()->tokens()->delete();
        }

        $response_data['message'] = 'Logout successful';
        return response()->json(['data' => $response_data], 200);
    }
}
