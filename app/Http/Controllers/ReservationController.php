<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Hebergement;
use Validator;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $authId = auth()->user()->id;
    
        $reservations = Reservation::with('userPropio', 'user', 'hebergement')
            ->where(function ($query) use ($authId) {
                $query->where('id_proprio', $authId)
                      ->orWhere('id_user', $authId);
            })
            ->get()
            ->map(function ($reservation) use ($authId) {
                $reservation['is_owner'] = $reservation->id_proprio === $authId;
    
                // Récupérer les détails de l'hébergement lié à la réservation
                $hebergement = Hebergement::find($reservation->id_hebergement);
                $reservation['hebergement'] = $hebergement;
    
                return $reservation;
            });
    
        return response()->json([
            'status' => 'success',
            'data' => $reservations,
        ]);
    }
    


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_hebergement' => 'required|integer',
            'id_user' => 'required|integer',
            'id_proprio' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'montant' => 'required|numeric',
            'avance' => 'required|numeric',
            'reste' => 'required|numeric',
            'nbre_personne' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $reservation = Reservation::create([
            'id_hebergement' => $request->id_hebergement,
            'id_user' => $request->id_user,
            'id_proprio' => $request->id_proprio,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant' => $request->montant,
            'avance' => $request->avance,
            'reste' => $request->reste,
            'nbre_personne' => $request->nbre_personne,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation created successfully',
            'data' => $reservation,
        ]);
    }

    public function show($id)
    {
        $reservation = Reservation::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $reservation,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_hebergement' => 'required|integer',
            'id_user' => 'required|integer',
            'id_proprio' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'montant' => 'required|numeric',
            'avance' => 'required|numeric',
            'reste' => 'required|numeric',
            'nbre_personne' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $reservation = Reservation::find($id);
        $reservation->id_hebergement = $request->id_hebergement;
        $reservation->id_user = $request->id_user;
        $reservation->id_proprio = $request->id_proprio;
      
            $reservation->date_debut = $request->date_debut;
            $reservation->date_fin = $request->date_fin;
            $reservation->montant = $request->montant;
            $reservation->avance = $request->avance;
            $reservation->reste = $request->reste;
            $reservation->nbre_personne = $request->nbre_personne;
          
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment updated successfully',
            'data' => $payment,
        ]);

    }
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if (!$Reservation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reservation not found',
            ], 400);
        }

        $reservation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation deleted successfully',
            'data' => $reservation,
        ]);
    }
}