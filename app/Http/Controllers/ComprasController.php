<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\ProductoLote;
use App\Models\Proveedore;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\SucursalProductoLote;

class ComprasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $s = request('s');
        $query = request('s') != '' ? "(nombre like '%$s%' || codigo like '%$s%')" : 1;

        $compras = Compra::with(['detalle.producto_lote.producto', 'proveedor', 'user'])->orderBy('id', 'DESC')->paginate();
        return view('compras.compras-browse', compact('compras', 's'));
    }

    public function create(){
        $sucursales = Sucursal::where('deleted_at', NULL)->get();
        $proveedores = Proveedore::where('deleted_at', NULL)->get();
        $productos = Producto::where('deleted_at', NULL)->where('estado', 1)->get();
        return view('compras.compras-add', compact('sucursales', 'proveedores', 'productos'));
    }

    public function store(Request $request){
    
        // dd($request);
        DB::beginTransaction();
        try {

            $compra = Compra::create([
                'user_id' => Auth::user()->id,
                'proveedore_id' => $request->proveedor_id,
                'sucursal_id' => $request->sucursal_id,
                'descuento' => $request->descuento_extra,
                'observaciones' => $request->observaciones
            ]);

            for ($i=0; $i < count($request->producto_id); $i++) { 
                $producto_lote = ProductoLote::create([
                    'producto_id' => $request->producto_id[$i],
                    'nro_lote' => $request->nro_lote[$i],
                    'fecha_vencimiento' => $request->fecha_vencimiento[$i],
                ]);

                $sucursal_producto_lote = SucursalProductoLote::create([
                    'sucursal_id' => $request->sucursal_id,
                    'producto_lote_id' => $producto_lote->id,
                    'precio' => $request->precio_venta[$i],
                    'stock' => $request->cantidad[$i]
                ]);

                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_lote_id' => $producto_lote->id,
                    'precio' => $request->precio_compra[$i],
                    'descuento' => $request->descuento[$i],
                    'cantidad' => $request->cantidad[$i]
                ]);
            }

            DB::commit();
            return redirect()->route('compras.index')->with(['message' => 'Compra registrada correctamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('compras.add')->with(['message' => 'Ocurrió un error al registrar la compra.', 'alert-type' => 'error']);

        }
    }
}
