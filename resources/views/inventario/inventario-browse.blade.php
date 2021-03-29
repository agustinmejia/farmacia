@extends('voyager::master')

@section('page_title', 'Viendo Inventario')

@if(auth()->user()->hasPermission('browse_inventario'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-data"></i> Inventario
            </h1>
            <a href="{{ route('inventario.add') }}" class="btn btn-success btn-add-new">
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
                                            <th>Producto</th>
                                            <th>Inventario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($productos as $producto)
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td><img src="{{ $producto->logo ? asset('storage/'.str_replace('.', '-cropped.', $producto->logo)) : asset('img/default.png') }}" alt="{{ $producto->codigo }}" width="60px"></td>
                                                        <td><h5 style="padding-left: 5px">{{ $producto->nombre }} <br> <small>{{ $producto->codigo }}</small> <br> <small>{{ $producto->descripcion }}</small> </h5></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table" style="font-size: 11px">
                                                    <tr>
                                                        <th>N&deg; de lote</th>
                                                        <th>Stock</th>
                                                        <th>Precio</th>
                                                        <th>Vencimiento</th>
                                                        <th class="text-right">Acciones</th>
                                                    </tr>
                                                    @forelse($producto->lote as $lote)
                                                        
                                                        @php
                                                            $stock = 0;
                                                            $precio = 0;
                                                            $label_date = '';
                                                            foreach ($lote->almacen as $almacen) {
                                                                $stock += $almacen->stock;
                                                                $precio = $almacen->precio;
                                                            }
                                                            if($lote->fecha_vencimiento <= date('Y-m-d')){
                                                                $label_date = 'text-danger';
                                                            }elseif ($lote->fecha_vencimiento <= date("Y-m-d",strtotime("+ 1 month"))) {
                                                                $label_date = 'text-warning';
                                                            }
                                                        @endphp
                                                        @if ($stock > 0)
                                                            <tr>
                                                                <td>{{ $lote->nro_lote }}</td>
                                                                <td>{{ $stock }}</td>
                                                                <td>{{ $precio }}</td>
                                                                <td class="{{ $label_date }}"><b>{{ date('d-m-Y', strtotime($lote->fecha_vencimiento)) }} | <small>{{ \Carbon\Carbon::parse($lote->fecha_vencimiento)->diffForHumans() }}</small></b></td>
                                                                <td class="text-right">
                                                                    <button class="btn btn-link text-primary" style="padding: 0px; margin: 0px"><span class="text-primary">Editar</span></button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="5"><h6 class="text-center">No hay inventario</h6></td>
                                                        </tr>
                                                    @endforelse
                                                </table>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"><h5 class="text-center">No hay productos en el inventario</h5></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if (count($productos))
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <p class="text-muted">Mostrando del {{$productos->firstItem()}} al {{$productos->lastItem()}} de {{$productos->total()}} registros.</p>
                                    </div>
                                    <div class="col-md-8">
                                        <nav class="text-right">
                                            {{ $productos->links() }}
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


