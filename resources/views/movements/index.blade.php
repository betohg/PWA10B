@extends('layouts.app') <!-- Asegúrate de tener una plantilla app.blade.php -->

@section('content')
<div class="container">
    <h1>Movimientos</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('msg') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movements as $movement)
            <tr>
                <td>{{ $movement['product']['name'] ?? 'N/A' }}</td>
                <td>{{ $movement['user']['name'] ?? 'N/A' }}</td>
                <td>{{ $movement['movementType']['name'] ?? 'N/A' }}</td>
                <td>{{ $movement['quantity'] }}</td>
                <td>{{ $movement['movement_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
