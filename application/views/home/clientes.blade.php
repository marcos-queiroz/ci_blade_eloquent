@extends('template/padrao')

{{-- Titulo da pagina --}}
@section('title', 'Clientes')

{{-- Sessao content do site --}}
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Cidade</th>
                        <th>Cadastrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->id}}</td>
                        <td>{{$cliente->nome}}</td>
                        <td>{{$cliente->cidade->nome}}</td>
                        <td>{{$cliente->usuario->nome}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Sessao content do site --}}
@endsection
