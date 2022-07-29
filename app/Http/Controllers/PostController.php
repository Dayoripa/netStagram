<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        // Para proteger las rutas y que los usuarios deban estar autenticados para poder acceder a ellas
        $this->middleware('auth')->except(['show', 'index']);
        //->except(['show']) Es para indicar que la ruta show no necesita estar protegida y los usuarios si puedan
        //acceder a ella sin estar autenticados.
    }

    public function index(User $user)
    {
        // filtra por el id ( donde user:id = user id)  y luego se pagina con la funcion paginate()
        $posts = Post::where('user_id', $user->id)->latest()->paginate(10);
        //dd($posts);

       return view('dashboard', [
            'user' => $user,  // pasamos el user a la vista dashboard
            'posts' => $posts  // pasamos los posts a la vista dashboard
       ]);
    }

    public function create()
    {
       return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // AGREGAR REGISTRO A LA BD
        // Primera forma de agregar registros a la BD

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Segunda forma de agregar registros a la BD

        // $post = new Post;
        // $post-> titulo = $request->titulo;
        // $post-> descripcion = $request->descripcion;
        // $post-> imagen = $request-> imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

         // Tercera forma de agregar registros a la BD
            $request->user()->posts()->create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'imagen' => $request->imagen,
                'user_id' => auth()->user()->id
            ]);

         // Para redireccionar al usuario a su muro
         return redirect()->route('posts.index', auth()->user()->username); 
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        //Eliminar el post
       $this->authorize('delete', $post);
       $post->delete();

       //Elliminar la imagen
       $imagen_path = public_path('uploads/' . $post->imagen);

       if(File::exists($imagen_path)){
            unlink($imagen_path);
       }

       return redirect()->route('posts.index', auth()->user()->username);
    }
}
