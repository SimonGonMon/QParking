@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <h1>Dashboard</h1>
            <p class="lead">Gracias Envigado.</p>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-register">
                Registrar Vehículo
            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-payment">
                Generar Cobro
            </button>
        @endauth
    </div>

{{--    Modal Registrar Vehículo--}}
    <div class="modal fade" id="modal-register" tabindex="-1" aria-labelledby="modal-register" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Vehículo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('services.register') }}">>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Cedula de Ciudadania</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" pattern="[0-9]{1,10}" maxlength="10">
                            <div id="emailHelp" class="form-text">Debe contener números únicamente.</div>

                        </div>

                        <div class="mb-3">
                            <label for="plate" class="form-label">Placa Vehicular</label>
                            <input type="text" class="form-control" id="plate" name="plate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" minlength="5">
                            <div id="emailHelp" class="form-text">La placa debe tener el formato ABC123 o ABC12D.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Generar Cobro --}}
    <div class="modal fade" id="modal-payment" tabindex="-1" aria-labelledby="modal-payment" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Generar Cobro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('services.generate-payment') }}">>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="plate" class="form-label">Placa Vehicular</label>
                            <input type="text" class="form-control" id="plate" name="plate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" minlength="5">
                            <div id="emailHelp" class="form-text">La placa debe tener el formato ABC123 o ABC12D.</div>
                        </div>
                        <div id="tabla-servicios"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="buscar-servicio">Buscar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    @if(session('data'))
        <h1 class="mt-5">Resultado Consulta</h1>
        <hr>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Placa</th>
                <th scope="col">Fecha Ingreso</th>
                <th scope="col">Tiempo Transcurrido</th>
                <th scope="col">Fecha Salida</th>
                <th scope="col">Valor Cobro</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ session('data')['plate'] }}</td>
                <td>{{ session('data')['start_time'] }}</td>
                <td>{{ session('data')['elapsed_time'] }}</td>
                <td>{{ session('data')['end_time'] }}</td>
                <td>{{ session('data')['cost'] }}</td>
            </tr>
            </tbody>
        </table>

        <form method="POST" action="{{ route('services.generate-qr') }}">
            @csrf
            <input type="hidden" name="plate" value="{{ session('data')['plate'] }}">
            <input type="hidden" name="start_time" value="{{ session('data')['start_time'] }}">
            <input type="hidden" name="elapsed_time" value="{{ session('data')['elapsed_time'] }}">
            <input type="hidden" name="end_time" value="{{ session('data')['end_time'] }}">
            <input type="hidden" name="cost" value="{{ session('data')['cost'] }}">
            <button type="submit" class="btn btn-primary" id="generarQR">Generar QR</button>
        </form>
    @endif

{{--    al presionar el boton Generar QR se debe hacer una solicitud a una API que devolvera una imagen QR que sera mostrada en la vista--}}
    @if(session('routeQr'))
        <img src="{{ session('routeQr') }}" alt="QR">
    @endif

    @if(session('data'))
        {{ session()->forget('data') }}
    @endif

    @if(session('routeQr'))
        {{ session()->forget('routeQr') }}
    @endif
@endsection

{{--crea un script para hacer la solicitud a la api mediante una funcion en ServiceController con el boton Generar QR--}}

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#generarQR').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('services.generate-qr') }}",
                    method: "POST",
                    data: {
                        plate: $('#plate').val(),
                        start_time: $('#start_time').val(),
                        elapsed_time: $('#elapsed_time').val(),
                        end_time: $('#end_time').val(),
                        cost: $('#cost').val(),
                    },
                    success: function (response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush




