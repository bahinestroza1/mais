@extends('layouts.app')

@section('htmlheader_title')
Inicio
@endsection

@section('contentheader_title')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio MAIS</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="font-weight-bold">Bienvenido al Sistemas MAIS.</h5><br>
                    <h4 class="font-weight-bold">{{Auth::user()->nombre_completo()}}</h4>
                    <h5><span class="font-weight-bold">Rol: </span> {{Auth::user()->rol->nombre}}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
