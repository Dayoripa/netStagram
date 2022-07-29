@extends('layouts.app')


@section('titulo')
    Crea una nueva publicacion

@endsection

@push('styles')
    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />    
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <form action="{{ route('imagenes.store') }}" method="POST" id="dropzone" enctype="multipart/form-data"
                class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf
            </form>
        </div>
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action=" {{ route('posts.store') }} " method="POST" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold" >
                        Title
                    </label>
                    <input
                        id="titulo"
                        name="titulo"
                        type="text"
                        placeholder="Title of publication"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{ old('titulo') }}"
                    />

                    @error('titulo')  
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> 
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="desripcion" id="descripcion" class="mb-2 block uppercase text-gray-500 font-bold" >
                        Description
                    </label>
                    <textarea
                         id="descripcion"
                         name="descripcion"
                         placeholder="Description of publication"
                         class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        >{{ old('descripcion') }}</textarea>  {{--  Para que no se borre la informacion escrita por el suario en el campo cuando haya un error de validacion --}}

                    @error('descripcion')  
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="mb-5">
                    <input
                        name="imagen" 
                        type="hidden"
                        value="{{ old('imagen') }}"  {{-- Guarda la ultima imagen que sube el usuario  --}}
                      />
                </div>
                @error('imagen')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> 
                @enderror

                <input
                    type="submit"
                    value="Crear Publication"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg "
                />
            </form>
        </div>
    </div>

@endsection