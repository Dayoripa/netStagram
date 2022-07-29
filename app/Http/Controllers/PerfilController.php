<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
       return view('perfiles.index');
    }

    public function store(Request $request)
    {
       
        //Modificar el Request
       $request->request->add(['username' => Str::slug($request->username)]);

       $this->validate($request, [
            'username' => ['required', 'unique:users,username,' .auth()->user()->id, 'min:3', 'max:20', 'not_in:twiter,editar-perfil'],
       ]);

       if($request->imagen){
            $imagen = $request->file('imagen'); // imagen que esta en memoria


            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen); // se pasa la imagen para ser procesada por la ibreria intervention
            $imagenServidor->fit(1000, 1000); // tamaño de la imagen y si es mas grande la corta en el centro

            $imagenPath = public_path('perfil') . '/' . $nombreImagen; // crea una ruta para la imagen y tambien un nombre
            $imagenServidor->save($imagenPath); // guarda la imagen y la ruta

        }
            //Guardar cambios
            $usuario = User::find(auth()->user()->id);
            $usuario ->username = $request->username;
            $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
            $usuario->save();

            //Redireccionar
            return redirect()->route('posts.index', $usuario->username);
       
    }
}
