<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstalacionCRequest;
use App\Http\Requests\InstalacionERequest;
use App\Models\Comuna;
use App\Models\Instalacion;
use App\Models\Provincia;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InstalacionController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:INSTALACION-LISTAR')->only('index');
      $this->middleware('permission:INSTALACION-CREAR')->only('create', 'store');
      $this->middleware('permission:INSTALACION-EDITAR')->only('edit', 'update');
      $this->middleware('permission:INSTALACION-ELIMINAR')->only('delete');
   }

   public function instalaciones_provincias(Request $request)
   {
      if ($request->ajax()) {

         $region_id = $request->input('regionID');
         $provincia = Provincia::where([
            ['regiones_id', '=', $region_id]
         ])->get();
         return response()->json($provincia);
      }
   }

   // *********** DATOS PARA AREA - OFICINA **************
   public function instalaciones_comunas(Request $request)
   {
      if ($request->ajax()) {

         $provincia_id = $request->input('provinciaID');
         $comuna       = Comuna::where([
            ['provincias_id', '=', $provincia_id]
         ])->get();
         return response()->json($comuna);
      }
   }

   // *********** DATOS PARA BUSCAR INSTALACIONES **************
   public function filtrar_instalacion(Request $request)
   {
      $search = $request->get('instalacion');

      $instalacion_buscada = Instalacion::where('nombre', 'LIKE', '%' . $search . '%')->get();

      $instalaciones = [];
      foreach ($instalacion_buscada as $instalacion) {
         $instalaciones[] = [
            "id_instalacion"  => $instalacion->id,
            "nom_instalacion" => $instalacion->nombre,
            "rut_instalacion" => $instalacion->nrodoc,
            "nom_contacto"    => $instalacion->nom_contacto,
            "rut_contacto"    => $instalacion->nrodoc_contacto
         ];
      }

      return response()->json($instalaciones);
   }

   public function datatables(Request $request)
   {
      // ***********************************************************************************
      // *************************** BUSQUEDAS UNITARIAS ***********************************
      // ***********************************************************************************
      $instalacion_entrada = Instalacion::query();

      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CENTRO DE COSTO *****************
      if (!empty($request->nomcc_buscar)) {
         $nomCCBuscar = $request->nomcc_buscar;

         $instalacion_entrada
            ->where('instalaciones.nombre', 'LIKE', '%' . $nomCCBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - RUT DEL CENTRO DE COSTO *****************
      if (!empty($request->rutcc_buscar)) {
         $rutCCBuscar = $request->rutcc_buscar;

         $instalacion_entrada
            ->where('instalaciones.nrodoc', 'LIKE', '%' . $rutCCBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - NOMBRE DEL CONTACTO *****************
      if (!empty($request->nomcontacto_buscar)) {
         $nomContactoBuscar = $request->nomcontacto_buscar;

         $instalacion_entrada
            ->where('instalaciones.nom_contacto', 'LIKE', '%' . $nomContactoBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - RUT DEL CONTACTO *****************
      if (!empty($request->rutcontacto_buscar)) {
         $rutContactoBuscar = $request->rutcontacto_buscar;

         $instalacion_entrada
            ->where('instalaciones.nrodoc_contacto', 'LIKE', '%' . $rutContactoBuscar . '%')
            ->get();
      }
      // *********** BUSQUEDAS UNITARIAS - ESTADO DEL CENTRO DE COSTO *****************
      $estCCBuscar = $request->estado_buscar;

      if ($estCCBuscar == '0' || $estCCBuscar == '1') {
         $instalacion_entrada->where('instalaciones.estado', $estCCBuscar);
      }

      $instalacion = $instalacion_entrada
         ->select('instalaciones.*')
         ->where([
            ['instalaciones.deleted_at', null]
         ]);

      return DataTables::of($instalacion)
         ->addColumn('acciones', function ($instalacion) {
            '<div>';
            if (Auth::user()->can('INSTALACION-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $instalacion->id . '" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('INSTALACION-EDITAR')) {
               $mostrar .=
               '<a href="' . route("instalaciones.edit", $instalacion->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('INSTALACION-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $instalacion->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <span class="far fa-trash-alt fa-xs"></span>
                     </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($instalacion) {
            if (Auth::user()->can('INSTALACION-EDITAR')) {
               if ($instalacion->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $instalacion->id . '" id="instalacion' . $instalacion->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($instalacion->estado == '0') {
                  return
                  '<div class="centrar">
                  <input data-id="' . $instalacion->id . '" id="empleado' . $instalacion->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
               </div>';
               }
            } else {
               if ($instalacion->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($instalacion->estado == '0') {
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
      $estado = DB::table('instalaciones')
         ->select('instalaciones.*', DB::raw('(CASE WHEN estado = "1" THEN "ACTIVO" ELSE "INACTIVO" END) as nom_estado'))
         ->orderBy('nom_estado', 'asc')
         ->pluck('nom_estado', 'estado')
         ->toArray();

      return view('instalaciones.index', compact('estado'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $region = Region::pluck('nombre', 'id');

      return view('instalaciones.create', compact('region'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(InstalacionCRequest $request)
   {
      $instalacion               = new Instalacion();
      $instalacion->nombre       = strtoupper($request->nom_instalacion);
      $instalacion->nom_fantasia = strtoupper($request->nom_fantasia);
      $instalacion->nrodoc       = $request->nrodoc_instalacion;
      $instalacion->email        = strtoupper($request->email_instalacion);
      $instalacion->direccion    = strtoupper($request->dir_instalacion);
      $instalacion->telefono     = $request->tel_instalacion;
      $instalacion->estado       = $request->est_instalacion;

      $instalacion->regiones_id   = $request->region;
      $instalacion->provincias_id = $request->provincia;
      $instalacion->comunas_id    = $request->comuna;

      $instalacion->nom_contacto    = strtoupper($request->nom_contacto);
      $instalacion->nrodoc_contacto = $request->nrodoc_contacto;
      $instalacion->email_contacto  = strtoupper($request->email_contacto);
      $instalacion->cel_contacto    = $request->cel_contacto;
      $instalacion->save();
      toastr()->success('Registro agregado correctamente.');
      return redirect('instalaciones');

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Instalacion  $instalacion
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      if (request()->ajax()) {
         $instalacion = Instalacion::findOrFail($id);
         $region      = Region::findOrFail($instalacion->regiones_id);
         $provincia   = Provincia::findOrFail($instalacion->provincias_id);
         $comuna      = Comuna::findOrFail($instalacion->comunas_id);
         return response()->json(['instalacion' => $instalacion, 'region' => $region, 'provincia' => $provincia, 'comuna' => $comuna]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Instalacion  $instalacion
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $instalacion = Instalacion::find($id);
      $region      = Region::pluck('nombre', 'id');
      $provincia   = Provincia::pluck('nombre', 'id');
      $comuna      = Comuna::pluck('nombre', 'id');
      return view('instalaciones.edit', compact('instalacion', 'region', 'provincia', 'comuna'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Instalacion  $instalacion
    * @return \Illuminate\Http\Response
    */
   public function update(InstalacionERequest $request, $id)
   {
      $instalacion               = Instalacion::findOrFail($id);
      $instalacion->nombre       = strtoupper($request->nom_instalacion);
      $instalacion->nom_fantasia = strtoupper($request->nom_fantasia);
      $instalacion->nrodoc       = $request->nrodoc_instalacion;
      $instalacion->email        = strtoupper($request->email_instalacion);
      $instalacion->direccion    = strtoupper($request->dir_instalacion);
      $instalacion->telefono     = $request->tel_instalacion;

      $instalacion->regiones_id   = $request->region;
      $instalacion->provincias_id = $request->provincia;
      $instalacion->comunas_id    = $request->comuna;

      $instalacion->estado = $request->est_instalacion;

      $instalacion->nom_contacto    = strtoupper($request->nom_contacto);
      $instalacion->nrodoc_contacto = $request->nrodoc_contacto;
      $instalacion->email_contacto  = strtoupper($request->email_contacto);
      $instalacion->cel_contacto    = $request->cel_contacto;
      $instalacion->save();
      toastr()->info('Registro actualizado correctamente.');
      return redirect('instalaciones');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Instalacion  $instalacion
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $instalacion = Instalacion::findOrFail($id);

      $salida = DB::table('salidas as s')
         ->where([
            ['s.deleted_at', null],
            ['s.instalaciones_id', $id]
         ])
         ->exists();

      if ($salida) {
         return response()->json(['mensaje' => 'No se pudo eliminar, el centro de costo esta siendo utilizado en una entrega de materiales.', 'icono' => 'warning']);
      } else {
         $instalacion->delete();
         return response()->json(['mensaje' => 'Centro de Costo eliminado correctamente.', 'icono' => 'error']);
      }
   }

   public function cambiarEstadoInstalacion(Request $request)
   {
      $instalacion               = Instalacion::find($request->instalacion_id);
      $instalacion->nombre       = $instalacion->nombre;
      $instalacion->nom_fantasia = $instalacion->nom_fantasia;
      $instalacion->nrodoc       = $instalacion->nrodoc;
      $instalacion->email        = $instalacion->email;
      $instalacion->direccion    = $instalacion->direccion;
      $instalacion->telefono     = $instalacion->telefono;

      $instalacion->nom_contacto    = $instalacion->nom_contacto;
      $instalacion->nrodoc_contacto = $instalacion->nrodoc_contacto;
      $instalacion->email_contacto  = $instalacion->email_contacto;
      $instalacion->cel_contacto    = $instalacion->cel_contacto;
      $instalacion->estado          = $request->estado;
      $instalacion->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }
}
