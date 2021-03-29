@extends('voyager::master')

@section('page_title', 'Viendo Cajas')

@if(auth()->user()->hasPermission('browse_cajas'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-wallet"></i> Cajas
            </h1>
            <button type="button" class="btn btn-success btn-add-new" data-toggle="modal" data-target="#modal-create">
                <i class="voyager-plus"></i> <span>Añadir</span>
            </button>
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
                                            <th>Caja</th>
                                            <th>Fecha apertura</th>
                                            <th class="text-center">Detalle</th>
                                            <th>Estado</th>
                                            <th>Total en caja</th>
                                            <th class="actions text-right dt-not-orderable">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cajas as $caja)
                                        <tr>
                                            <td>{{ $caja->nombre }} <br> <small><label class="label label-default">{{ $caja->user->name }}</label></small></td>
                                            <td>{{date('d-m-Y', strtotime($caja->updated_at))}} <br> <small>{{\Carbon\Carbon::parse($caja->updated_at)->diffForHumans()}}</small> </td>
                                            <td>
                                                @php
                                                    $ingresos = 0;
                                                    $egresos = 0;
                                                    foreach($caja->detalle as $detalle){
                                                        if($detalle->tipo == 1){
                                                            $ingresos +=  $detalle->monto;
                                                        }else{
                                                            $egresos += $detalle->monto;
                                                        }
                                                    }
                                                @endphp
                                                <table width="100%" align="center">
                                                    <thead>
                                                        <tr>
                                                            <th>Ingreoso</th>
                                                            <th>Egreosos</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ number_format($ingresos, 2, ',', '.') }}</td>
                                                            <td>{{ number_format($egresos, 2, ',', '.') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                @if ($caja->estado == 1)
                                                    <label class="label label-success">Abierta</label>
                                                @else
                                                    <label class="label label-danger">Cerrada</label>
                                                @endif
                                            </td>
                                            <td><h4>Bs. {{ number_format($ingresos - $egresos, 2, ',', '.') }}</h4></td>
                                            <td class="no-sort no-click bread-actions text-right">
                                                @if ($caja->estado == 1)
                                                    <button type="button" title="Registros" class="btn btn-sm btn-primary btn-registro view" data-toggle="modal" data-target="#modal-registros" data-caja="{{ $caja }}">
                                                        <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">Registros</span>
                                                    </button>
                                                    <a href="{{ route('cajas.close', ['id' => $caja->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                                        <i class="voyager-settings"></i> <span class="hidden-xs hidden-sm">Cerrar</span>
                                                    </a>
                                                    @if (count($caja->detalle) == 0)
                                                        <button type="button" title="Borrar" class="btn btn-sm btn-danger delete">
                                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                        </button>
                                                    @endif
                                                @else
                                                    <a href="#" title="Generar PDF" class="btn btn-sm btn-danger view">
                                                        <i class="voyager-file-text"></i> <span class="hidden-xs hidden-sm">Generar PDF</span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"><h5 class="text-center">No hay ventas registradas</h5></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if (count($cajas))
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <p class="text-muted">Mostrando del {{$cajas->firstItem()}} al {{$cajas->lastItem()}} de {{$cajas->total()}} registros.</p>
                                    </div>
                                    <div class="col-md-8">
                                        <nav class="text-right">
                                            {{ $cajas->links() }}
                                        </nav>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('cajas.modal-cajas-add')
        @include('cajas.modal-registros-browse')
    @stop

    @section('javascript')
        <script>
            $(document).ready(function(){
                @if($option == 'open')
                    $('#modal-create').modal('show');
                @endif

                $('.btn-registro').click(function(){
                    $('#table-detalle').empty();
                    let caja = $(this).data('caja');
                    $('#form-nuevo-registro input[name="caja_id"]').val(caja.id);
                    let total = 0;
                    caja.detalle.map(item => {
                        $('#table-detalle').append(`
                            <tr>
                                <td>${item.detalle}</td>
                                <td>${item.tipo ? 'Ingreso' : 'Egreso'}</td>
                                <td class="text-right">${item.monto}</td>
                            </tr>
                        `);
                        if(item.tipo == 1){
                            total += parseFloat(item.monto);
                        }else{
                            total -= parseFloat(item.monto);
                        }
                    });

                    $('#table-detalle').append(`
                        <tr>
                            <td colspan="2"><b>Total</b></td>
                            <td class="text-right"><h4>${total.toFixed(2)}</h4></td>
                        </tr>
                    `);
                });
            });
        </script>
    @endsection
@else
    @section('content')
        @include('error.no_permission')
    @stop
@endif

