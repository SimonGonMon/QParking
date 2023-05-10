@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
                    <h1>Inicio</h1>
                    <p class="lead">Esto se supone que va a ser la landing.</p>

{{--        @auth--}}
{{--            <h1>Dashboard</h1>--}}
{{--            <p class="lead">Only authenticated users can access this section.</p>--}}
{{--            <a class="btn btn-lg btn-primary" href="https://codeanddeploy.com" role="button">View more tutorials here &raquo;</a>--}}
{{--        @endauth--}}

{{--        @guest--}}
{{--            <h1>Homepage</h1>--}}
{{--            <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>--}}
{{--        @endguest--}}
    </div>

    <div class="bg-light p-5 rounded antialised">

        <x-maps-google
            :centerPoint="['lat' => 6.1644936, 'long' => -75.4850299]"
            :zoomLevel="11"
            :markers="[ ['lat' => 6.1644936, 'long' => -75.4850299,'title' => 'Perico'],['lat' => 6.1533953, 'long' => -75.5379501, 'title' => 'El Almorzadero de Chepo'], ['lat' => 6.151288, 'long' => -75.6170747, 'title' => 'Casa de Osama Bin Laden'] ]">

        </x-maps-google>

    </div>


@endsection
