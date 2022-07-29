<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);


        //Almacenar comentario
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Imprimir comentario
        return back()->with('mensaje', 'comentario agregado correctamente');
        //back() Es para devolver al usuario a la pagina desde donde hizo la solicitud
        // with Es para imprimir un mensaje. para que funcione se debe agregar la directiva @if (session('') en blade.php
    }
}
