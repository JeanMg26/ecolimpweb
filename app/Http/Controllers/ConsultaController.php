<?php

namespace App\Http\Controllers;

use App\Models\MovimientoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ConsultaController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:CONSULTA-LISTAR')->only('index');
      $this->middleware('permission:CONSULTA-DETALLE')->only('show');
      $this->middleware('permission:CONSULTA-CREAR')->only('create', 'store');
      $this->middleware('permission:CONSULTA-EDITAR')->only('edit', 'update');
      $this->middleware('permission:CONSULTA-ELIMINAR')->only('delete');
   }

   public function buscar_producto(Request $request)
   {
      $search = $request->get('producto');

      $producto_buscado = DB::table('productos as p')
         ->join('movimiento_productos as mp', 'mp.productos_id', 'p.id')
         ->join('salidas as s', 's.id', 'mp.salidas_id')
         ->select('p.id as id_producto', 'p.nombre as nom_producto', 'p.codigo as cod_producto', 'p.presentacion as pres_producto')
         ->where([
            ['s.deleted_at', null],
            ['nombre', 'LIKE', '%' . $search . '%']
         ])
         ->groupBy('p.id')
         ->get();

      $productos = [];
      foreach ($producto_buscado as $producto) {
         $productos[] = [
            "id_producto"   => $producto->id_producto,
            "nom_producto"  => $producto->nom_producto,
            "cod_producto"  => $producto->cod_producto,
            "pres_producto" => $producto->pres_producto
         ];
      }

      return response()->json($productos);
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
      $salida_entrada = MovimientoProducto::query();

      // *********** BUSQUEDAS UNITARIAS - CODIGO DEL PRODUCTO *****************
      if (!empty($request->codproducto_buscar)) {
         $nomProductoBuscar = $request->codproducto_buscar;

         $salida_entrada
            ->leftjoin('productos as pr1', 'pr1.id', '=', 'movimiento_productos.productos_id')
            ->where('pr1.codigo', $nomProductoBuscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL PRODUCTO *****************
      if (!empty($request->nomproducto_buscar)) {
         $nomProductoBuscar = $request->nomproducto_buscar;

         $salida_entrada
            ->leftjoin('productos as pr2', 'pr2.id', '=', 'movimiento_productos.productos_id')
            ->where([
               ['pr2.nombre', 'LIKE', '%' . $nomProductoBuscar . '%']
            ]);
      }

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CENTRO DE COSTO *****************
      if (!empty($request->nomcc_buscar)) {
         $nomCCBuscar = $request->nomcc_buscar;

         $salida_entrada
            ->leftjoin('salidas as s1', 's1.id', '=', 'movimiento_productos.salidas_id')
            ->leftjoin('instalaciones as ins1', 'ins1.id', '=', 's1.instalaciones_id')
            ->where('ins1.nombre', 'LIKE', '%' . $nomCCBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - RUT DEL CENTRO DE COSTO *****************
      if (!empty($request->rutcc_buscar)) {
         $rutCCBuscar = $request->rutcc_buscar;

         $salida_entrada
            ->leftjoin('salidas as s2', 's2.id', '=', 'movimiento_productos.salidas_id')
            ->leftjoin('instalaciones as ins2', 'ins2.id', '=', 's2.instalaciones_id')
            ->where('ins2.nrodoc', 'LIKE', '%' . $rutCCBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - RESPONSABLE DE ENTREGA *****************
      if (!empty($request->entregado_por)) {
         $resEntregaBuscar = $request->entregado_por;

         $salida_entrada
            ->leftjoin('salidas as s3', 's3.id', '=', 'movimiento_productos.salidas_id')
            ->where('s3.creado_por', 'LIKE', '%' . $resEntregaBuscar . '%')
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - FECHA DE EMISION *****************
      if (!empty($request->fecInicial_buscar) && !empty($request->fecFinal_buscar)) {
         $fInicialBuscar = date('Y-m-d', strtotime($request->fecInicial_buscar));
         $fFifnalBuscar  = date('Y-m-d', strtotime($request->fecFinal_buscar));

         $salida_entrada
            ->leftjoin('salidas as s4', 's4.id', '=', 'movimiento_productos.salidas_id')
            // ->whereRaw("date(s4.fecha_inicial) >= '" . $fInicialBuscar . "' AND date(s4.fecha_inicial) <= '" . $fFifnalBuscar . "'");
            ->whereDate('s4.fecha_inicial', '>=', $fInicialBuscar)
            ->whereDate('s4.fecha_inicial', '<=', $fFifnalBuscar);
      }

      // *******************************************************************************************
      // ********************** LLAMANDO AL DATATABLES *********************************************
      // *******************************************************************************************

      $salida = $salida_entrada
         ->join('salidas as s', 's.id', '=', 'movimiento_productos.salidas_id')
         ->leftjoin('users as us', 'us.id', '=', 's.creado_por')
         ->leftjoin('instalaciones as ins', 'ins.id', '=', 's.instalaciones_id')
         ->leftjoin('productos as p', 'p.id', '=', 'movimiento_productos.productos_id')
         ->select('p.codigo as codProducto', 'p.nombre as nomProducto', 'p.presentacion as presProducto', 'movimiento_productos.cantidad as canProducto', 'ins.nombre as nomCentroCosto', 'ins.nrodoc as rutCentroCosto', 's.fecha_inicial as fechaEntrega', 's.recibido_por as resRecibo', 'us.name as repEntrega', 'movimiento_productos.id as idMovProducto')
         ->where([
            ['movimiento_productos.deleted_at', null],
            ['s.deleted_at', null]
         ]);

      return DataTables::of($salida)
         ->addColumn('acciones', function ($salida) {
            '<div>';
            if (Auth::user()->can('CONSULTA-DETALLE')) {
               $mostrar =
               '<a href="' . route('consultas.show', $salida->idMovProducto) . '" class="btn btn-warning btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </a>';
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
      $entregado_por = DB::table('salidas as s')
         ->leftjoin('users as us', 'us.id', '=', 's.creado_por')
         ->select('us.id as iduser', 'us.name as usuario')
         ->pluck('usuario', 'iduser')
         ->toArray();

      return view('consultas.index', compact('entregado_por'));
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
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      $mov_producto = MovimientoProducto::find($id);

      $producto_stock = DB::table('movimiento_productos as mp')
         ->join('productos as p', 'p.id', '=', 'mp.productos_id')
         ->select('p.nombre as nomProducto',
            DB::raw('
            SUM(CASE WHEN mp.tipo_movimiento = "INGRESO" THEN mp.cantidad ELSE 0 END) -
            SUM( CASE WHEN mp.tipo_movimiento = "EGRESO" THEN mp.cantidad ELSE "0" END)
            as stock_actual')
         )
         ->where('p.id', $mov_producto->productos_id)
         ->groupBy('nomProducto')
         ->first();

      return view('consultas.show', compact('mov_producto', 'producto_stock'));
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
}
