@extends('template/padrao')

{{-- Titulo da pagina --}}
@section('title', 'Cliente')

{{-- Sessao content do site --}}
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Usuário</h1>
            <p>
                ID: {{$usuario->id}}
            </p>
            <p>
                Nome: <strong>{{$usuario->nome}}</strong>
            </p>

            <hr>

            <h2>Clientes</h2>
            <ol>
                @foreach($usuario->clientes as $cliente)
                <li>
                    Nome: <strong>{{$cliente->nome}}</strong> - Cidade: {{$cliente->cidade->nome}}
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

{{-- Sessao content do site --}}
@endsection
