<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file'); // imagen que esta en memoria


        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = Image::make($imagen); // se pasa la imagen para ser procesada por la ibreria intervention
        $imagenServidor->fit(1000, 1000); // tamaño de la imagen y si es mas grande la corta en el centro

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; // crea una ruta para la imagen y tambien un nombre
        $imagenServidor->save($imagenPath); // guarda la imagen y la ruta

        return response()->json(['imagen' => $nombreImagen ]);
    }
}
