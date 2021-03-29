<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\CajasController;

// Models
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\ProductoLote;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\SucursalProductoLote;
use App\Models\Caja;
use App\Models\CajaDetalle;

class VentasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $s = request('s');
        $query = request('s') != '' ? "(nombre like '%$s%' || codigo like '%$s%')" : 1;

        $ventas = Venta::with(['detalle.sucursal_producto.lote.producto', 'cliente', 'user'])->orderBy('id', 'DESC')->paginate();
        return view('ventas.ventas-browse', compact('ventas', 's'));
    }

    public function create(){
        $sucursales = Sucursal::where('deleted_at', NULL)->get();
        $clientes = Cliente::where('deleted_at', NULL)->get();
        $caja_abierta = Caja::where('user_id', Auth::user()->id)->where('estado', 1)->where('deleted_at', NULL)->first();

        // Obetener sucursal del usuario
        $sucursal_id = Auth::user()->sucursal_id;
        if(!$sucursal_id && count($sucursales) > 0){
            $sucursal_id = $sucursales[0]->id;
            User::where('id', Auth::user()->id)->update(['sucursal_id' => $sucursal_id]);
        }

        // $productos = Producto::where('deleted_at', NULL)->where('estado', 1)->get();
        $productos = SucursalProductoLote::with(['lote.producto'])->where('sucursal_id', $sucursal_id)->where('stock', '>', 0)->get();
        // dd($productos);
        return view('ventas.ventas-add', compact('sucursales', 'sucursal_id', 'clientes', 'productos', 'caja_abierta'));
    }

    public function store(Request $request){
    
        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'user_id' => Auth::user()->id,
                'cliente_id' => $request->cliente_id,
                'sucursal_id' => $request->sucursal_id,
                'observaciones' => $request->observaciones
            ]);

            $total = 0;

            for ($i=0; $i < count($request->producto_id); $i++) { 
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'sucursal_producto_lote_id' => $request->producto_id[$i],
                    'precio' => $request->precio_venta[$i],
                    'cantidad' => $request->cantidad[$i]
                ]);

                $total += $request->precio_venta[$i] * $request->cantidad[$i];

                $this->quitar_stock($request->producto_id[$i], $request->cantidad[$i]);
            }

            // Registrar en caja
            (new CajasController)->registro_caja($request->caja_id, 'Venta realizada: Nº '.$venta->id, $total, 1, $venta->id);

            DB::commit();
            return redirect()->route('ventas.add')->with(['message' => 'Venta registrada correctamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('ventas.add')->with(['message' => 'Ocurrió un error al registrar la venta.', 'alert-type' => 'error']);
        }
    }


    // ============================================

    public function change_branch($id){
        try {
            User::where('id', Auth::user()->id)->update(['sucursal_id' => $id]);
            return redirect('admin/ventas/create')->with(['message' => 'Sucursal actualizada.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            return redirect('admin/ventas/create')->with(['message' => 'Ocurrió un error, intente otra vez.', 'alert-type' => 'error']);
        }
    }

    public function quitar_stock($sucursal_producto_lotes_id, $cantidad){
        $lote = SucursalProductoLote::findOrFail($sucursal_producto_lotes_id);
        $stock = $lote->stock - $cantidad;
        $lote->stock = $stock > 0 ? $stock : 0;
        $lote->save();
    }
}
