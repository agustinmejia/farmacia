@extends('voyager::master')

@section('page_title', 'Cerrar Cajas')

@if(auth()->user()->hasPermission('browse_cajas'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-wallet"></i>Cerrar Cajas
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
                            <form action="{{ route('cajas.close.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="caja_id" value="{{ $id }}">
                                <input type="hidden" name="monto_real" id="input-monto_real">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12" style="margin:0px">
                                                <div class="panel-body" style="padding-top:0;max-height:400px;overflow-y:auto">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Corte</th>
                                                                <th>Cantidad</th>
                                                                <th>Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="lista_cortes"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                <div class="panel panel-bordered" style="padding-bottom:5px;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="panel-heading" style="border-bottom:0;">
                                                                <h3 class="panel-title">Ingresos</h3>
                                                            </div>
                                                            <div class="panel-body" style="padding-top:0;">
                                                                <h4>{{ number_format($ingresos, 2, ',', '.') }}</h4>
                                                            </div>
                                                            <hr style="margin:0;">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="panel-heading" style="border-bottom:0;">
                                                                <h3 class="panel-title">Egresos</h3>
                                                            </div>
                                                            <div class="panel-body" style="padding-top:0;">
                                                                <h4>{{ number_format($egresos, 2, ',', '.') }}</h4>
                                                            </div>
                                                            <hr style="margin:0;">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="panel-heading" style="border-bottom:0;">
                                                                <h3 class="panel-title">Monto en caja</h3>
                                                            </div>
                                                            <div class="panel-body" style="padding-top:0;">
                                                                <h4>{{ number_format($ingresos-$egresos, 2, ',', '.') }}</h4>
                                                            </div>
                                                            <hr style="margin:0;">
                                                            <input type="hidden" name="monto_cierre" value="{{ $ingresos-$egresos }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="panel-heading" style="border-bottom:0;">
                                                                <h3 class="panel-title">Monto real en caja</h3>
                                                            </div>
                                                            <div class="panel-body" style="padding-top:0;">
                                                                <h4 id="label-monto_real">0,00</h4>
                                                            </div>
                                                            <hr style="margin:0;">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="panel-heading" style="border-bottom:0;">
                                                                <h3 class="panel-title text-center" id="label-faltante"></h3>
                                                            </div>
                                                            <hr style="margin:0;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Modal de confirmación --}}
                                    <div class="modal fade modal-success" id="modal-confirmar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmarLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h5 class="modal-title" id="modal-confirmarLabel">Confirmar cierre</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-muted">Ésta acción cerrará la caja y no podrás modificarla, deseas continuar?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-success">Sí, cerrar caja</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea name="observaciones" class="form-control" rows="5" placeholder="Observaciones finales"></textarea>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-confirmar">Cerrar caja</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('javascript')
    <script>
        let monto_cierre = parseFloat("{{ $ingresos-$egresos }}");
        $(document).ready(function(){
            // set valor de cerrar caja

            $('.btn-close').click(function(){
                $('#modal_close input[name="id"]').val($(this).data('id'));
            });

            $('.input-corte').keyup(function(){
                let corte = $(this).data('value');
                let cantidad = $(this).val() ? $(this).val() : 0;
                calcular_subtottal(corte, cantidad);
            });
            $('.input-corte').change(function(){
                let corte = $(this).data('value');
                let cantidad = $(this).val() ? $(this).val() : 0;
                calcular_subtottal(corte, cantidad);
            });
        });

        function calcular_subtottal(corte, cantidad){
            let total = (parseFloat(corte)*parseFloat(cantidad)).toFixed(2);
            $('#label-'+corte.toString().replace('.', '')).text(total+' Bs.');
            $('#input-'+corte.toString().replace('.', '')).val(total);
            calcular_total();
        }

        function calcular_total(){
            let total = 0;
            $(".input-subtotal").each(function(){
                total += $(this).val() ? parseFloat($(this).val()) : 0;
            });
            $('#label-monto_real').html('<b>'+(total).toFixed(2)+' Bs.</b>');
            $('#input-monto_real').val(total);

            if(total > 0){
                let monto_real = monto_cierre-total;
                if(monto_real > 0){
                    $('#label-faltante').text(`Tiene un faltante de ${monto_real.toFixed(2)} Bs.`);
                    $('#label-faltante').prepend('<i class="voyager-frown" style="font-size: 40px"></i><br>');
                    $('#label-faltante').css('color', 'red');
                }else if(monto_real==0){
                    $('#label-faltante').text(`El monto ingresado cuadra perfectamente!!!`);
                    $('#label-faltante').prepend('<i class="voyager-smile" style="font-size: 40px"></i><br>');
                    $('#label-faltante').css('color', 'green');
                }else{
                    $('#label-faltante').text(`Tiene un sobrante de ${(monto_real*-1).toFixed(2)} Bs.`);
                    $('#label-faltante').prepend('<i class="voyager-lightbulb" style="font-size: 40px"></i><br>');
                    $('#label-faltante').css('color', 'blue');
                }
            }else{
                $('#label-faltante').text(`Ingresa la cantidad de cortes de billetes.`);
                $('#label-faltante').prepend('<i class="voyager-dollar" style="font-size: 40px"></i><br>');
                $('#label-faltante').css('color', '#76848F');
            }
        }

        calcular_total();
        let cortes = new Array('0.5', '1', '2', '5', '10', '20', '50', '100', '200')
        cortes.map(function(value){
            $('#lista_cortes').append(`<tr>
                            <td><h4><img src="{{url('img/billetes/${value}.jpg')}}" alt="${value} Bs." width="80px"> ${value} Bs. </h4></td>
                            <td><input type="number" min="0" step="1" style="width:100px" data-value="${value}" class="form-control input-corte" value="0" required></td>
                            <td><label id="label-${value.replace('.', '')}">0.00 Bs.</label><input type="hidden" class="input-subtotal" id="input-${value.replace('.', '')}"></td>
                        </tr>`)
        });
    </script>
    @endsection
@else
    @section('content')
        @include('error.no_permission')
    @stop
@endif

