@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container mt-5">
    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login.web') }}">
        @csrf

        <div class="mb-3">
            <label>Email ou numéro</label>
            <input type="text" 
                   name="login" 
                   class="form-control" 
                   placeholder="Email ou numéro"
                   required>
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" 
                   name="password" 
                   class="form-control"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">
            Se connecter
        </button>

        @if ($errors->any())
            <div class="text-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif
    </form>
</div>
@endsection