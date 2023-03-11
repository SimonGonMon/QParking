@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('register.perform') }}" class="w-25 p-3 mx-auto">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <a href="{{ route('home.index') }}"><img class="mb-4" src="{!! url('assets/images/qparking_fondoclaro.png') !!}" alt="" width="128" height="128"></a>


        <h1 class="h3 mb-3 fw-normal">Registro</h1>

        <div class="form-group form-floating mb-2">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombre Completo" required="required" autofocus>
            <label for="floatingName" class="form-label">Nombre Completo</label>
            @if ($errors->has('name'))
                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-4">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Cédula" required="required" autofocus>
            <label for="floatingName" class="form-label">Cédula</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-4">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required="required" autofocus>
            <label for="floatingEmail" class="form-label">Correo Electrónico</label>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-2">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Contraseña" required="required">
            <label for="floatingPassword" class="form-label">Contraseña</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-2">
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirmar Contraseña" required="required">
            <label for="floatingConfirmPassword" class="form-label">Confirmar Contraseña</label>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Registrarse</button>

        @include('auth.partials.copy')
    </form>
@endsection
