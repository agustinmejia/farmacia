<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Caja;
use App\Models\CajaDetalle;

class CajasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $option = request('option');
        $s = request('s');
        $query = request('s') != '' ? "(nombre like '%$s%' || codigo like '%$s%')" : 1;
        $cajas = Caja::with(['detalle', 'user'])->orderBy('id', 'DESC')->paginate();
        return view('cajas.cajas-browse', compact('cajas', 's', 'option'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $caja = Caja::where('user_id', Auth::user()->id)->where('estado', 1)->where('deleted_at', NULL)->first();
        if($caja){
            return redirect()->route('cajas.index')->with(['message' => 'Tienes una caja sin cerrar.', 'alert-type' => 'error']);
        }

        DB::beginTransaction();
        try {
            $caja = Caja::create([
                'user_id' => Auth::user()->id,
                'nombre' => $request->nombre
            ]);

            if($request->monto){
                $this->registro_caja($caja->id, 'Monto al aperturar caja', $request->monto, 1);
            }

            DB::commit();
            return redirect()->route('cajas.index')->with(['message' => 'Caja aperturada correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('cajas.index')->with(['message' => 'Ocurrió un error al aperturar la caja.', 'alert-type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function close($id){
        $caja = Caja::with(['detalle', 'user'])->where('id', $id)->first();
        return view('cajas.cajas-close', compact('caja', 'id'));
    }

    public function close_store(Request $request){
        DB::beginTransaction();
        try {
            $caja = Caja::findOrFail($request->caja_id);
            $caja->monto_cierre = $request->monto_cierre;
            $caja->monto_real = $request->monto_real;
            $caja->estado = 2;
            $caja->observaciones = $request->observaciones;
            $caja->save();
            DB::commit();
            return redirect()->route('cajas.index')->with(['message' => 'Caja cerrada correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('cajas.index')->with(['message' => 'Ocurrió un error al cerrar la caja.', 'alert-type' => 'error']);
        }      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function store_detalle(Request $request){
        if($request->tipo == 2){
            $caja = Caja::with(['detalle'])->where('id', $request->caja_id)->first();
            $total = 0;
            foreach ($caja->detalle as $value) {
                $total += $value->monto;
            }

            if($total < $request->monto){
                return redirect()->route('cajas.index')->with(['message' => 'El monto de egreso es mayor al monto en caja.', 'alert-type' => 'error']);
            }
        }

        try {
            CajaDetalle::create([
                'caja_id' => $request->caja_id,
                'detalle' => $request->detalle,
                'monto' => $request->monto,
                'tipo' => $request->tipo
            ]);
            return redirect()->route('cajas.index')->with(['message' => 'Regristro de caja ingresado correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->route('cajas.index')->with(['message' => 'Ocurrió un error en nuestro servidor.', 'alert-type' => 'error']);
        }
    }


    // ==============================================

    public function registro_caja($caja_id, $detalle, $monto, $tipo, $venta_id = null, $compra_id = null){
        try {
            CajaDetalle::create([
                'caja_id' => $caja_id,
                'detalle' => $detalle,
                'monto' => $monto,
                'tipo' => $tipo,
                'venta_id' => $venta_id,
                'compra_id' => $compra_id
            ]);
        } catch (\Throwable $th) {}
    }
}
