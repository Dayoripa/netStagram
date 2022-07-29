<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request);
       // dd($request->get('username')); para mirar que informacion tienen los campos del formulario se utliza el nombre que tiene el name en el formulario.
     
       //Modificar el Request
       $request->request->add(['username'=> Str::slug($request->username)]);
       
       // VALIDACION DE LOS CAMPOS DEL FORMULARIO
       $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'username' => 'required|unique:users|min:3|max:40',
            'email' => 'required|unique:users|email|max:50',
            'password' => 'required|confirmed|min:6'
       ]);

       //Crear nuevo registro
       User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
       ]);

       //Auenticar Usuario
    //    auth()->attempt([
    //     'email' => $request->email,
    //     'password' => $request->password
    //    ]);


        //OTRA FORMA DE AUTENTICAR USUARIO
        Auth()->attempt($request->only('email', 'password'));

        //Redirecionar al usuario una vez se registre
        return redirect()->route('posts.index', auth()->user()->username);       

    }

}
