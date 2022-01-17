@extends('layouts.app')

@section('htmlheader_title')
Ingreso
@endsection

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ingreso a MAIS') }}</div>

                <div class="card-body">
                    @if (session('msg'))
                        <div class="callout callout-danger">
                            <h5>{{session('msg')}}</h5>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="tipos_documentos_id" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de documento') }}</label>

                            <div class="col-md-6">
                                <select name="tipos_documentos_id" id="tipos_documentos_id" class="form-control {{ $errors->has('tipos_documentos_id') ? 'is-invalid' : ''}}" required autofocus>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('tipos_documentos_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipos_documentos_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="documento" class="col-md-4 col-form-label text-md-right">{{ __('Documento') }}</label>

                            <div class="col-md-6">
                                <input id="documento" type="number" class="form-control {{ $errors->has('documento') ? 'is-invalid' : ''}}" name="documento" value="{{ old('documento') }}" required autocomplete="documento" placeholder="Número de documento">

                                @if ($errors->has('documento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('documento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password" required autocomplete="current-password" placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(isset($rememberme))

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary w-75">
                                    {{ __('Iniciar Sesión') }}
                                </button>

                                @if (! Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
