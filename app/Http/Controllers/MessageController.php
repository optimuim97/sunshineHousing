<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;
use App\Models\MessageList;
use App\Models\MessageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
 
    public function index()
    {
        $user = Auth::user();
    
        $messages = MessageList::where('id_user_customer', $user->id)
            ->orWhere('id_user_proprio', $user->id)
            ->orderBy('date', 'desc')
            ->with(['customer', 'proprio', 'details.sender']) // Inclure les détails des utilisateurs et des messages
            ->get();
    
        // Créer un tableau pour stocker les messages avec les détails des utilisateurs
        $formattedMessages = [];
    
        foreach ($messages as $message) {
            // Récupérer les détails des utilisateurs associés au message
            $customer = $message->customer;
            $proprio = $message->proprio;
    
            // Récupérer le dernier message de la conversation
            $latestMessage = $message->details->last();
    
            // Récupérer les détails de l'expéditeur du dernier message
            $latestMessageSender = $latestMessage ? $latestMessage->sender : null;
    
            // Formater la date en "heure", "jour", "mois", "minute" ou "seconde"
            $formattedDate = $message->date;
            $diffInSeconds = now()->diffInSeconds($formattedDate);
            $diffInMinutes = now()->diffInMinutes($formattedDate);
            $diffInHours = now()->diffInHours($formattedDate);
            $diffInDays = now()->diffInDays($formattedDate);
            $diffInMonths = now()->diffInMonths($formattedDate);
    
            if ($diffInSeconds < 60) {
                $formattedDate = $diffInSeconds . ' seconde' . ($diffInSeconds > 1 ? 's' : '') . ' ago';
            } elseif ($diffInMinutes < 60) {
                $formattedDate = $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' ago';
            } elseif ($diffInHours < 24) {
                $formattedDate = $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '') . ' ago';
            } elseif ($diffInDays < 30) {
                $formattedDate = $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '') . ' ago';
            } else {
                $formattedDate = $diffInMonths . ' mois' . ($diffInMonths > 1 ? 's' : '') . ' ago';
            }
    
            // Créer un tableau avec les informations des utilisateurs et du message
            $formattedMessage = [
                'id' => $message->id,
                'id_user_customer' => $message->id_user_customer,
                'id_user_proprio' => $message->id_user_proprio,
                'date' => $formattedDate,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
                'customer' => $customer,
                'proprio' => $proprio,
                'latest_message' => $latestMessage,
                'latest_message_sender' => $latestMessageSender,
            ];
    
            // Ajouter le message formaté au tableau
            $formattedMessages[] = $formattedMessage;
        }
    
        return response()->json([
            'status' => 'success',
            'data' => $formattedMessages,
        ]);
    }
    
    
    
            // ...
        
        
    

            public function store(Request $request)
            {
                $user = Auth::user();
                $id_user_proprio = $request->input('id_user_proprio');
            
                // Vérifier si une conversation existe déjà entre l'utilisateur connecté et le propriétaire donné
                $existingConversation = MessageList::where(function ($query) use ($user, $id_user_proprio) {
                    $query->where('id_user_customer', $user->id)
                        ->where('id_user_proprio', $id_user_proprio);
                })->orWhere(function ($query) use ($user, $id_user_proprio) {
                    $query->where('id_user_customer', $id_user_proprio)
                        ->where('id_user_proprio', $user->id);
                })->first();
            
                if ($existingConversation) {
                    // Une conversation existe déjà, renvoyer la conversation existante
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Conversation already exists',
                        'data' => $existingConversation,
                    ]);
                }
            
                // Aucune conversation existante, créer une nouvelle conversation
                $messageList = MessageList::create([
                    'id_user_customer' => $user->id,
                    'id_user_proprio' => $id_user_proprio,
                    'date' => now()
                ]);
            
                $messageDetail = MessageDetail::create([
                    'id_message_list' => $messageList->id,
                    'id_user_send' => $user->id,
                    'message' => $request->input('message')
                ]);
            
                return response()->json([
                    'status' => 'success',
                    'message' => 'Conversation created successfully',
                    'data' => $messageList,
                ]);
            }
            

    public function show(MessageList $messageList)
    {
        $user = Auth::user();
    
        if ($user->id !== $messageList->id_user_customer && $user->id !== $messageList->id_user_proprio) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $details = $messageList->details()->with('sender')->orderBy('created_at', 'asc')->get();
    
        // Récupérer les détails des utilisateurs associés à la conversation
        $customer = $messageList->customer()->first();
        $proprio = $messageList->proprio()->first();
    
        return response()->json([
            'status' => 'success',
            'messageList' => $messageList,
            'customer' => $customer,
            'proprio' => $proprio,
            'details' => $details,
        ]);
    }
    
    

    public function reply(Request $request, MessageList $messageList)
    {
        // Valider le formulaire et enregistrer la réponse dans la base de données
        $user = Auth::user();
        // $request->validate([
        //     'message' => 'required|string|max:1000'
        // ]);

        $messageDetail = MessageDetail::create([
            'id_message_list' => $messageList->id,
            'id_user_send' => $user->id,
            'message' => $request->input('message')
        ]);

        return response()->json([
            'status' => 'success','data'=>$messageDetail]);
    }
}

