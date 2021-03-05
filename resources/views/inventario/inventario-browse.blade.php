@extends('voyager::master')

@section('page_title', 'Inventario')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-data"></i> Inventario
        </h1>
        <a href="{{ route('inventario.add') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Agregar</span>
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
                                    <input type="text" class="form-control" placeholder="Buscar" name="s" value="">
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
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Inventario</th>
                                        <th class="actions text-right dt-not-orderable">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productos as $producto)
                                    <tr>
                                        <td><img src="{{ $producto->logo ? asset('storage/'.str_replace('.', '-cropped.', $producto->logo)) : asset('img/default.png') }}" alt="{{ $producto->codigo }}" width="60px"></td>
                                        <td><h5>{{ $producto->nombre }} <br> <small>{{ $producto->codigo }}</small></h5></td>
                                        <td>
                                            <table class="table">
                                                <tr>
                                                    <th>N&deg; de lote</th>
                                                    <th>Stock</th>
                                                    <th>Precio</th>
                                                    <th>Vencimiento</th>
                                                </tr>
                                                @foreach ($producto->lote as $lote)
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
                                                    <tr>
                                                        <td>{{ $lote->nro_lote }}</td>
                                                        <td>{{ $stock }}</td>
                                                        <td>{{ $precio }}</td>
                                                        <td class="{{ $label_date }}"><b>{{ date('d-m-Y', strtotime($lote->fecha_vencimiento)) }} <br> <small>{{ \Carbon\Carbon::parse($lote->fecha_vencimiento)->diffForHumans() }}</small></b></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="no-sort no-click bread-actions text-right">
                                            <a href="#" title="Ver" class="btn btn-sm btn-warning view">
                                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                            </a>
                                            {{-- <a href="#" title="Editar" class="btn btn-sm btn-primary edit">
                                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                            </a> --}}
                                            <a href="javascript:;" title="Borrar" class="btn btn-sm btn-danger delete">
                                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                            </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

