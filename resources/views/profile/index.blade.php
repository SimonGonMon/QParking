@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded" style="background-color: #f8f9fa;">
    @auth
    <h1 class="mb-4">Perfil</h1>

    <div class="student-profile py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent text-center">
                            <img class="profile_img rounded-circle" src="{{ $gravatar }}" alt="{{ $user->name }}">
                            <h3>{{ $user->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><strong class="pr-1">Correo Electrónico: </strong>{{ $user->email }}</p>
                            <p class="mb-0"><strong class="pr-1">Cédula de Ciudadanía: </strong>{{ $user->username }}</p>
                            <p class="mb-0"><strong class="pr-1">Balance: </strong>${{ number_format($user->balance, 0) }}</p>
                            <div class="mt-3">
                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#recargarModal">Recargar Saldo</button>
                            </div>
                        </div>

                        <!-- QR Modal -->
                        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrModalLabel">Código QR</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- QR code will be displayed here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recargar Modal -->
                        <div class="modal fade" id="recargarModal" tabindex="-1" role="dialog" aria-labelledby="recargarModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="recargarModalLabel">Recargar Saldo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="amount">Monto a recargar:</label>
                                                <input type="number" class="form-control" id="amount" placeholder="Ingrese el monto a recargar">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                                        <script>
                                            function getQR() {
                                                var amount = document.getElementById("amount").value;

                                                $('#recargarBtn').prop('disabled', true); // disable the button
                                                $('#recargarBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...'); // change button text


                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                $.ajax({
                                                    url: "{{ route('profile.getQR') }}",
                                                    type: "POST",
                                                    data: {
                                                        amount: amount
                                                    },
                                                    success: function(response) {
                                                        $('#recargarModal').modal('hide');
                                                        $('#qrModal .modal-body').html('<div class="text-center"><div style="margin-bottom: 10px;"><img src="' + response.qrCode + '"></div><div><a href="' + response.link + '" target="_blank">Haz click aquí para ir manualmente</a></div></div>');
                                                        $('#qrModal').modal('show');
                                                    },
                                                    error: function(xhr) {
                                                        alert('Error: ' + xhr.responseText);
                                                    }
                                                });
                                            }
                                        </script>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmarModal" data-dismiss="modal" onclick="getQR()" id="recargarBtn">Recargar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Servicios Activos</h3>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Placa</th>
                                        <th>Fecha y Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Models\Service::where('user_id', $user->username)->take(5)->get() as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->plate }}</td>
                                        <td>{{ $service->time_start }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="height: 30px"></div>
                </div>
            </div>
        </div>
    </div>

    @endauth
</div>

<footer class="py-5 bg-dark">
    <div class="container px-5">
        <p class="m-0 text-center text-white">QParking &copy; {{date('Y')}}</p>
    </div>
</footer>
@endsection