<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\ProductoLote;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\SucursalProductoLote;

class VentasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $s = request('s');
        $query = request('s') != '' ? "(nombre like '%$s%' || codigo like '%$s%')" : 1;

        $compras = Compra::with(['detalle.producto_lote.producto', 'proveedor', 'user'])->orderBy('id', 'DESC')->paginate();
        return view('ventas.ventas-browse', compact('compras', 's'));
    }

    public function create(){
        $sucursales = Sucursal::where('deleted_at', NULL)->get();
        $clientes = Cliente::where('deleted_at', NULL)->get();

        // Obetener sucursal del usuario
        $sucursal_id = Auth::user()->sucursal_id;
        if(!$sucursal_id && count($sucursales) > 0){
            $sucursal_id = $sucursales[0]->id;
            User::where('id', Auth::user()->id)->update(['sucursal_id' => $sucursal_id]);
        }

        // $productos = Producto::where('deleted_at', NULL)->where('estado', 1)->get();
        $productos = SucursalProductoLote::with(['lote.producto'])->where('sucursal_id', $sucursal_id)->get();
        // dd($productos);
        return view('ventas.ventas-add', compact('sucursales', 'sucursal_id', 'clientes', 'productos'));
    }

    public function store(Request $request){
    
        // dd($request);
        DB::beginTransaction();
        try {

            $compra = Compra::create([
                'user_id' => Auth::user()->id,
                'proveedore_id' => $request->proveedor_id,
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
            return redirect()->route('ventas.index')->with(['message' => 'Producto registrado correctamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('ventas.add')->with(['message' => 'Ocurrió un error al registrar el producto.', 'alert-type' => 'error']);

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
}
