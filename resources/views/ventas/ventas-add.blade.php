@extends('voyager::master')

@section('page_title', 'Añadir Venta')

@if(auth()->user()->hasPermission('add_proveedores'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-basket"></i> Añadir Venta
            </h1>
        </div>
    @stop

    @section('content')
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-12">
                    @if (!$caja_abierta)
                        <div class="alert alert-warning">
                            <strong>Advertencia:</strong>
                            <p>Debes aperturar caja antes de registrar una venta. <a href="{{ route('cajas.index').'?option=open' }}"><code>Click para abrir caja</code></a></p>
                        </div>
                    @endif
                </div>
            </div>
            <form action="{{ route('ventas.store') }}" method="post">
                @csrf
                <input type="hidden" name="caja_id" value="{{ $caja_abierta ? $caja_abierta->id : '' }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-12">
                                            <label>Producto</label>
                                            <select id="select-producto_id" class="form-control">
                                                <option value="" selected>-- Selecciona el producto --</option>
                                                @foreach ($productos as $item)
                                                <option value="{{ $item->id }}" data-producto="{{ $item }}">LOTE: {{ $item->lote->nro_lote }} - {{ $item->lote->producto->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5"><h4 class="text-center">Detalle de venta</h4></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Detalle</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio venta</th>
                                                        <th class="text-right">Subtotal</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-details"></tbody>
                                                <tr>
                                                    <td><h5>Total</h5></td>
                                                    <td class="text-right" colspan="3"><h3 id="label-total">0.00</h3></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Sucursal</label>
                                        <select name="sucursal_id" id="select-sucursal_id" class="form-control select2" required>
                                            @foreach ($sucursales as $item)
                                            <option value="{{ $item->id }}" @if ($sucursal_id == $item->id) selected @endif >{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Cliente</label>
                                        <select name="cliente_id" class="form-control select2" required>
                                            @foreach ($clientes as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre_completo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="checkbox" id="check-tipo-venta" name="credito" data-toggle="toggle" data-on="Por mayor" data-off="Normal">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones de la venta..."></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-block btn-primary" id="btn-save" disabled>Vender <i class="voyager-basket"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @stop

    @section('css')
        <style>

        </style>
    @endsection

    @section('javascript')
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();

                @if(!$errors->isEmpty())
                    toastr.error('Debes ingresar el detalle de la compra', 'Error!');                      
                @endif

                $('#select-producto_id').select2()
                .change(function(){
                    let producto = $('#select-producto_id option:selected').data('producto');
                    if(producto){
                        addRow(producto);
                    }
                });

                // Cambio de sucursal
                $('#select-sucursal_id').change(function(){
                    let id = $(this).val();
                    if(id){
                        window.location = "{{ url('admin/ventas/change/branch') }}/"+id
                    }
                });

                // Cambiar tipo de venta
                $('#check-tipo-venta').change(function(){
                    $('#table-details').empty();
                    calcularTotal();
                });
            });

            function addRow(producto){
                let encontrado = false;
                $('.input-producto_id').each(function(){
                    if($(this).val() == producto.id){
                        encontrado = true;
                    }
                });

                $('#select-producto_id').val(null).trigger("change");

                if(encontrado){
                    toastr.warning('El producto ya está seleccionado.', 'Advertencia!');
                    return;
                }

                let date = "{{ date('Y-m-d') }}";

                let descuento = producto.descuento ? producto.descuento : 0;
                let precio = producto.precio - descuento;
                if($('#check-tipo-venta:checked').val()){
                    precio = producto.precio_mayor;
                }

                if(precio == 0){
                    toastr.warning('Éste producto no está disponible para venta al por mayor.', 'Advertencia!');
                    return;
                }

                $('#table-details').append(`
                    <tr id="tr-${producto.id}">
                        <td><b>LOTE: ${producto.lote.nro_lote} - ${producto.lote.producto.nombre}</b> <br> <small>${producto.lote.producto.descripcion ? producto.lote.producto.descripcion : ''}</small> <input type="hidden" class="input-producto_id" name="producto_id[]" value="${producto.id}" required/></td>
                        <td style="width: 100px"><input type="number" class="form-control" onChange="calcularTotal(${producto.id})" onKeyup="calcularTotal(${producto.id})" id="input-cantidad-${producto.id}" data-id="${producto.id}" min="1" step="1" max="${producto.stock}" value="1" name="cantidad[]" required/></td>
                        <td style="width: 100px"><input type="number" class="form-control" id="input-precio_venta-${producto.id}" min="0.1" step="0.1" value="${precio}" name="precio_venta[]" readonly required/></td>
                        <td style="width: 100px"><h4 class="text-right label-subtotal" id="label-subtotal-${producto.id}">0.00</h4></td>
                        <td style="width: 50px"><button type="button" onClick="deleteTr(${producto.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                    </tr>
                `);

                setTimeout(() => {
                    calcularTotal(producto.id);
                }, 0);
            }

            function calcularTotal(id = null){
                if(id){
                    let cantidad = $(`#input-cantidad-${id}`).val() ? parseFloat($(`#input-cantidad-${id}`).val()) : 0;
                    let precio_venta = $(`#input-precio_venta-${id}`).val() ? parseFloat($(`#input-precio_venta-${id}`).val()) : 0;

                    let subtotal = (cantidad*precio_venta);
                    $(`#label-subtotal-${id}`).text(subtotal.toFixed(2));
                }

                let total = 0;
                let detalle = 0;
                $('.label-subtotal').each(function(){
                    total += parseFloat($(this).text());
                    detalle++;
                });
                $('#label-total').text(total.toFixed(2));

                if(detalle > 0){
                    @if ($caja_abierta)
                    $('#btn-save').removeAttr('disabled');
                    @endif
                }else{
                    $('#btn-save').attr('disabled', 'disabled');
                }
            }

            function deleteTr(id){
                $(`#tr-${id}`).remove();
                calcularTotal(id)
            }
        </script>
    @endsection
@else
    @section('content')
        @include('error.no_permission')
    @stop
@endif
