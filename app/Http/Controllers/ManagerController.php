<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeRegisterMail;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $managers = Manager::orderBy('name')->get();
        $response_data['message'] = 'Success';
        $response_data['managers'] = $managers;
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
            'email'   => ['required', 'email:rfc,dns', 'unique:managers'],
            'dob'     => ['required', 'date_format:Y-m-d', 'before:2004-01-01'],
            'phoneno' => ['required', 'unique:managers', 'digits:10'],
            'gender'  => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }
        $token = Str::random(10);
        $manager = Manager::create([
            'name'              => $request['name'],
            'email'             => $request['email'],
            'dob'               => $request['dob'],
            'phoneno'           => $request['phoneno'],
            'gender'            => $request['gender'],
            'token'             => $token,
        ]);
        $title = '[SafeDriver] Welcome mail';
        Mail::to($request['email'])->send(new WelcomeRegisterMail($title, $token, $manager['name']));

        $response_data['message'] = 'Welcome mail sent on your email id.';
        return response()->json(['data' => $response_data], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        //
    }
}
