<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $userId = Auth::id();
    
        // Récupérer les paiements de l'utilisateur authentifié
        $payments = Payment::where('id_user', $userId)->get();
    
        // Récupérer les détails des réservations associées à chaque paiement
        foreach ($payments as $payment) {
            $payment->load('reservation');
        }
    
        return response()->json([
            'status' => 'success',
            'data' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_type_payment' => 'required|integer',
            'id_commande' => 'required|integer',
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'id_user' => 'required|integer',
            'status' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson(),
            ], 400);
        }

        $payment = Payment::create([
            'id_type_payment' => $request->id_type_payment,
            'id_commande' => $request->id_commande,
            'montant' => $request->montant,
            'date' => $request->date,
            'id_user' =>  Auth::id(),
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment created successfully',
            'data' => $payment,
        ]);
    }

    public function show($id)
    {
        $payment = Payment::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $payment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_type_payment' => 'required|integer',
            'id_commande' => 'required|integer',
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'id_user' => 'required|integer',
            'status' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson(),
            ], 400);
        }

        $payment = Payment::find($id);
        $payment->id_type_payment = $request->id_type_payment;
        $payment->id_commande = $request->id_commande;
        $payment->montant = $request->montant;
        $payment->date = $request->date;
        $payment->id_user = $request->id_user;
        $payment->status = $request->status;
        $payment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment updated successfully',
            'data' => $payment,
        ]);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found',
            ], 400);
        }

        $payment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment deleted successfully',
            'data' => $payment,
        ]);
    }
}
