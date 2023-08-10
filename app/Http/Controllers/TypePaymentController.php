<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypePayment;
use Validator;

class TypePaymentController extends Controller
{
    public function index()
    {
        $paiements = TypePayment::all();
        return response()->json([
            'status' => 'success',
            'data' => $paiements,
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

        $paiement = TypePayment::create([
            'libelle' => $request->libelle,
            'status' => $request->status,
        ]);
        // dd($paiement);
        return response()->json([
            'status' => 'success',
            'message' => 'Paiement created successfully',
            'data' => $paiement,
        ]);
    }

    public function show($id)
    {
        $paiement = TypePayment::find($id);

        if (!$paiement) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paiement not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $paiement,
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

        $paiement = TypePayment::find($id);

        if (!$paiement) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paiement not found',
            ], 404);
        }

        $paiement->libelle = $request->libelle;
        $paiement->status = $request->status;
        $paiement->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Paiement updated successfully',
            'data' => $paiement,
        ]);
    }

    public function destroy($id)
    {
        $paiement = TypePayment::find($id);

        if (!$paiement) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paiement not found',
            ], 404);
        }

        $paiement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Paiement deleted successfully',
            'data' => $paiement,
        ]);
    }
}
