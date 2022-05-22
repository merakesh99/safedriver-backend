<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
        $response_data['message'] = 'Success';
        $response_data['cars'] = $cars;
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
        $data = $request->validate([
            'vehicle_no' => ['required', 'string','unique:cars'],
            'model_no' => ['required', 'string'],
            'manufacture_year' => ['required', 'integer'],
            'manufacture_company' => ['required', 'string'],
            'color' => ['required', 'string'],
            'image_file' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
            
        ]);
        $directory_image_file = 'assets/uploads/carimages';
        File::isDirectory($directory_image_file) or File::makeDirectory($directory_image_file, 0777, true, true);
        $image_file = $data['image_file'];
        $filename = 'image' . '_' . Carbon::now()->timestamp . '.' . $image_file->getClientOriginalExtension();
        $image_file->move($directory_image_file, $filename);
        $data['image_file'] = $filename;
        $car = Car::create($data);
        // return redirect()->back();
        $response_data['message'] = 'Created';
        $response_data['car'] = $car;
        return response()->json(['data' => $response_data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directory_image_file = 'assets/uploads/carimages';
        $car = Car::find($id);
        File::delete(public_path($directory_image_file . '/' . $car->image_file));
        $car->delete($id);
        $response_data['message'] = 'Car Deleted';
        return response()->json(['data' => $response_data], 200);
    }
}
