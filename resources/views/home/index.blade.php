@extends('layouts.app-master')

@section('content')

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <!-- Favicon-->
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet"/>
        <title>Landing Page - Home</title>
    </head>

    <body>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-white mb-2">Moderniza tu estacionamiento</h1>
                        <p class="lead text-white-50 mb-4">Con QParking deja atrás el servicio de estacionamiento
                            obsoleto y tradicional.</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#info">Inicia Ahora</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="#map">Encuentranos</a>
                            {{--                                <a class="btn btn-outline-light btn-lg px-4" href="#!">Learn More</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Features section-->
    <section class="py-5 border-bottom" id="info">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div
                        class="feature bg-primary bg-gradient text-white rounded-3 mb-3 d-flex align-items-center justify-content-center bg-blue rounded"
                        style="height: 60px; width: 60px;"><i class="bi bi-phone-fill" style="font-size: 30px;"></i>
                    </div>
                    <h2 class="h4 fw-bolder">Sistemas Digitales</h2>
                    <p>Descubre las innovaciones digitales que revolucionan el estacionamiento: pagos sin efectivo,
                        reservas en tiempo real y navegación simplificada. ¡Estacionar nunca fue tan simple!.</p>
                    {{--                        <a class="text-decoration-none" href="#!">--}}
                    {{--                            Call to action--}}
                    {{--                            <i class="bi bi-arrow-right"></i>--}}
                    {{--                        </a>--}}
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div
                        class="feature bg-primary bg-gradient text-white rounded-3 mb-3 d-flex align-items-center justify-content-center bg-blue rounded"
                        style="height: 60px; width: 60px;"><i class="bi bi-camera-reels-fill"
                                                              style="font-size: 30px;"></i></div>
                    <h2 class="h4 fw-bolder">Reconocimiento de Placa</h2>
                    <p>¡Olvida los tiquetes de estacionamiento! Nuestros supervisores utilizan la cámara de su celular
                        para reconocer automáticamente las placas de los vehículos, brindándote una experiencia digital
                        sin complicaciones. ¡Estaciona fácilmente con tecnología de vanguardia!.</p>
                    {{--                        <a class="text-decoration-none" href="#!">--}}
                    {{--                            Call to action--}}
                    {{--                            <i class="bi bi-arrow-right"></i>--}}
                    {{--                        </a>--}}
                </div>
                <div class="col-lg-4">
                    <div
                        class="feature bg-primary bg-gradient text-white rounded-3 mb-3 d-flex align-items-center justify-content-center bg-blue rounded"
                        style="height: 60px; width: 60px;"><i class="bi bi-credit-card-2-back-fill"
                                                              style="font-size: 30px;"></i></div>
                    <h2 class="h4 fw-bolder">Facilidad a la hora de Pagar</h2>
                    <p>Descubre la comodidad de pagar tu estacionamiento de forma rápida y segura con nuestros métodos
                        de pago digitales. Olvídate del efectivo y disfruta de una experiencia sin complicaciones.</p>
                    {{--                        <a class="text-decoration-none" href="#!">--}}
                    {{--                            Call to action--}}
                    {{--                            <i class="bi bi-arrow-right"></i>--}}
                    {{--                        </a>--}}
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-4 border-bottom" id="map">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">Nuestras Ubicaciones</h2>
                <p class="lead mb-0">Todos los lugares en los que puedes puedes disfrutar nuestro servicio.</p>
            </div>
            <div class="bg-light p-0 rounded antialised justify-content-center align-items-center" >

                <x-maps-google
                    :centerPoint="['lat' => 6.1644936, 'long' => -75.4850299]"
                    :zoomLevel="11"
                    :markers="[ ['lat' => 6.1644936, 'long' => -75.4850299,'title' => 'Perico'],['lat' => 6.1533953, 'long' => -75.5379501, 'title' => 'El Almorzadero de Chepo'], ['lat' => 6.151288, 'long' => -75.6170747, 'title' => 'Casa de Osama Bin Laden'] ]">

                </x-maps-google>

            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container px-5"><p class="m-0 text-center text-white">QParking &copy; {{date('Y')}}</p></div>
    </footer>
    <!-- Bootstrap core JS-->
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>

@endsection
