<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function register_user(Request $request) {
        $validate_request = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'max:100'],
        ]);

        if($validate_request->fails()) {
            $response_data['errors'] = $validate_request->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        

        $super_admin = Admin::create([
            'name'         => $request['name'],
            'email'        => $request['email'],
            'password'     => Hash::make($request['password']),
        ]);

        $super_admin->user()->create([
            'email'     => $request['email'],
            'password'  => Hash::make($request['password']),
        ]);

        $response_data['message'] = 'Created Successfully!';
        return response()->json(['data' => $response_data], 201);
    }
}
