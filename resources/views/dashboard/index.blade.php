@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <h1>Dashboard Exclusive Endpoint</h1>
            <p class="lead">Gracias Envigado.</p>
            <a class="btn btn-lg btn-primary" href="https://codeanddeploy.com" role="button">View more tutorials here &raquo;</a>
        @endauth
    </div>
@endsection
