@extends('voyager::master')

@section('page_title', 'Añadir Inventario')

@if(auth()->user()->hasPermission('add_inventario'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-data"></i> Añadir inventario
            </h1>
        </div>
    @stop

    @section('content')
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <form action="{{ route('inventario.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6">
                                            <label>Sucursal</label>
                                            <select name="sucursal_id" class="form-control select2" required>
                                                <option value="" selected>-- Selecciona la sucursal --</option>
                                                @foreach ($sucursales as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Producto</label>
                                            <select name="producto_id" class="form-control select2" required>
                                                <option value="" selected>-- Selecciona el producto --</option>
                                                @foreach ($productos as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Nro de lote</label>
                                            <input type="text" name="nro_lote" class="form-control" value="" placeholder="Número de lote" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Fecha de vencimiento</label>
                                            <input type="date" min="{{ date('Y-m-d') }}" name="fecha_vencimiento" class="form-control" value="" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Precio de venta</label>
                                            <input type="number" name="precio" min="0.5" step="0.1" class="form-control" value="" placeholder="Precio de venta del producto" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Precio de venta por mayor</label>
                                            <input type="number" name="precio_mayor" min="0" step="0.1" class="form-control" value="0" placeholder="Precio del producto por mayor" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Descuento</label>
                                            <input type="number" name="descuento" min="0" step="0.1" class="form-control" value="0" placeholder="Descuento" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Stock</label>
                                            <input type="number" name="stock" min="1" step="0.1" class="form-control" value="" placeholder="Cantidad en stock" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('inventario.index') }}" class="btn btn-default">Volver</a>
                                        <button type="submit" class="btn btn-primary" >Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop
@else
    @section('content')
        @include('error.no_permission')
    @stop
@endif

