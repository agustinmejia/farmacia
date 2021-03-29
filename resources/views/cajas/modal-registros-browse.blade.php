<form id="form-nuevo-registro" action="{{ route('cajas.store.detalle') }}" method="post">
    @csrf
    <input type="hidden" name="caja_id">
    <div class="modal fade modal-primary" id="modal-registros" tabindex="-1" role="dialog" aria-labelledby="modal-registrosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="modal-registrosLabel">Registros de caja</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Nuevo registro<hr></h4>
                            <div class="form-group">
                                <label>Detalle</label>
                                <input type="text" name="detalle" class="form-control" placeholder="Descripción del registro de caja" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Monto de apertura</label>
                                    <div class="input-group">
                                        <input type="number" name="monto" min="0.1" step="0.1" class="form-control" value="0" placeholder="Monto de apertura de la caja" required>
                                        <span class="input-group-addon" id="basic-addon1">Bs.</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tipo de registro</label>
                                    <select name="tipo" class="form-control">
                                        <option value="1">Ingreso</option>
                                        <option value="2">Egreso</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="max-height: 400px; overflow-y: auto">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3"><h4 class="text-center">Detalles de caja</h4></th>
                                        </tr>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Tipo</th>
                                            <th class="text-right">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-detalle"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>