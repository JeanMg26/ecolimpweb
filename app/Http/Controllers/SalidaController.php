<?php

namespace App\Http\Controllers;

use App\Models\MovimientoProducto;
use App\Models\Salida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SalidaController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:SALIDA-LISTAR')->only('index');
      $this->middleware('permission:SALIDA-CREAR')->only('create', 'store');
      $this->middleware('permission:SALIDA-EDITAR')->only('edit', 'update');
      $this->middleware('permission:SALIDA-ELIMINAR')->only('delete');
   }

   public function buscar_producto(Request $request)
   {
      $search = $request->get('producto');

      $producto_buscado = DB::table('productos')
         ->leftjoin('movimiento_productos as mv', 'mv.productos_id', '=', 'productos.id')
         ->select('productos.id as id_producto', 'productos.nombre as nom_producto', 'productos.codigo as cod_producto',
            'productos.presentacion as pres_producto',
            DB::raw('
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            as stock'
            ))
         ->where([
            ['productos.nombre', 'LIKE', '%' . $search . '%'],
            ['productos.deleted_at', null]
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

   public function datos_instalacion(Request $request)
   {
      $search = $request->get('instalacion');

      $instalacion_buscada = DB::table('instalaciones as ins')
         ->join('regiones as r', 'r.id', '=', 'ins.regiones_id')
         ->join('provincias as p', 'p.id', '=', 'ins.provincias_id')
         ->join('comunas as c', 'c.id', '=', 'ins.comunas_id')
         ->select('ins.*', 'r.nombre as region', 'p.nombre as provincia', 'c.nombre as comuna')
         ->where([
            ['ins.deleted_at', null],
            ['ins.estado', '1'],
            ['ins.nombre', 'LIKE', '%' . $search . '%']
         ])
         ->get();

      $instalaciones = [];
      foreach ($instalacion_buscada as $instalacion) {
         $instalaciones[] = [
            "id_instalacion"  => $instalacion->id,
            "nom_instalacion" => $instalacion->nombre,
            "nom_fantasia"    => $instalacion->nom_fantasia,
            "rut_instalacion" => $instalacion->nrodoc,
            "tel_instalacion" => $instalacion->telefono,
            "dir_instalacion" => $instalacion->direccion,
            "region"          => $instalacion->region,
            "provincia"       => $instalacion->provincia,
            "comuna"          => $instalacion->comuna,
            "nom_contacto"    => $instalacion->nom_contacto,
            "rut_contacto"    => $instalacion->nrodoc_contacto,
            "cel_contacto"    => $instalacion->cel_contacto
         ];
      }

      return response()->json($instalaciones);
   }

   public function buscar_instalaciones(Request $request)
   {
      $search = $request->get('instalacion');

      $instalacion_buscado = DB::table('instalaciones as ins')
         ->join('salidas as s', 's.instalaciones_id', '=', 'ins.id')
         ->select('ins.id as idInstalacion', 'ins.nombre as nomInstalacion', 'ins.nrodoc as rutInstalacion', 's.instalaciones_id as idInstalacionSalida')
         ->where([
            ['ins.deleted_at', null],
            ['ins.estado', '1'],
            ['s.deleted_at', null],
            ['ins.nombre', 'LIKE', '%' . $search . '%']
         ])
         ->groupBy('idInstalacionSalida')
         ->get();

      $instalaciones = [];
      foreach ($instalacion_buscado as $instalacion) {
         $instalaciones[] = [
            "id_instalacion"  => $instalacion->idInstalacion,
            "nom_instalacion" => $instalacion->nomInstalacion,
            "rut_instalacion" => $instalacion->rutInstalacion
         ];
      }

      return response()->json($instalaciones);
   }

   public function datatables(Request $request)
   {
      // ***********************************************************************************
      // *************************** BUSQUEDAS UNITARIAS ***********************************
      // ***********************************************************************************
      $salida_entrada = Salida::query();

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CENTRO DE COSTO *****************
      if (!empty($request->nomcc_buscar)) {
         $nomCCBuscar = $request->nomcc_buscar;

         $salida_entrada->join('instalaciones', 'instalaciones.id', '=', 'salidas.instalaciones_id')
            ->where('instalaciones.nombre', 'LIKE', '%' . $nomCCBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - RUT DEL CENTRO DE COSTO *****************
      if (!empty($request->rutcc_buscar)) {
         $rutCCBuscar = $request->rutcc_buscar;

         $salida_entrada->join('instalaciones', 'instalaciones.id', '=', 'salidas.instalaciones_id')
            ->where('instalaciones.nrodoc', 'LIKE', '%' . $rutCCBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - NÚMERO DE REGISTRO *****************
      if (!empty($request->num_registro)) {
         $nroRegistroBuscar = $request->num_registro;

         $salida_entrada
            ->where('salidas.codigo', 'LIKE', '%' . $nroRegistroBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - FECHA DE EMISION *****************
      if (!empty($request->fecInicial_buscar) && !empty($request->fecFinal_buscar)) {
         $fInicialBuscar = date('Y-m-d', strtotime($request->fecInicial_buscar));
         $fFifnalBuscar  = date('Y-m-d', strtotime($request->fecFinal_buscar));

         $salida_entrada->whereRaw("date(salidas.fecha_inicial) >= '" . $fInicialBuscar . "' AND date(salidas.fecha_inicial) <= '" . $fFifnalBuscar . "'");

      }

      // *******************************************************************************************
      // ********************** LLAMANDO AL DATATABLES *********************************************
      // *******************************************************************************************

      $salida = $salida_entrada->join('instalaciones as ins', 'ins.id', '=', 'salidas.instalaciones_id')
         ->leftjoin('movimiento_productos as mp', 'mp.salidas_id', '=', 'salidas.id')
         ->leftjoin('users as us', 'us.id', '=', 'salidas.creado_por')
         ->select('salidas.*', 'salidas.id as idSalida', 'salidas.codigo as codSalida', 'ins.nombre as nomInstalacion', 'ins.nrodoc as rutInstalacion', 'ins.telefono as telInstalacion', 'ins.direccion as dirInstalacion', 'salidas.fecha_inicial as fecInicio', 'us.name as respEntrega', 'salidas.recibido_por as respRecibio')
         ->groupBy('idSalida')
         ->where([
            ['salidas.deleted_at', null]
         ]);

      return DataTables::of($salida)
         ->addColumn('acciones', function ($salida) {
            '<div>';
            if (Auth::user()->can('SALIDA-LISTAR')) {
               $mostrar =
               '<a href="' . route("salidas.show", $salida->id) . '" class="btn btn-warning btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('SALIDA-EDITAR')) {
               $mostrar .=
               '<a href="' . route("salidas.edit", $salida->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('SALIDA-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $salida->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <span class="far fa-trash-alt fa-xs"></span>
                     </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addIndexColumn()
         ->rawColumns(['acciones'])
         ->make(true);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      $stock_actual = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->select('p.nombre as producto', 'p.cant_minima as cant_producto',
            DB::raw('
            SUM(CASE WHEN mp.tipo_movimiento = "INGRESO" THEN mp.cantidad ELSE 0 END) -
            SUM( CASE WHEN mp.tipo_movimiento = "EGRESO" THEN mp.cantidad ELSE "0" END)
            as stock'
            ))
         ->where([
            ['p.deleted_at', null],
            ['mp.deleted_at', null]
         ])
         ->groupBy('producto', 'cant_producto')
         ->get();

      foreach ($stock_actual as $producto) {

         if ($producto->stock <= $producto->cant_producto) {
            toastr()->info($producto->producto . ' - ' . $producto->stock . ' unidades', 'Limite de Stock', [
               'timeOut'     => 15000,
               'closeButton' => true
            ]);
         }
      }

      return view('salidas.index');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $creado_por = Auth::user()->name;

      $salida = Salida::all();

      if ($salida->isEmpty()) {
         $num_registro = 'EM-1';
      } else {
         $ultimo_id    = Salida::latest('id')->first();
         $num_registro = 'EM-' . ($ultimo_id->id + 1);
      }

      return view('salidas.create', compact('creado_por', 'num_registro'));
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
            'cod_salida'         => 'required',
            'nom_cc'             => 'required',
            'id_cc'              => 'required',
            'fecha_inicio'       => 'required',
            'fecha_fin'          => 'required',
            'recibido_por'       => 'required',
            'observaciones'      => 'nullable|max:200',

            'producto_id.*'      => 'required',
            'producto_ingreso.*' => 'required',
            'cantidad_ingreso.*' => 'required|numeric'
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $salida                   = new Salida();
         $salida->instalaciones_id = $request->id_cc;
         $salida->codigo           = $request->cod_salida;
         $salida->fecha_inicial    = date('Y-m-d', strtotime($request->fecha_inicio));
         $salida->fecha_final      = date('Y-m-d', strtotime($request->fecha_fin));
         $salida->recibido_por     = strtoupper($request->recibido_por);
         $salida->observaciones    = strtoupper($request->observaciones);
         $salida->creado_por       = Auth()->user()->id;
         $salida->save();

         $contador = count(collect($request->cantidad_ingreso));

         for ($i = 0; $i < $contador; $i++) {

            $mov_producto                  = new MovimientoProducto();
            $mov_producto->salidas_id      = $salida->id;
            $mov_producto->productos_id    = $request->producto_id[$i];
            $mov_producto->tipo_movimiento = 'EGRESO';
            $mov_producto->cantidad        = $request->cantidad_ingreso[$i];
            $mov_producto->save();
         }

         toastr()->success('Registro agregado correctamente');
         return response()->json(['success' => $salida->id]);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(Salida $salida)
   {
      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('salidas as s', 's.id', '=', 'mp.salidas_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.salidas_id', $salida->id)
         ->get();

      $instalacion = DB::table('instalaciones')
         ->where([
            ['instalaciones.estado', '1'],
            ['instalaciones.deleted_at', null]
         ])
         ->pluck('nombre', 'id')
         ->toArray();

      return view('salidas.show', compact('salida', 'mov_productos', 'instalacion'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Salida $salida)
   {
      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('salidas as s', 's.id', '=', 'mp.salidas_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.salidas_id', $salida->id)
         ->get();

      $instalacion = DB::table('instalaciones')
         ->where([
            ['instalaciones.estado', '1'],
            ['instalaciones.deleted_at', null]
         ])
         ->pluck('nombre', 'id')
         ->toArray();

      return view('salidas.edit', compact('salida', 'mov_productos', 'instalacion'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Salida $salida)
   {
      if ($request->ajax()) {

         $rules = [
            'cod_salida'         => 'required',
            'nom_cc'             => 'required',
            'id_cc'              => 'required',
            'fecha_inicio'       => 'required',
            'fecha_fin'          => 'required',
            'recibido_por'       => 'required',
            'observaciones'      => 'nullable|max:200',

            'producto_id.*'      => 'required',
            'producto_ingreso.*' => 'required',
            'cantidad_ingreso.*' => 'required|numeric'
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $salida                   = Salida::find($request->id_salida);
         $salida->instalaciones_id = $request->id_cc;
         $salida->codigo           = $salida->codigo;
         $salida->fecha_inicial    = date('Y-m-d', strtotime($request->fecha_inicio));
         $salida->fecha_final      = date('Y-m-d', strtotime($request->fecha_fin));
         $salida->recibido_por     = strtoupper($request->recibido_por);
         $salida->observaciones    = strtoupper($request->observaciones);
         $salida->editado_por      = Auth()->user()->id;
         $salida->save();

         $contador = count(collect($request->cantidad_ingreso));

         for ($i = 0; $i < $contador; $i++) {

            $mov_producto                  = MovimientoProducto::find($request->mvproducto_id[$i]);
            $mov_producto->ingresos_id     = $mov_producto->ingresos_id;
            $mov_producto->productos_id    = $request->producto_id[$i];
            $mov_producto->tipo_movimiento = $mov_producto->tipo_movimiento;
            $mov_producto->cantidad        = $request->cantidad_ingreso[$i];
            $mov_producto->save();

         }

         toastr()->success('Registro actualizado correctamente');
         return response()->json(['success' => $salida->id]);
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
      $salida = Salida::findOrFail($id);

      // Buscar los id de los productos ingresados
      $id_mov_productos = DB::table('movimiento_productos as mp')
         ->join('salidas as s', 's.id', '=', 'mp.salidas_id')
         ->select('mp.id as idMProducto')
         ->where('mp.salidas_id', $salida->id)
         ->pluck('idMProducto');

      // Recorrer y actualizar (no eliminar - agregar fecha a deleted_at) los productos ingresado
      $contador = count(collect($id_mov_productos));

      for ($i = 0; $i < $contador; $i++) {
         $mov_producto                  = MovimientoProducto::find($id_mov_productos[$i]);
         $mov_producto->salidas_id      = $mov_producto->salidas_id;
         $mov_producto->productos_id    = $mov_producto->productos_id;
         $mov_producto->tipo_movimiento = 'ELIMINADO';
         $mov_producto->cantidad        = $mov_producto->cantidad;
         $mov_producto->deleted_at      = date("Y-m-d H:i:s");
         $mov_producto->save();

      }

      $salida->delete();
   }

   public function impresion_pdf(Request $request)
   {

      $salida = Salida::find($request->salida_id);

      $mov_productos = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->join('salidas as s', 's.id', '=', 'mp.salidas_id')
         ->select('mp.*', 'mp.id as idMProducto', 'p.nombre as nomProducto', 'p.id as idProducto', 'p.presentacion as presProducto',
            DB::raw('
            (SELECT
            SUM(CASE WHEN mv.tipo_movimiento = "INGRESO" THEN mv.cantidad ELSE 0 END) -
            SUM( CASE WHEN mv.tipo_movimiento = "EGRESO" THEN mv.cantidad ELSE "0" END)
            FROM movimiento_productos as mv
            WHERE p.id =  mv.productos_id)
            as stock')
         )
         ->where('mp.salidas_id', $salida->id)
         ->get();

      $pdf = app('dompdf.wrapper');
      $pdf->loadView('salidas.impresion', compact('salida', 'mov_productos'));
      return $pdf->download('EM00' . $salida->id . '.pdf');
   }
}
