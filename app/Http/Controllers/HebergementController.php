<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hebergement;
use App\Models\Image;
use App\Models\Commodite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class HebergementController extends Controller
{

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $hebergements = Hebergement::with('images', 'commodite', 'user')->get();

        return response()->json([
            'status' => 'success',
            'data' => $hebergements,
        ]);
    }

    public function getByUserId()
    {
        $userId = Auth::id();

        if($userId == null){
            return response()->json([
                'status' => 'error',
                'message' => "user not auth"
            ], 400);
        }

        $hebergements = Hebergement::with('images', 'commodite', 'user')
            ->where('id_user', $userId)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $hebergements,
        ]);
    }

    public function getByTypeLogement($typeLogement)
    {

        $hebergements = Hebergement::with('images', 'commodite', 'user')
            ->where('type_logement', $typeLogement)
            ->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $hebergements,
        ]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'type_logement' => 'required',
            'categorie' => 'required',
            'ville' => 'required',
            'commune' => 'required',
            'description' => 'required',
            'adresse' => 'required',
            'id_user' => 'required',
            'date_disponibilite' => 'required',
            'nbre_personne' => 'required',
            'nbre_lit' => 'required',
            'nbre_sale_bain' => 'required',
            'prix' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $hebergement = Hebergement::create([
            'titre' => $request->titre,
            'type_logement' => $request->type_logement,
            'categorie' => $request->categorie,
            'ville' => $request->ville,
            'commune' => $request->commune,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'id_user' => $request->id_user,
            'date_disponibilite' => $request->date_disponibilite,
            'nbre_personne' => $request->nbre_personne,
            'nbre_lit' => $request->nbre_lit,
            'nbre_sale_bain' => $request->nbre_sale_bain,
            'prix' => $request->prix,
            'lat' => $request->lat,
            'long' => $request->long,
            'status' => $request->status
        ]);

        $image = new Image;
        $image->type_file = 'post';
        $image->id_user = $request->id_user;
        $image->id_hebergement = $hebergement->id;
        $image->file_url = $request->file('file_url')->store('images');
        $image->status = $request->status;
        $image->save();

        $filename = Storage::putFile(
            'public/images',
            $request->file('file_url')
        );
        
        
        $image->file_url = $filename;

        // $commodite = Commodite::create([
        //     'wifi' => $request->wifi,
        //     'parking' => $request->parking,
        //     'tv' => $request->tv,
        //     'frigo' => $request->frigo,
        //     'clim' => $request->clim,
        //     'gardien' => $request->gardien,
        //     'id_hebergement' => $hebergement->id
        // ]);
        // dd($hebergement);
        return response()->json([
            'status' => 'success',
            'message' => 'hebergement created successfully',
            'data' => $hebergement,
            'image' => $image,
            // 'commodite' => $commodite,
        ]);
    }

    public function show($id)
    {
        $hebergement = Hebergement::find($id);

        if (!$hebergement) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergement not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $hebergement,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'type_logement' => 'required',
            'categorie' => 'required',
            'ville' => 'required',
            'commune' => 'required',
            'description' => 'required',
            'adresse' => 'required',
            'id_user' => 'required',
            'date_disponibilite' => 'required',
            'nbre_personne' => 'required',
            'nbre_lit' => 'required',
            'nbre_sale_bain' => 'required',
            'prix' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 400);
        }

        $hebergement = Hebergement::find($id);

        if (!$hebergement) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergement not found',
            ], 404);
        }

        $hebergement->titre = $request->titre;
        $hebergement->type_logement = $request->type_logement;
        $hebergement->categorie = $request->categorie;
        $hebergement->ville = $request->ville;
        $hebergement->commune = $request->commune;
        $hebergement->description = $request->description;
        $hebergement->adresse = $request->adresse;
        $hebergement->id_user = $request->id_user;
        $hebergement->date_disponibilite = $request->date_disponibilite;
        $hebergement->nbre_personne = $request->nbre_personne;
        $hebergement->nbre_sale_bain = $request->nbre_sale_bain;
        $hebergement->prix = $request->prix;
        $hebergement->lat = $request->lat;
        $hebergement->long = $request->long;
        $hebergement->status = $request->status;
        $hebergement->save();

        return response()->json([
            'status' => 'success',
            'message' => 'hebergement updated successfully',
            'data' => $hebergement,
        ]);
    }

    public function destroy($id)
    {
        $hebergement = Hebergement::find($id);

        if (!$hebergement) {
            return response()->json([
                'status' => 'error',
                'message' => 'hebergement not found',
            ], 404);
        }

        $hebergement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'hebergement deleted successfully',
            'data' => $hebergement,
        ]);
    }
}
