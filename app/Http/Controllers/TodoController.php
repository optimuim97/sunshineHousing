<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Validator;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $todos = Todo::all();
        return response()->json([
            'status' => 'success',
            'data' => $todos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo created successfully',
            'data' => $todo,
        ]);
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $todo,
        ]);
    }

    public function update(Request $request, $id)
    {
       
      $validator=Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);
      

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
            'message' => $validator->errors()->toJson()
        ], 400);
        }
        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo updated successfully',
            'data' => $todo,
        ]);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        if(!$todo){
            return response()->json([
                'status' => 'error',
            'message' =>'todo error'
        ], 400);
    }
        $todo->delete();
     
        return response()->json([
            'status' => 'success',
            'message' => 'Todo deleted successfully',
            'data' => $todo,
        ]);
    }
}