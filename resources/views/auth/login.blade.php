@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('login.perform') }}" class="w-25 p-3 mx-auto">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <a href="{{ route('home.index') }}"><img class="mb-4" src="{!! url('assets/images/qparking_fondoclaro.png') !!}" alt="" width="128" height="128"></a>

        <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>

        @include('layouts.partials.messages')

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Email/Cédula" required="required" autofocus>
            <label for="floatingName" class="form-label">Correo/Cédula</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Contraseña" required="required">
            <label for="floatingPassword" class="form-label">Contraseña</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>

        @include('auth.partials.copy')
    </form>
@endsection
