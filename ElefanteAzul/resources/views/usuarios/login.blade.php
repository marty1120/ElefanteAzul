@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Login</h2>
    <form action="{{ route('usuarios.authenticate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" name="username" class="form-control" placeholder="Usuario" value="{{ old('username') }}">
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" value="{{ old('password') }}">
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <hr>
    <a href="{{ route('google.login') }}" class="btn btn-danger">Identifícate con Google</a>
    @error('google')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
@endsection
