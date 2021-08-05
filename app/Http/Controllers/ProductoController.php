<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoCRequest;
use App\Http\Requests\ProductoERequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductoController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:PRODUCTO-LISTAR')->only('index');
      $this->middleware('permission:PRODUCTO-CREAR')->only('create', 'store');
      $this->middleware('permission:PRODUCTO-EDITAR')->only('edit', 'update');
      $this->middleware('permission:PRODUCTO-ELIMINAR')->only('delete');
   }

   public function filtrar_producto(Request $request)
   {
      $search = $request->get('producto');

      $producto_buscado = Producto::where('nombre', 'LIKE', '%' . $search . '%')->get();

      $productos = [];
      foreach ($producto_buscado as $producto) {
         $productos[] = [
            "id_producto"  => $producto->id,
            "nom_producto" => $producto->nombre,
            "cod_producto" => $producto->codigo
         ];
      }

      return response()->json($productos);
   }

   public function datatables(Request $request)
   {

      // ***********************************************************************************
      // *************************** BUSQUEDAS UNITARIAS ***********************************
      // ***********************************************************************************
      $producto_entrada = Producto::query();

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL PRODUCTO *****************
      if (!empty($request->nomproucto_buscar)) {
         $nomProductoBuscar = $request->nomproucto_buscar;

         $producto_entrada
            ->where('productos.nombre', 'LIKE', '%' . $nomProductoBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - CODIGO DEL PRODUCTO *****************
      if (!empty($request->codproducto_buscar)) {
         $codProductoBuscar = $request->codproducto_buscar;

         $producto_entrada
            ->where('productos.codigo', 'LIKE', '%' . $codProductoBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - CATEGORIA DEL PRODUCTO *****************
      if (!empty($request->categoria_buscar)) {
         $catProductoBuscar = $request->categoria_buscar;

         $producto_entrada
            ->join('categorias', 'categorias.id', '=', 'productos.categorias_id')
            ->where('categorias.nombre', $catProductoBuscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - ESTADO DEL PRODUCTO *****************
      $estProductoBuscar = $request->estado_buscar;

      if ($estProductoBuscar == '0' || $estProductoBuscar == '1') {
         $producto_entrada->where('productos.estado', $estProductoBuscar);
      }

      // *********** BUSQUEDAS UNITARIAS - FECHA DE EMISION *****************
      if (!empty($request->stock_mayor) && !empty($request->stock_menor)) {
         $stockMayorBuscar  = $request->stock_mayor;
         $stockMenorrBuscar = $request->stock_menor;

         $producto_entrada
            ->having('stock', '>=', $stockMayorBuscar)
            ->having('stock', '<=', $stockMenorrBuscar);
      }

      // ******************** FIN DE BUSQUEDAS UNITARIAS *************************

      $producto = $producto_entrada
         ->leftjoin('categorias as cat', 'cat.id', '=', 'productos.categorias_id')
         ->leftjoin('movimiento_productos as mv', 'mv.productos_id', '=', 'productos.id')
         ->select('productos.id as idProducto', 'productos.nombre as nomProducto', 'productos.codigo as codProducto', 'productos.rutaimagen as imgProducto', 'productos.presentacion as presProducto', 'productos.estado as estProducto', 'productos.cant_minima as cantProducto', 'cat.nombre as nomCategoria',
            DB::raw('
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            as stock'
            ))
         ->where([
            ['productos.deleted_at', null],
            ['cat.deleted_at', null]
         ])
         ->groupBy('idProducto', 'nomProducto', 'codProducto', 'imgProducto', 'presProducto', 'estProducto', 'nomCategoria');

      return DataTables::of($producto)
         ->addColumn('acciones', function ($producto) {
            '<div>';
            if (Auth::user()->can('PRODUCTO-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $producto->idProducto . '" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PRODUCTO-EDITAR')) {
               $mostrar .=
               '<a href="' . route("productos.edit", $producto->idProducto) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('PRODUCTO-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $producto->idProducto . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($producto) {
            if (Auth::user()->can('PRODUCTO-EDITAR')) {
               if ($producto->estProducto == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $producto->idProducto . '" id="producto' . $producto->idProducto . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }
               if ($producto->estProducto == '0') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $producto->idProducto . '" id="producto' . $producto->idProducto . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                  </div>';
               }
            } else {
               if ($producto->estProducto == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($producto->estProducto == '0') {
                  return
                     '<button type="button" class="btn btn-danger btn-sm btn-accion2"><i class="far fa-times"></i></button>';
               }
            }
         })
         ->addIndexColumn()
         ->rawColumns(['acciones', 'checkbox-estado'])
         ->make(true);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $categoria = DB::table('categorias')
         ->join('productos', 'productos.categorias_id', '=', 'categorias.id')
         ->select('categorias.*')
         ->where([
            ['categorias.estado', 1]
         ])
         ->pluck('nombre', 'nombre')
         ->toArray();

      $estado = DB::table('productos')
         ->select('productos.*', DB::raw('(CASE WHEN estado = "1" THEN "ACTIVO" ELSE "INACTIVO" END) as nom_estado'))
         ->orderBy('nom_estado', 'asc')
         ->pluck('nom_estado', 'estado')
         ->toArray();

      return view('productos.index', compact('categoria', 'estado'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $categoria = Categoria::where('estado', 1)->orderBy('nombre')->pluck('nombre', 'id')->toArray();
      return view('productos.create', ['categoria' => $categoria]);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(ProductoCRequest $request)
   {
      $producto                = new Producto();
      $producto->codigo        = strtoupper($request->cod_producto);
      $producto->nombre        = strtoupper($request->nom_producto);
      $producto->presentacion  = strtoupper($request->presen_producto);
      $producto->cant_minima   = $request->cant_minima;
      $producto->descripcion   = strtoupper($request->des_producto);
      $producto->categorias_id = $request->categoria;
      $producto->estado        = $request->est_producto;
      $producto->user_ing      = Auth::user()->id;
      // **** COMPROBAR IMAGEN ****
      if ($request->file('img_producto') == null) {
         $producto->rutaimagen = "";
      } else {
         $producto->rutaimagen = $request->file('img_producto')->store('productos');
      }
      $producto->save();
      toastr()->success('Registro agregado correctamente.');
      return redirect('productos');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      if (request()->ajax()) {

         $producto  = Producto::findOrFail($id);
         $categoria = Categoria::findOrFail($producto->categorias_id);

         return response()->json(['producto' => $producto, 'categoria' => $categoria]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $producto  = Producto::findOrFail($id);
      $categoria = Categoria::where('estado', 1)->orderBy('nombre')->pluck('nombre', 'id')->toArray();

      return view('productos.edit', compact('categoria', 'producto'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(ProductoERequest $request, $id)
   {

      $producto                = Producto::findOrFail($id);
      $producto->codigo        = strtoupper($request->cod_producto);
      $producto->nombre        = strtoupper($request->nom_producto);
      $producto->presentacion  = strtoupper($request->presen_producto);
      $producto->cant_minima   = $request->cant_minima;
      $producto->descripcion   = strtoupper($request->des_producto);
      $producto->categorias_id = $request->categoria;
      $producto->estado        = $request->est_producto;
      $producto->user_ing      = Auth::user()->id;
      // **** COMPROBAR IMAGEN ****
      if ($request->file('img_producto') == null) {
         $producto->rutaimagen = $producto->rutaimagen;
      } else {
         $producto->rutaimagen = $request->file('img_producto')->store('productos');
      }
      $producto->save();
      toastr()->success('Registro actualizado correctamente.');
      return redirect('productos');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $producto = Producto::findOrFail($id);
      $ingreso  = DB::table('ingresos as in')
         ->join('movimiento_productos as mp', 'mp.ingresos_id', '=', 'in.id')
         ->where([
            ['in.deleted_at', null],
            ['mp.deleted_at', null],
            ['mp.productos_id', $id]
         ])
         ->exists();

      if ($ingreso) {
         return response()->json(['mensaje' => 'No se pudo eliminar, el producto tiene un ingreso.', 'icono' => 'warning']);
      } else {
         $producto->delete();
         return response()->json(['mensaje' => 'Producto eliminado correctamente.', 'icono' => 'error']);
      }
   }

   public function cambiarEstadoProducto(Request $request)
   {

      $producto                = Producto::find($request->producto_id);
      $producto->codigo        = $producto->codigo;
      $producto->nombre        = $producto->nombre;
      $producto->presentacion  = $producto->presentacion;
      $producto->descripcion   = $producto->descripcion;
      $producto->categorias_id = $producto->categorias_id;
      $producto->estado        = $request->estado;
      $producto->user_ing      = Auth::user()->id;
      $producto->save();
      return response()->json(['success' => 'Estado actualizado correctamente.']);
   }

   public function nuevaCaegoria(Request $request)
   {

      $rules = [
         'nom_categoria' => 'required|max:40|unique:categorias,nombre',
         'est_categoria' => 'required'
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $categoria = Categoria::create([
         'nombre' => strtoupper($request->nom_categoria),
         'estado' => $request->est_categoria
      ]
      );

      $cat_id     = $categoria->id;
      $nombre_cat = $categoria->nombre;

      return response()->json(['success' => 'Registro agregado correctamente.', 'cat_id' => $cat_id, 'nombre_cat' => $nombre_cat]);

   }
}
