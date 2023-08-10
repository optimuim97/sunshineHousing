<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// use Validator;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        // $validator = Validator::make($request->all(), [       
        //     'name' => 'required|string|max:255',
        //     'telephone' => 'required|string|max:255',
        //     'birthday' => 'required|string|max:255',
        //     'type_compte' => 'required|string|max:255',
        //     'id_pays' => 'required|string,max:225',
        //     'ville' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:100|unique:users',
        //     'password' => 'required|string|confirmed|min:6',
        // ]);
        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'telephone' => 'required',
            'birthday' => 'required',
            'type_compte' => 'required',
            'id_pays' => 'required',
            'ville' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'data' => $user
        ], 201);
    }
    
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire de modification
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'birthday' => 'required|date',
            'ville' => 'required|string|max:255',
            // Ajoutez ici les autres règles de validation pour les autres champs
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        // Rechercher l'utilisateur à mettre à jour
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur introuvable.',
            ], 404);
        }

        // Mettre à jour les informations de l'utilisateur
        $user->update($request->only([
            'name',
            'telephone',
            'birthday',
            'ville',
            // Ajoutez ici les autres champs que vous souhaitez mettre à jour
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur mis à jour avec succès.',
            'data' => $user,
        ]);
    }
//     /**
//  * Update a User.
//  *
//  * @param  \Illuminate\Http\Request  $request
//  * @param  int  $id
//  * @return \Illuminate\Http\JsonResponse
//  */
// public function update(Request $request, $id) {
//     $user = User::find();
//     if (!$user) {
//         return response()->json([
//             'message' => 'User not found'
//         ], 404);
//     }
//     $validator = Validator::make($request->all(), [       
//         'name' => 'string|between:2,100',
//         'telephone' => 'integer|string,20',
//         'birthday' => 'string|between:2,100',
//         'type_compte' => 'string,100',
//         'id_pays' => 'integer,100',
//         'ville' => 'string,100',
//         'email' => 'string|email|max:100|unique:users,email,' . $user->id,
//         'password' => 'string|confirmed|min:6',
//     ]);
//     if($validator->fails()){
//         return response()->json($validator->errors()->toJson(), 400);
//     }
//     $user->update(array_filter($validator->validated()));
//     return response()->json([
//         'message' => 'User successfully updated',
//         'user' => $user
//     ], 200);
// }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {

        if(auth()->user() == null){
            return response()->json(null, 401);
        }

        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 360000,
            'user' => auth()->user()
        ]);
    }
}