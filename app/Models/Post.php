<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    // Estos se debe hacer para que laravel sepa cual es la informacion que se debe guardar en la BD.
    // Es la manera como este framework protege la informacion.
     protected $fillable = [
         'titulo',
         'descripcion',
         'imagen',
         'user_id'
     ];

     // Crear relaion de uno a muchos (belongs To)
     // Relacion: post a user (muchos a uno)
     public function user()
     {
        return $this->belongsTo(User::class)->select(['name', 'username']);
        // ['name', 'username'] para indicar que solo queremos consultar los campos name y username
       // Si queremos que nos devuelva la informacion de todos los campos entonces se deja sin el array de parametros
     }

     public function comentarios()
     {
        return $this->hasMany(Comentario::class);
     }

     public function likes()
     {
        return $this->hasMany(Like::class);
     }

     public function checkLike(User $user)
     {
        // Revisa si en la tabla likes contiene una columna con el usuario_id de determinado post
        return $this->likes->contains('user_id', $user->id);
     }
   
}
