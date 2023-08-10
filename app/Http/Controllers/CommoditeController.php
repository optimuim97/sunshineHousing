<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commodite;
use Validator;

class CommoditeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $commodites = Commodite::all();
        return response()->json([
            'status' => 'success',
            'data' => $commodites,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'wifi' => 'required|string|max:255',
            'parking' => 'required|string|max:255',
            'tv' => 'required|string|max:255',
            'frigo' => 'required|string|max:255',
            'clim' => 'required|string|max:255',
            'gardien' => 'required|string|max:255',
        ]);

        $commodite = Commodite::create([
            'wifi' => $request->wifi,
            'parking' => $request->parking,
            'tv' => $request->tv,
            'frigo' => $request->frigo,
            'clim' => $request->clim,
            'gardien' => $request->gardien,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Commodite created successfully',
            'data' => $commodite,
        ]);
    }

    public function show($id)
    {
        $commodite = Commodite::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $commodite,
        ]);
    }

    public function update(Request $request, $id)
    {
       
      $validator=Validator::make($request->all(), [
        'wifi' => 'required|string|max:255',
        'parking' => 'required|string|max:255',
        'tv' => 'required|string|max:255',
        'frigo' => 'required|string|max:255',
        'clim' => 'required|string|max:255',
        'gardien' => 'required|string|max:255',
    ]);
      

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
            'message' => $validator->errors()->toJson()
        ], 400);
        }
        $commodite = Commodite::find($id);
        $commodite->wifi = $request->wifi;
        $commodite->parking = $request->parking;
        $commodite->tv = $request->tv;
        $commodite->frigo = $request->frigo;
        $commodite->clim = $request->clim;
        $commodite->gardien = $request->gardien;
        $commodite->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Commodite updated successfully',
            'data' => $commodite,
        ]);
    }

    public function destroy($id)
    {
        $commodite = Commodite::find($id);
        if(!$commodite){
            return response()->json([
                'status' => 'error',
            'message' =>'commodite error'
        ], 400);
    }
        $commodite->delete();
     
        return response()->json([
            'status' => 'success',
            'message' => 'commodite deleted successfully',
            'data' => $commodite,
        ]);
    }
}