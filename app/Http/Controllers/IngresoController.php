<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\MovimientoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class IngresoController extends Controller
{
   public function __construct()
   {
      $this->middleware('permission:INGRESO-LISTAR')->only('index');
      $this->middleware('permission:INGRESO-CREAR')->only('create', 'store');
      $this->middleware('permission:INGRESO-EDITAR')->only('edit', 'update');
      $this->middleware('permission:INGRESO-ELIMINAR')->only('delete');
   }

   public function datos_proveedor(Request $request)
   {
      $search = $request->get('proveedor');

      $proveedor_buscado = DB::table('proveedores as pv')
         ->join('regiones as r', 'r.id', '=', 'pv.regiones_id')
         ->join('provincias as p', 'p.id', '=', 'pv.provincias_id')
         ->join('comunas as c', 'c.id', '=', 'pv.comunas_id')
         ->select('pv.*', 'r.nombre as region', 'p.nombre as provincia', 'c.nombre as comuna')
         ->where([
            ['pv.deleted_at', null],
            ['pv.estado', '1'],
            ['pv.nombre', 'LIKE', '%' . $search . '%']
         ])
         ->get();

      $proveedores = [];
      foreach ($proveedor_buscado as $proveedor) {
         $proveedores[] = [
            "id_proveedor"  => $proveedor->id,
            "nom_proveedor" => $proveedor->nombre,
            "nom_fantasia"  => $proveedor->nom_fantasia,
            "rut_proveedor" => $proveedor->nrodoc,
            "tel_proveedor" => $proveedor->telefono,
            "dir_proveedor" => $proveedor->direccion,
            "nom_contacto"  => $proveedor->nom_contacto,
            "rut_contacto"  => $proveedor->nrodoc_contacto,
            "cel_contacto"  => $proveedor->cel_contacto,
            "region"        => $proveedor->region,
            "provincia"     => $proveedor->provincia,
            "comuna"        => $proveedor->comuna
         ];
      }

      return response()->json($proveedores);
   }

   public function buscar_producto(Request $request)
   {
      $search = $request->get('producto');

      $producto_buscado = DB::table('productos')
         ->leftjoin('movimiento_productos as mv', 'mv.productos_id', '=', 'productos.id')
         ->leftjoin('categorias as cat', 'cat.id', '=', 'productos.categorias_id')
         ->select('productos.id as id_producto', 'productos.nombre as nom_producto', 'productos.codigo as cod_producto',
            'productos.presentacion as pres_producto',
            DB::raw('
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            as stock'
            ))
         ->where([
            ['productos.nombre', 'LIKE', '%' . $search . '%'],
            ['productos.deleted_at', null],
            ['cat.deleted_at', null]
         ])
         ->groupBy('id_producto', 'nom_producto', 'cod_producto', 'pres_producto')
         ->get();

      $productos = [];
      foreach ($producto_buscado as $producto) {
         $productos[] = [
            "id_producto"    => $producto->id_producto,
            "nom_producto"   => $producto->nom_producto,
            "cod_producto"   => $producto->cod_producto,
            "pres_producto"  => $producto->pres_producto,
            "stock_producto" => $producto->stock
         ];
      }

      return response()->json($productos);
   }

   public function buscar_proveedor(Request $request)
   {
      $search = $request->get('producto');

      $proveedor_buscado = DB::table('proveedores as pv')
         ->join('ingresos as in', 'in.proveedores_id', '=', 'pv.id')
         ->select('pv.id as idProveedor', 'pv.nombre as nomProveedor', 'pv.nrodoc as rutProveedor', 'in.proveedores_id as ingresoProvID')
         ->where('nombre', 'LIKE', '%' . $search . '%')
         ->groupBy('ingresoProvID')
         ->get();

      $proveedores = [];
      foreach ($proveedor_buscado as $proveedor) {
         $proveedores[] = [
            "id_proveedor"  => $proveedor->idProveedor,
            "nom_proveedor" => $proveedor->nomProveedor,
            "rut_proveedor" => $proveedor->rutProveedor
         ];
      }

      return response()->json($proveedores);
   }

   public function datatables(Request $request)
   {
      // ***********************************************************************************
      // *************************** BUSQUEDAS UNITARIAS ***********************************
      // ***********************************************************************************
      $ingreso_entrada = Ingreso::query();

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL PROVEEDOR *****************
      if (!empty($request->nomproveedor_buscar)) {
         $nomProveedorBuscar = $request->nomproveedor_buscar;

         $ingreso_entrada->join('proveedores as pv', 'pv.id', '=', 'ingresos.proveedores_id')
            ->where('pv.nombre', 'LIKE', '%' . $nomProveedorBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - RUT DEL PROVEEDOR *****************
      if (!empty($request->rutproveedor_buscar)) {
         $rutProveedorBuscar = $request->rutproveedor_buscar;

         $ingreso_entrada->join('proveedores as pv', 'pv.id', '=', 'ingresos.proveedores_id')
            ->where('pv.nrodoc', 'LIKE', '%' . $rutProveedorBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - TIPO DE DOCUMENTO DE INGRESO *****************
      if (!empty($request->tipodoc_buscar)) {
         $tipodocBuscar = $request->tipodoc_buscar;

         $ingreso_entrada
            ->where('ingresos.tipodoc', $tipodocBuscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - NÚMERO DE DOCUMENTO DE INGRESO *****************
      if (!empty($request->nrodoc_buscar)) {
         $nrodocBuscar = $request->nrodoc_buscar;

         $ingreso_entrada
            ->where('ingresos.nrodoc', 'LIKE', '%' . $nrodocBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - NÚMERO DE REGISTRO *****************
      if (!empty($request->num_registro)) {
         $nroRegistroBuscar = $request->num_registro;

         $ingreso_entrada
            ->where('ingresos.codigo', 'LIKE', '%' . $nroRegistroBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - FECHA DE EMISION *****************
      if (!empty($request->fecInicial_buscar) && !empty($request->fecFinal_buscar)) {
         $fInicialBuscar = date('Y-m-d', strtotime($request->fecInicial_buscar));
         $fFifnalBuscar  = date('Y-m-d', strtotime($request->fecFinal_buscar));

         $ingreso_entrada->whereRaw("date(ingresos.fecha_emision) >= '" . $fInicialBuscar . "' AND date(ingresos.fecha_emision) <= '" . $fFifnalBuscar . "'");
      }

      // *******************************************************************************************
      // ********************** LLAMANDO AL DATATABLES *********************************************
      // *******************************************************************************************

      $ingreso = $ingreso_entrada->join('proveedores as pr', 'pr.id', '=', 'ingresos.proveedores_id')
         ->join('movimiento_productos as mp', 'mp.ingresos_id', '=', 'ingresos.id')
         ->select('ingresos.*', 'ingresos.id as ingresoID', 'pr.nombre as proveedorN', 'pr.nrodoc as proveedorRUT', DB::raw('SUM(total) as sumTotal'))
         ->groupBy('ingresoID')
         ->where([
            ['pr.deleted_at', null],
            // ['pr.estado', '1'],
            ['ingresos.deleted_at', null]
         ]);

      return DataTables::of($ingreso)
         ->addColumn('acciones', function ($ingreso) {
            '<div>';
            if (Auth::user()->can('INGRESO-LISTAR')) {
               $mostrar =
               '<a href="' . route("ingresos.show", $ingreso->id) . '" class="btn btn-warning btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('INGRESO-EDITAR')) {
               $mostrar .=
               '<a href="' . route("ingresos.edit", $ingreso->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('INGRESO-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $ingreso->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <span class="far fa-trash-alt fa-xs"></span>
                     </button>';
            }
            '</div>';
            return $mostrar;
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

      $tipodocumento = DB::table('ingresos')
         ->select('ingresos.*')
         ->pluck('tipodoc', 'tipodoc')
         ->toArray();

      return view('ingresos.index', compact('tipodocumento'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $proveedor = DB::table('proveedores')
         ->where([
            ['proveedores.estado', '1'],
            ['proveedores.deleted_at', null]
         ])
         ->pluck('nombre', 'id')
         ->toArray();

      $ingreso = Ingreso::all();

      if ($ingreso->isEmpty()) {
         $num_registro = 'RM-1';
      } else {
         $ultimo_id    = Ingreso::latest('id')->first();
         $num_registro = 'RM-' . ($ultimo_id->id + 1);
      }

      return view('ingresos.create', compact('proveedor', 'num_registro'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

      if ($request->ajax()) {

         $rules = [
            'nom_proveedor'      => 'required',
            'id_proveedor'       => 'required',
            'tipodoc_ingreso'    => 'required',
            'nrodoc_ingreso'     => 'required',
            'fec_emision'        => 'required',
            'observaciones'      => 'nullable|max:200',

            'producto_id.*'      => 'required',
            'producto_ingreso.*' => 'required',
            'cantidad_ingreso.*' => 'required|numeric',
            'precio_unitario.*'  => 'required|numeric'
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $ingreso                 = new Ingreso();
         $ingreso->proveedores_id = $request->id_proveedor;
         $ingreso->codigo         = $request->cod_ingreso;
         $ingreso->tipodoc        = $request->tipodoc_ingreso;
         $ingreso->nrodoc         = strtoupper($request->nrodoc_ingreso);
         $ingreso->observaciones  = strtoupper($request->observaciones);
         $ingreso->fecha_emision  = date('Y-m-d', strtotime($request->fec_emision));
         $ingreso->creado_por     = Auth()->user()->id;
         $ingreso->save();

         // $id_ingreso = $ingreso->id;

         $contador = count(collect($request->cantidad_ingreso));

         for ($i = 0; $i < $contador; $i++) {

            $total[$i] = ((float) $request->cantidad_ingreso[$i] * (float) $request->precio_unitario[$i]);

            $mov_producto                  = new MovimientoProducto();
            $mov_producto->ingresos_id     = $ingreso->id;
            $mov_producto->productos_id    = $request->producto_id[$i];
            $mov_producto->tipo_movimiento = 'INGRESO';
            $mov_producto->cantidad        = $request->cantidad_ingreso[$i];
            $mov_producto->precio_unitario = $request->precio_unitario[$i];
            $mov_producto->total           = $total[$i];
            $mov_producto->save();
         }

         toastr()->success('Registro agregado correctamente');
         return response()->json(['success' => $ingreso->id]);
      }

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Ingreso  $ingreso
    * @return \Illuminate\Http\Response
    */
   public function show(Ingreso $ingreso)
   {
      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('ingresos as in', 'in.id', '=', 'mp.ingresos_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.ingresos_id', $ingreso->id)
         ->get();

      return view('ingresos.show', compact('ingreso', 'mov_productos'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Ingreso  $ingreso
    * @return \Illuminate\Http\Response
    */
   public function edit(Ingreso $ingreso)
   {
      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('ingresos as in', 'in.id', '=', 'mp.ingresos_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.ingresos_id', $ingreso->id)
         ->get();

      $proveedor = DB::table('proveedores')
         ->where([
            ['proveedores.estado', '1'],
            ['proveedores.deleted_at', null]
         ])
         ->pluck('nombre', 'id')
         ->toArray();

      $tipodoc = DB::table('ingresos')
         ->pluck('tipodoc', 'tipodoc')
         ->toArray();

      return view('ingresos.edit', compact('ingreso', 'mov_productos', 'tipodoc', 'proveedor'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Ingreso  $ingreso
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Ingreso $ingreso)
   {

      if ($request->ajax()) {

         $rules = [
            'nom_proveedor'      => 'required',
            'id_proveedor'       => 'required',
            'tipodoc_ingreso'    => 'required',
            'nrodoc_ingreso'     => 'required',
            'fec_emision'        => 'required',
            'observaciones'      => 'nullable|max:200',

            'producto_id.*'      => 'required',
            'producto_ingreso.*' => 'required',
            'cantidad_ingreso.*' => 'required|numeric',
            'precio_unitario.*'  => 'required|numeric'
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $ingreso                 = Ingreso::find($request->id_ingreso);
         $ingreso->proveedores_id = $request->id_proveedor;
         $ingreso->codigo         = $ingreso->codigo;
         $ingreso->tipodoc        = $request->tipodoc_ingreso;
         $ingreso->nrodoc         = strtoupper($request->nrodoc_ingreso);
         $ingreso->observaciones  = strtoupper($request->observaciones);
         $ingreso->fecha_emision  = date('Y-m-d', strtotime($request->fec_emision));
         $ingreso->editado_por    = Auth()->user()->id;
         $ingreso->save();

         $contador = count(collect($request->cantidad_ingreso));
         // dd($request->mvproducto_id);
         for ($i = 0; $i < $contador; $i++) {

            $total[$i] = ((float) $request->cantidad_ingreso[$i] * (float) $request->precio_unitario[$i]);

            $mov_producto                  = MovimientoProducto::findOrFail($request->mvproducto_id[$i]);
            $mov_producto->ingresos_id     = $mov_producto->ingresos_id;
            $mov_producto->productos_id    = $request->producto_id[$i];
            $mov_producto->tipo_movimiento = $mov_producto->tipo_movimiento;
            $mov_producto->cantidad        = $request->cantidad_ingreso[$i];
            $mov_producto->precio_unitario = $request->precio_unitario[$i];
            $mov_producto->total           = $total[$i];
            $mov_producto->save();

         }
         toastr()->info('Registro actualizado correctamente');
         return response()->json(['success' => $ingreso->id]);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Ingreso  $ingreso
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $ingreso = Ingreso::findOrFail($id);

      $productos_id = [];
      foreach ($ingreso->mov_producto as $producto) {

         $productos_id[] = DB::table('movimiento_productos as mp')
            ->where([
               ['mp.productos_id', $producto->productos_id],
               ['mp.tipo_movimiento', 'EGRESO']
            ])
            ->pluck('mp.productos_id', 'mp.tipo_movimiento')
            ->toArray();

      }

      if (!empty($productos_id['0'])) {
         return response()->json(['mensaje' => 'No se pudo eliminar, este registro contiene egresos de productos.', 'icono' => 'warning']);
      } else {

         // Buscar los id de los productos ingresados
         $id_mov_productos = DB::table('movimiento_productos as mp')
            ->join('ingresos as in', 'in.id', '=', 'mp.ingresos_id')
            ->select('mp.id as idMProducto')
            ->where('mp.ingresos_id', $ingreso->id)
            ->pluck('idMProducto');

         // Recorrer y actualizar (no eliminar - agregar fecha a deleted_at) los productos ingresado
         $contador = count(collect($id_mov_productos));

         for ($i = 0; $i < $contador; $i++) {
            $mov_producto                  = MovimientoProducto::find($id_mov_productos[$i]);
            $mov_producto->ingresos_id     = $mov_producto->ingresos_id;
            $mov_producto->productos_id    = $mov_producto->productos_id;
            $mov_producto->tipo_movimiento = 'ELIMINADO';
            $mov_producto->cantidad        = $mov_producto->cantidad;
            $mov_producto->precio_unitario = $mov_producto->precio_unitario;
            $mov_producto->total           = $mov_producto->total;
            $mov_producto->deleted_at      = date("Y-m-d H:i:s");
            $mov_producto->save();
         }

         $ingreso->delete();
         return response()->json(['mensaje' => 'Registro eliminado correctamente.', 'icono' => 'error']);
      }

   }

   public function impresion_pdf(Request $request)
   {

      $ingreso = Ingreso::find($request->ingreso_id);

      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('ingresos as in', 'in.id', '=', 'mp.ingresos_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.ingresos_id', $ingreso->id)
         ->get();

      $pdf = app('dompdf.wrapper');
      $pdf->loadView('ingresos.impresion', compact('ingreso', 'mov_productos'));
      return $pdf->download('RM00' . $ingreso->id . '.pdf');

   }
}
