@extends('voyager::master')

@section('page_title', 'Viendo Compras')

@if(auth()->user()->hasPermission('browse_proveedores'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-file-text"></i> Compras
            </h1>
            <a href="{{ route('compras.add') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Añadir</span>
            </a>
        </div>
    @stop

    @section('content')
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" placeholder="Buscar" name="s" value="{{ $s }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>                                                                                                        
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Fecha de compra</th>
                                            <th>Registrado por</th>
                                            <th>Detalle</th>
                                            <th class="actions text-right dt-not-orderable">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($compras as $compra)
                                        <tr>
                                            <td> <b>{{ $compra->proveedor->nombre }}</b> <br> <small>{{ $compra->proveedor->telefono }} <br> {{ $compra->proveedor->direccion }} </small> </td>
                                            <td>{{date('d-m-Y', strtotime($compra->updated_at))}} <br> <small>{{\Carbon\Carbon::parse($compra->updated_at)->diffForHumans()}}</small> </td>
                                            <td>{{ $compra->user->name }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($compra->detalle as $detalle)
                                                        <li>{{ number_format($detalle->cantidad, 0) }} {{ $detalle->producto_lote->producto->nombre }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="no-sort no-click bread-actions text-right">
                                                <a href="#" title="Ver" class="btn btn-sm btn-warning view">
                                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"><h5 class="text-center">No hay ventas registradas</h5></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if (count($compras))
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <p class="text-muted">Mostrando del {{$compras->firstItem()}} al {{$compras->lastItem()}} de {{$compras->total()}} registros.</p>
                                    </div>
                                    <div class="col-md-8">
                                        <nav class="text-right">
                                            {{ $compras->links() }}
                                        </nav>
                                    </div>
                                </div>
                            @endif
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

