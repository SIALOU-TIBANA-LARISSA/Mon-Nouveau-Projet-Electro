@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container mt-5">
    <h2>Connexion</h2>

    <form>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" class="form-control">
        </div>

        <button class="btn btn-primary">Se connecter</button>
    </form>
</div>
@endsection
