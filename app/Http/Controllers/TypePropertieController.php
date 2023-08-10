<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypePropertie;
use Validator;

class TypePropertieController extends Controller
{
    public function index()
    {
        $typeProperties = TypePropertie::all();
        return response()->json([
            'status' => 'success',
            'data' => $typeProperties,
        ]);
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string|max:255',
            'status' => 'required|string|max:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $typePropertie = TypePropertie::create([
            'libelle' => $request->libelle,
            'status' => $request->status,
        ]);
        // dd($typePropertie);
        return response()->json([
            'status' => 'success',
            'message' => 'typePropertie created successfully',
            'data' => $typePropertie,
        ]);
    }

    public function show($id)
    {
        $typePropertie = TypePropertie::find($id);

        if (!$typePropertie) {
            return response()->json([
                'status' => 'error',
                'message' => 'typePropertie not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $typePropertie,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $typePropertie = TypePropertie::find($id);

        if (!$typePropertie) {
            return response()->json([
                'status' => 'error',
                'message' => 'typePropertie not found',
            ], 404);
        }

        $typePropertie->libelle = $request->libelle;
        $typePropertie->status = $request->status;
        $typePropertie->save();

        return response()->json([
            'status' => 'success',
            'message' => 'typePropertie updated successfully',
            'data' => $typePropertie,
        ]);
    }

    public function destroy($id)
    {
        $typePropertie = TypePropertie::find($id);

        if (!$typePropertie) {
            return response()->json([
                'status' => 'error',
                'message' => 'typePropertie not found',
            ], 404);
        }

        $typePropertie->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'typePropertie deleted successfully',
            'data' => $typePropertie,
        ]);
    }
}
