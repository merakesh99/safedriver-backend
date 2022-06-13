<?php

namespace App\Http\Controllers;

use App\Mail\SleepyState;
use App\Models\Driver;
use App\Models\Entry;
use App\Models\User;
use App\Notifications\Drowsiness;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{

    public function index()
    {
        $entries = Entry::latest()->with('car', 'driver')->get();
        $response_data['message'] = 'Success';
        $response_data['entries'] = $entries;
        return response()->json(['data' => $response_data], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'status' => ['string'],
            'car_id'   => ['required', 'exists:cars,id'],
            'driver_id'   => ['required', 'exists:drivers,id']
        ], [
            'driver_id.required'    => 'The driver field is required.',
            'driver_id.exists'      => 'The driver does not exists.',
            'car_id.required'    => 'The car field is required.',
            'car_id.exists'      => 'The car does not exists.'
        ]);


        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }


        $entry = Entry::create([
            'car_id' => $request['car_id'],
            'driver_id' => $request['driver_id'],
            'status' => $request['status'] ?? 0,

        ]);
        $response_data['message'] = 'Created';
        $response_data['entry'] = $entry;
        return response()->json(['data' => $response_data], 201);
    }

    public function show(Entry $entry)
    {
        //
    }

    public function edit(Entry $entry)
    {
        //
    }

    public function update(Request $request, Entry $entry)
    {


        //
    }

    public function destroy(Entry $entry)
    {
        //
    }
    public function sleepalert(Entry $entry)
    {
        $users = User::where('profile_type', 'App\Models\Admin')->orWhere('profile_type', 'App\Models\Manager')->pluck('email');
        $entries = Entry::where('status',2)->pluck('driver_id');
        //$driver = Driver::where('id',$entries[0])->pluck('email');
        $value = Entry::where('status','2')->pluck('driver_id')->all();
        $myval = Entry::where('status','2')->join('drivers', 'entries.driver_id', '=', 'drivers.id')->join('cars', 'entries.car_id' , '=' , 'cars.id')->get();
        $name = $myval->pluck('name');
        $vehicle = $myval->pluck('vehicle_no');
        if($value != []){
            $title = 'Sleep ALERT !! from SafeDriver';
            Mail::to($users)->send(new SleepyState($title,$entries,$name,$vehicle));
            return response()->json(['success' => 'Send email successfully.']);
        }
        //Mail::to($request->user())->cc($moreUsers)->bcc($evenMoreUsers)->; 
        // Notification::send($users, new Drowsiness($entries));
        return response()->json(['success' => 'Nothing']);
    }
    public function drowsy(Entry $entry){
        $users = User::where('profile_type', 'App\Models\Admin')->get();
        $entries = Entry::where('status',1)->pluck('driver_id');
        Notification::send($users, new Drowsiness($entries));
    }
}
