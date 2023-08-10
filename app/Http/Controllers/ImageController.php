<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Hebergement;

class ImageController extends Controller
{
    public function store(Request $request)
    {       $image = new Image;
        // $image->file_url = $request->file_url->store('images');
         $image->type_file = $request->type_file;
        $image->id_user = $request->id_user;
        $image->id_hebergement = $request->id_hebergement;
        $image->file_url = $request->file_url->store('images');

        $image->status = $request->status;
        $image->save();

        return response()->json(['message' => 'Image saved successfully', 'image' => $image], 201);
        // $validatedData = $request->validate([
        //     'file_url' => 'required',
        //     'type_file' => 'required',
        //     'id_user' => 'required',
        //     'id_hebergement' => 'required',
        //     'status' => 'required',
        // ]);

        // $image = Image::create($validatedData);

        // return response()->json(['message' => 'Image created successfully', 'image' => $image], 201);
    }

    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        if ($request->hasFile('file_url')) {
            $image->file_url = $request->file_url->store('images');
        }
        $image->type_file = $request->type_file;
        $image->id_user = $request->id_user;
        $image->id_hebergement = $request->id_hebergement;
        $image->status = $request->status;
        $image->save();

        return response()->json(['message' => 'Image updated successfully', 'image' => $image], 200);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }

    public function getImageHebergement($id)
    {
        $hebergement = Hebergement::findOrFail($id);
        $images = $hebergement->images;

        return response()->json(['hebergement' => $hebergement, 'images' => $images], 200);
    }
}




