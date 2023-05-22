@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
    <h1 class="mb-4">Dashboard</h1>

    <div class="card col-8 col-md-6 col-lg-5 mx-auto">
        <div class="card-body">
            <div class="row">
                <div class="col text-start">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal" data-bs-target="#modal-register">
                        <i class="bi bi-person-plus-fill"></i> Registrar Vehículo (Manual)
                    </button>
                </div>
                <div class="col text-center">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal" data-bs-target="#modal-register-file">
                        <i class="bi bi-camera-fill"></i> Registrar Vehiculo (Foto)
                    </button>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal" data-bs-target="#modal-payment">
                        <i class="bi bi-cash-stack"></i> Generar Cobro
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endauth
</div>

{{-- Modal Registrar Vehículo (manual)--}}
<div class="modal fade" id="modal-register" tabindex="-1" aria-labelledby="modal-register" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('services.register') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Cedula de Ciudadania</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" pattern="[0-9]{1,10}" maxlength="10" required>
                        <div id="emailHelp" class="form-text">Debe contener números únicamente.</div>

                    </div>

                    <div class="mb-3">
                        <label for="plate" class="form-label">Placa Vehicular</label>
                        <input type="text" class="form-control" id="plate" name="plate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" minlength="5" required>
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

{{-- Modal Registrar Vehículo (archivo)--}}
<div class="modal fade" id="modal-register-file" tabindex="-1" aria-labelledby="modal-register-file" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Vehículo (Foto)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="{{ route('services.register-file') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Cedula de Ciudadania</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" pattern="[0-9]{1,10}" maxlength="10" required>
                        <div id="emailHelp" class="form-text">Debe contener números únicamente.</div>

                    </div>

                    <div class="mb-3">
                        <label for="plate" class="form-label">Placa Vehicular</label>
                        <input type="file" class="form-control" id="plate-image" name="plate-image" accept=".png,.jpg" required>
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
            <form method="POST" action="{{ route('services.generate-payment') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="plate" class="form-label">Placa Vehicular</label>
                        <input type="text" class="form-control" id="plate" name="plate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" minlength="5" required>
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
<div class="alert alert-danger d-inline-block mx-auto">{{ session('error') }}</div>
@elseif(session('success'))
<div class="alert alert-success d-inline-block mx-auto">{{ session('success') }}</div>
@endif

@if(session('data'))
<div class="container">
    <section class='p-6'>
        <div class="card">
            <div class="card-body">
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
            </div>
        </div>

        <script>
            function checkCobroBolsillo() {
                $('#cobroBolsillo').prop('disabled', true); // disable the button
                // disable generarqR
                $('#generarQR').prop('disabled', true); // disable the button
                $('#cobroBolsillo').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...'); // change button text

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('services.checkCobroBolsillo') }}",
                    type: "POST",
                    data: {
                        amount: "{{ session('data')['cost'] }}",
                        plate: "{{ session('data')['plate'] }}",
                        start_time: "{{ session('data')['start_time'] }}",
                        elapsed_time: "{{ session('data')['elapsed_time'] }}",
                        end_time: "{{ session('data')['end_time'] }}",
                    },
                    success: function(response) {
                        alert("Alerta: " + response.message);
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.statusText);
                    },
                    complete: function() {
                        // enable the button and hide the spinning thing
                        $("#cobroBolsillo").prop("disabled", false);
                        $('#generarQR').prop('disabled', false);
                        $("#cobroBolsillo").html("Cobro Bolsillo");
                    }
                });
            }
        </script>

        <form method="POST" action="{{ route('services.generate-qr') }}">
            @csrf
            <input type="hidden" name="plate" value="{{ session('data')['plate'] }}">
            <input type="hidden" name="start_time" value="{{ session('data')['start_time'] }}">
            <input type="hidden" name="elapsed_time" value="{{ session('data')['elapsed_time'] }}">
            <input type="hidden" name="end_time" value="{{ session('data')['end_time'] }}">
            <input type="hidden" name="cost" value="{{ session('data')['cost'] }}">
            <button type="submit" class="btn btn-primary" id="generarQR">Generar QR</button>
            <button type="button" class="btn btn-secondary" id="cobroBolsillo" onclick="checkCobroBolsillo()">Cobro Bolsillo</button>
        </form>



    </section>
</div>

@endif

@if(session('routeQr'))
<section class="p-6">
    <h1 class="mt-5">QR de Pago</h1>
    <hr>
    <div class="d-flex justify-content-center">
        <img src="{{ session('routeQr') }}" alt="QR de Pago">
    </div>
</section>



{{-- add the image in a div  aligned to the center with a little gap --}}
@endif

@if(session('data'))
{{ session()->forget('data') }}
@endif

@if(session('routeQr'))
{{ session()->forget('routeQr') }}
@endif

<footer class="py-5 bg-dark mt-5">
    <div class="container px-5">
        <p class="m-0 text-center text-white">QParking &copy; {{date('Y')}}</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#generarQR').click(function(e) {
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
                success: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>
@endpush