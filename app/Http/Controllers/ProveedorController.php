<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorCRequest;
use App\Http\Requests\ProveedorERequest;
use App\Models\Comuna;
use App\Models\Proveedor;
use App\Models\Provincia;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProveedorController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:PROVEEDOR-LISTAR')->only('index');
      $this->middleware('permission:PROVEEDOR-CREAR')->only('create', 'store');
      $this->middleware('permission:PROVEEDOR-EDITAR')->only('edit', 'update');
      $this->middleware('permission:PROVEEDOR-ELIMINAR')->only('delete');
   }

   // *********** DATOS PARA REGION - PROVINCIA **************
   public function proveedor_provincias(Request $request)
   {
      if ($request->ajax()) {

         $region_id = $request->input('regionID');
         $provincia = Provincia::where([
            ['regiones_id', '=', $region_id]
         ])->get();
         return response()->json($provincia);
      }
   }

   // *********** DATOS PARA PROVINCIA - COMUNA **************
   public function proveedor_comunas(Request $request)
   {
      if ($request->ajax()) {

         $provincia_id = $request->input('provinciaID');
         $comuna       = Comuna::where([
            ['provincias_id', '=', $provincia_id]
         ])->get();
         return response()->json($comuna);
      }
   }

   // *********** DATOS PARA BUSCAR PROVEEDORES **************
   public function filtrar_proveedor(Request $request)
   {
      $search = $request->get('proveedor');

      $proveedor_buscado = Proveedor::where('nombre', 'LIKE', '%' . $search . '%')->get();

      $proveedores = [];
      foreach ($proveedor_buscado as $proveedor) {
         $proveedores[] = [
            "id_proveedor"  => $proveedor->id,
            "nom_proveedor" => $proveedor->nombre,
            "rut_proveedor" => $proveedor->nrodoc,
            "nom_contacto"  => $proveedor->nom_contacto,
            "rut_contacto"  => $proveedor->nrodoc_contacto
         ];
      }

      return response()->json($proveedores);
   }

   public function datatables(Request $request)
   {
      // ***********************************************************************************
      // *************************** BUSQUEDAS UNITARIAS ***********************************
      // ***********************************************************************************
      $proveedor_entrada = Proveedor::query();

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CENTRO DE COSTO *****************
      if (!empty($request->nomproveedor_buscar)) {
         $nomProveedorBuscar = $request->nomproveedor_buscar;

         $proveedor_entrada
            ->where('proveedores.nombre', 'LIKE', '%' . $nomProveedorBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - RUT DEL CENTRO DE COSTO *****************
      if (!empty($request->rutproveedor_buscar)) {
         $rutProveedorBuscar = $request->rutproveedor_buscar;

         $proveedor_entrada
            ->where('proveedores.nrodoc', 'LIKE', '%' . $rutProveedorBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CONTACTO *****************
      if (!empty($request->nomcontacto_buscar)) {
         $nomContactoBuscar = $request->nomcontacto_buscar;

         $proveedor_entrada
            ->where('proveedores.nom_contacto', 'LIKE', '%' . $nomContactoBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - RUT DEL CONTACTO *****************
      if (!empty($request->rutcontacto_buscar)) {
         $rutContactoBuscar = $request->rutcontacto_buscar;

         $proveedor_entrada
            ->where('proveedores.nrodoc_contacto', 'LIKE', '%' . $rutContactoBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - ESTADO DEL CENTRO DE COSTO *****************
      $estProveedorBuscar = $request->estado_buscar;

      if ($estProveedorBuscar == '0' || $estProveedorBuscar == '1') {
         $proveedor_entrada->where('proveedores.estado', $estProveedorBuscar);
      }

      $proveedor = $proveedor_entrada
         ->select('proveedores.*')
         ->where([
            ['proveedores.deleted_at', null]
         ]);

      return DataTables::of($proveedor)
         ->addColumn('acciones', function ($proveedor) {
            '<div>';
            if (Auth::user()->can('PROVEEDOR-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $proveedor->id . '" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PROVEEDOR-EDITAR')) {
               $mostrar .=
               '<a href="' . route("proveedores.edit", $proveedor->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('PROVEEDOR-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $proveedor->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <span class="far fa-trash-alt fa-xs"></span>
                     </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($proveedor) {
            if (Auth::user()->can('PROVEEDOR-EDITAR')) {
               if ($proveedor->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $proveedor->id . '" id="proveedor' . $proveedor->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($proveedor->estado == '0') {
                  return
                  '<div class="centrar">
                  <input data-id="' . $proveedor->id . '" id="proveedor' . $proveedor->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
               </div>';
               }
            } else {
               if ($proveedor->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($proveedor->estado == '0') {
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
      $estado = DB::table('proveedores')
         ->select('proveedores.*', DB::raw('(CASE WHEN estado = "1" THEN "ACTIVO" ELSE "INACTIVO" END) as nom_estado'))
         ->orderBy('nom_estado', 'asc')
         ->pluck('nom_estado', 'estado')
         ->toArray();

      return view('proveedores.index', compact('estado'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $region = Region::pluck('nombre', 'id');

      return view('proveedores.create', compact('region'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(ProveedorCRequest $request)
   {
      $proveedor               = new Proveedor();
      $proveedor->nombre       = strtoupper($request->nom_proveedor);
      $proveedor->nom_fantasia = strtoupper($request->nom_fantasia);
      $proveedor->nrodoc       = strtoupper($request->nrodoc_proveedor);
      $proveedor->email        = strtoupper($request->email_proveedor);

      $proveedor->regiones_id   = $request->region;
      $proveedor->provincias_id = $request->provincia;
      $proveedor->comunas_id    = $request->comuna;

      $proveedor->direccion = strtoupper($request->dir_proveedor);
      $proveedor->telefono  = strtoupper($request->tel_proveedor);
      $proveedor->estado    = strtoupper($request->est_proveedor);

      $proveedor->nom_contacto    = strtoupper($request->nom_contacto);
      $proveedor->nrodoc_contacto = $request->nrodoc_contacto;
      $proveedor->cel_contacto    = strtoupper($request->cel_contacto);
      $proveedor->email_contacto  = strtoupper($request->email_contacto);
      $proveedor->save();
      toastr()->success('Registro agregado correctamente.');
      return redirect('proveedores');

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Proveedor  $proveedor
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      if (request()->ajax()) {
         $proveedor = Proveedor::findOrFail($id);
         $region    = Region::findOrFail($proveedor->regiones_id);
         $provincia = Provincia::findOrFail($proveedor->provincias_id);
         $comuna    = Comuna::findOrFail($proveedor->comunas_id);
         return response()->json(['proveedor' => $proveedor, 'region' => $region, 'provincia' => $provincia, 'comuna' => $comuna]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Proveedor  $proveedor
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $proveedor = Proveedor::find($id);
      $region    = Region::pluck('nombre', 'id');
      $provincia = Provincia::pluck('nombre', 'id');
      $comuna    = Comuna::pluck('nombre', 'id');
      return view('proveedores.edit', compact('proveedor', 'region', 'provincia', 'comuna'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Proveedor  $proveedor
    * @return \Illuminate\Http\Response
    */
   public function update(ProveedorERequest $request, $id)
   {
      $proveedor               = Proveedor::find($id);
      $proveedor->nombre       = strtoupper($request->nom_proveedor);
      $proveedor->nom_fantasia = strtoupper($request->nom_fantasia);
      $proveedor->nrodoc       = strtoupper($request->nrodoc_proveedor);
      $proveedor->email        = strtoupper($request->email_proveedor);

      $proveedor->regiones_id   = $request->region;
      $proveedor->provincias_id = $request->provincia;
      $proveedor->comunas_id    = $request->comuna;

      $proveedor->direccion = strtoupper($request->dir_proveedor);
      $proveedor->telefono  = strtoupper($request->tel_proveedor);
      $proveedor->estado    = strtoupper($request->est_proveedor);

      $proveedor->nom_contacto    = strtoupper($request->nom_contacto);
      $proveedor->nrodoc_contacto = $request->nrodoc_contacto;
      $proveedor->cel_contacto    = strtoupper($request->cel_contacto);
      $proveedor->email_contacto  = strtoupper($request->email_contacto);
      $proveedor->save();
      toastr()->info('Registro actualizado correctamente.');
      return redirect('proveedores');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Proveedor  $proveedor
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $proveedor = Proveedor::findOrFail($id);

      $ingreso = DB::table('ingresos as in')
         ->where([
            ['in.deleted_at', null],
            ['in.proveedores_id', $id]
         ])
         ->exists();

      if ($ingreso) {
         return response()->json(['mensaje' => 'No se pudo eliminar, el proveedor esta siendo utilizado en un registro de materiales.', 'icono' => 'warning']);
      } else {
         $proveedor->delete();
         return response()->json(['mensaje' => 'Proveedor eliminado correctamente.', 'icono' => 'error']);
      }
   }

   public function cambiarEstadoProveedor(Request $request)
   {
      $proveedor               = Proveedor::find($request->proveedor_id);
      $proveedor->nombre       = $proveedor->nombre;
      $proveedor->nom_fantasia = $proveedor->nom_fantasia;
      $proveedor->nrodoc       = $proveedor->nrodoc;
      $proveedor->email        = $proveedor->email;

      $proveedor->regiones_id   = $proveedor->regiones_id;
      $proveedor->provincias_id = $proveedor->provincias_id;
      $proveedor->comunas_id    = $proveedor->comunas_id;

      $proveedor->direccion = $proveedor->direccion;
      $proveedor->telefono  = $proveedor->telefono;

      $proveedor->nom_contacto    = $proveedor->nom_contacto;
      $proveedor->nrodoc_contacto = $proveedor->nrodoc_contacto;
      $proveedor->cel_contacto    = $proveedor->cel_contacto;
      $proveedor->email_contacto  = $proveedor->email_contacto;
      $proveedor->estado          = $request->estado;
      $proveedor->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }
}
