@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <h1>Dashboard</h1>
            <p class="lead">Gracias Envigado.</p>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Registrar Vehículo
            </button>
        @endauth
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
@endsection
