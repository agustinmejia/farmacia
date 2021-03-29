<form action="{{ route('cajas.store') }}" method="post">
    @csrf
    <div class="modal fade modal-success" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modal-createLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal-createLabel">Añadir caja</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="" placeholder="Caja 1" required>
                            </div>
                            <div class="form-group">
                                <label>Monto de apertura</label>
                                <div class="input-group">
                                    <input type="number" name="monto" min="0" step="0.1" class="form-control" value="0" placeholder="Monto de apertura de la caja">
                                    <span class="input-group-addon" id="basic-addon1">Bs.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>