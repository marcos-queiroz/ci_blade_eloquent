@extends('template/padrao')

{{-- Titulo da pagina --}}
@section('title', 'Cliente')

{{-- Sessao content do site --}}
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Cliente</h1>
            <hr>
            <p>
                ID: {{$cliente->id}}
            </p>
            <p>
                Nome: {{$cliente->nome}}
            </p>
            <p>
                Cidade: {{$cliente->cidade->nome}}
            </p>
            <p>
                Cadastrado por: {{$cliente->usuario->nome}}
            </p>
        </div>
    </div>
</div>

{{-- Sessao content do site --}}
@endsection
