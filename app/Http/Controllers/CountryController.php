<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Validator;

class CountryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index()
    {
        $countries = Country::all();
        return response()->json([
            'status' => 'success',
            'data' => $countries,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'indicatif_tel' => 'required|string|max:10',
            'status' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $country = Country::create([
            'nom' => $request->nom,
            'code' => $request->code,
            'indicatif_tel' => $request->indicatif_tel,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Country created successfully',
            'data' => $country,
        ]);
    }

    public function show($id)
    {
        $country = Country::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $country,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'indicatif_tel' => 'required|string|max:10',
            'status' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $country = Country::find($id);
        $country->nom = $request->nom;
        $country->code = $request->code;
        $country->indicatif_tel = $request->indicatif_tel;
        $country->status = $request->status;
        $country->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Country updated successfully',
            'data' => $country,
        ]);
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if(!$country){
            return response()->json([
                'status' => 'error',
                'message' =>'Country not found'
            ], 404);
        }

        $country->delete();
     
        return response()->json([
            'status' => 'success',
            'message' => 'Country deleted successfully',
            'data' => $country,
        ]);
    }
}
