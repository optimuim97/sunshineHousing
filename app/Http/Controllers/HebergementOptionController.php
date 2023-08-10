<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HebergementOption;
use Validator;

class HebergementOptionController extends Controller
{
    public function index()
    {
        $hebergementOptions = HebergementOption::all();
        return response()->json([
            'status' => 'success',
            'data' => $hebergementOptions,
        ]);
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'hebergement_id' => 'required|string|max:255',
            'commodite_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $hebergementOption = HebergementOption::create([
            'hebergement_id' => $request->hebergement_id,
            'commodite_id' => $request->commodite_id,
        ]);
        // dd($hebergementOption);
        return response()->json([
            'status' => 'success',
            'message' => 'hebergementOption created successfully',
            'data' => $hebergementOption,
        ]);
    }

    public function show($id)
    {
        $hebergementOption = HebergementOption::find($id);

        if (!$hebergementOption) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergementOption not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $hebergementOption,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hebergement_id' => 'required|string|max:255',
            'commodite_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $hebergementOption = HebergementOption::find($id);

        if (!$hebergementOption) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergementOption not found',
            ], 404);
        }

        $hebergementOption->hebergement_id = $request->hebergement_id;
        $hebergementOption->commodite_id = $request->commodite_id;
        $hebergementOption->save();

        return response()->json([
            'status' => 'success',
            'message' => 'hebergementOption updated successfully',
            'data' => $hebergementOption,
        ]);
    }

    public function destroy($id)
    {
        $hebergementOption = HebergementOption::find($id);

        if (!$hebergementOption) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergementOption not found',
            ], 404);
        }

        $hebergementOption->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'hebergementOption deleted successfully',
            'data' => $hebergementOption,
        ]);
    }
}
