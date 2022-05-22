<?php
namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Lib;
use App\Models\Manager;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function create_user(Request $request) {
        // validate incoming request
        $validate_request = Validator::make($request->all(), [
            'token'     => ['required', 'string', 
                function ($attribute, $value, $fail) {
                    if (!DB::table('drivers')->where($attribute, $value)->exists() &&
                        !DB::table('managers')->where($attribute, $value)->exists()
                    ) {
                        return $fail("The provided $attribute does not exists.");
                    }
                    
                }
            ],
            'password'  => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        if($validate_request->fails()) {
            $response_data['errors'] = $validate_request->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        if($driver = Driver::where('token', $request['token'])->first()) {
            // if the user is an driver
            $driver->user()->create([
                'email'     => $driver->email,
                'password'  => Hash::make($request['password']),
            ]);
            $driver->token = NULL;
            $driver->save();
        } 
        elseif($manager = Manager::where('token', $request['token'])->first()) {
            // if the user is an manager
            $manager->user()->create([
                'email'     => $manager->email,
                'password'  => Hash::make($request['password']),
            ]);
            $manager->token = NULL;
            $manager->save();
        } 
        
        // elseif($expert = Expert::where('token', $request['token'])->first()) {
        //     // if the user is an expert
        //     // check whether profile is approved or not
        //     if($expert->reviewer_id && empty($expert->remarks)) {
        //         $expert->user()->create([
        //             'email'     => $expert->email,
        //             'password'  => Hash::make($request['password']),
        //         ]);
        //         $expert->token = NULL;
        //         $expert->wallet = 0.00;
        //         $expert->save();
        //     } else {
        //         $response_data['errors'] = 'Expert is yet to be approved';
        //         return response()->json(['data' => $response_data], 400);    
        //     }
        // } elseif($distributor = Distributor::where('token', $request['token'])->first()) {
        //     // if the user is a distributor
        //     $distributor->user()->create([
        //         'email'     => $distributor->email,
        //         'password'  => Hash::make($request['password']),
        //     ]);
        //     $distributor->token = NULL;
        //     $distributor->save();
        // } elseif($customer = Customer::where('token', $request['token'])->first()) {
        //     // if the user is a customer
        //     $customer->user()->create([
        //         'email'     => $customer->email,
        //         'password'  => Hash::make($request['password']),
        //     ]);
        //     $customer->token = NULL;
        //     $customer->save();
        // } 
        else {
            $response_data['errors'] = 'Invalid request';
            return response()->json(['data' => $response_data], 400);
        } 

        $response_data['message'] = 'User Created Successfully';
        return response()->json(['data' => $response_data], 201);
    }
    
}
