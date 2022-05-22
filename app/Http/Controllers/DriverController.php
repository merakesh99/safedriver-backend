<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeRegisterMail;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::all();
        $response_data['message'] = 'Success';
        $response_data['drivers'] = $drivers;
        return response()->json(['data' => $response_data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email:rfc,dns', 'unique:drivers'],
            'dob'     => ['required', 'date_format:Y-m-d', 'before:2004-01-01'],
            'phoneno' => ['required', 'unique:drivers', 'digits:10'],
            'gender'  => ['required', 'string'],
            'licence_no'  => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }
        $token = Str::random(10);
        $driver = Driver::create([
            'name'              => $request['name'],
            'email'             => $request['email'],
            'dob'               => $request['dob'],
            'phoneno'           => $request['phoneno'],
            'gender'            => $request['gender'],
            'licence_no'        => $request['licence_no'],
            'token'             => $token,
        ]);
        $title = '[SafeDriver] Welcome mail';
        Mail::to($request['email'])->send(new WelcomeRegisterMail($title, $token, $driver['name']));

        $response_data['message'] = 'Welcome mail sent on your email id.';
        return response()->json(['data' => $response_data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
