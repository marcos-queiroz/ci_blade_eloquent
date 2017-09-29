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
                        <th>Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->id}}</td>
                        <td>{{$usuario->nome}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{base_url('/usuario/').$usuario->id}}">
                                <i class="material-icons">find_in_page</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Sessao content do site --}}
@endsection
