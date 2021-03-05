<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\ProductoLote;
use App\Models\SucursalProductoLote;

class InventarioController extends Controller
{
    //
    public function index(){
        $productos = Producto::with(['lote.almacen.sucursal'])->where('deleted_at', NULL)->get();
        // return $productos;
        return view('inventario.inventario-browse', compact('productos'));
    }

    public function create(){
        $sucursales = Sucursal::where('deleted_at', NULL)->get();
        $productos = Producto::where('deleted_at', NULL)->get();
        return view('inventario.inventario-add', compact('sucursales', 'productos'));
    }

    public function store(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            // Crear lote de producto
            $producto_lote = ProductoLote::create([
                'producto_id' => $request->producto_id,
                'nro_lote' => $request->nro_lote,
                'fecha_vencimiento' => $request->fecha_vencimiento
            ]);

            $sucursal_producto_lote = SucursalProductoLote::create([
                'sucursal_id' => $request->sucursal_id,
                'producto_lote_id' => $producto_lote->id,
                'precio' => $request->precio,
                'stock' => $request->stock
            ]);

            DB::commit();
            return redirect()->route('inventario.add')->with(['message' => 'Producto registrado correctamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('inventario.add')->with(['message' => 'Ocurrió un error al registrar el producto.', 'alert-type' => 'error']);

        }
    }
}
