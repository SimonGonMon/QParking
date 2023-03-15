@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <h1>Dashboard</h1>
            <p class="lead">Gracias Envigado.</p>
            <button type="button" class="btn btn-lg btn-primary">Registrar Vehículos</button>
        @endauth
    </div>
@endsection

