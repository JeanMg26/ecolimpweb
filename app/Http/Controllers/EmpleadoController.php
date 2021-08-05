<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoCRequest;
use App\Http\Requests\EmpleadoERequest;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EmpleadoController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:PERSONAL-LISTAR')->only('index');
      $this->middleware('permission:PERSONAL-CREAR')->only('create', 'store');
      $this->middleware('permission:PERSONAL-EDITAR')->only('edit', 'update');
      $this->middleware('permission:PERSONAL-ELIMINAR')->only('delete');
   }

   public function datatables()
   {
      $empleado = DB::table('empleados')
         ->join('users', 'users.empleados_id', '=', 'empleados.id')
         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
         ->select('empleados.*', 'roles.name as rol')
         ->where([
            ['roles.status', 1],
            ['empleados.deleted_at', null]
         ]);

      return DataTables::of($empleado)
         ->addColumn('acciones', function ($empleado) {
            '<div>';
            if (Auth::user()->can('PERSONAL-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $empleado->id . '" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PERSONAL-EDITAR')) {
               $mostrar .=
               '<a href="' . route("empleados.edit", $empleado->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('PERSONAL-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $empleado->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <span class="far fa-trash-alt fa-xs"></span>
                     </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($empleado) {
            if (Auth::user()->can('PERSONAL-EDITAR')) {
               if ($empleado->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $empleado->id . '" id="empleado' . $empleado->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($empleado->estado == '0') {
                  return
                  '<div class="centrar">
                  <input data-id="' . $empleado->id . '" id="empleado' . $empleado->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
               </div>';
               }
            } else {
               if ($empleado->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($empleado->estado == '0') {
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

      $rol = DB::table('empleados')
         ->join('users', 'users.empleados_id', '=', 'empleados.id')
         ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
         ->select('roles.name as rol_name')
         ->where([
            ['roles.status', 1],
            ['users.deleted_at', null]
         ])
         ->orderBy('rol_name', 'asc')
         ->pluck('rol_name', 'rol_name')
         ->toArray();

      return view('empleados.index', compact('rol'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $rol = DB::table('roles')
         ->where([
            ['roles.status', 1]
         ])
         ->orderBy('name')
         ->pluck('name', 'id')
         ->toArray();

      return view('empleados.create', compact('rol'));

   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(EmpleadoCRequest $request)
   {
      //***************** TABLA: EMPLEADOS ****************
      $empleado            = new Empleado();
      $empleado->nombres   = strtoupper($request->nom_emp);
      $empleado->apellidos = strtoupper($request->ape_emp);
      $empleado->completos = strtoupper($request->nom_emp . ' ' . $request->ape_emp);
      $empleado->email     = strtoupper($request->email_emp);
      $empleado->genero    = strtoupper($request->gen_emp);
      $empleado->tipodoc   = strtoupper($request->tipodoc_emp);
      $empleado->nrodoc    = $request->nrodoc_emp;
      $empleado->celular   = $request->cel_emp;
      $empleado->fec_nac   = date('Y-m-d', strtotime($request->fec_nac));
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $empleado->rutaimagen = "";
      } else {
         $empleado->rutaimagen = $request->file('imagen_emp')->store('personal');
      }
      $empleado->estado = $request->est_emp;
      $empleado->save();

      // ***************** TABLA: USUARIOS ****************
      $apellido          = explode(' ', strtoupper($request->ape_emp));
      $primera_lapellido = substr(strtoupper($request->ape_emp), 0, 1);
      $primera_lnombre   = substr(strtoupper($request->nom_emp), 0, 1);

      // Obtener RUN sin puntos y guiones para username
      $quitar_puntos  = strtr($request->nrodoc_emp, ',', ' ');
      $quitar_guiones = strtr($quitar_puntos, '-', ' ');
      $sin_espacios   = str_replace(' ', '', $quitar_guiones);

      // Nombre de Usuario y Clave automatica
      $nom_usuario = $primera_lnombre . '.' . ' ' . $apellido[0];
      $clave       = $primera_lapellido . $primera_lnombre . $sin_espacios;

      $usuario           = new User();
      $usuario->name     = $nom_usuario;
      $usuario->username = $sin_espacios;
      $usuario->email    = strtoupper($request->email_emp);
      $usuario->password = bcrypt($clave);
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $usuario->rutaimagen = "";
      } else {
         $usuario->rutaimagen = $request->file('imagen_emp')->store('usuarios');
      }
      $usuario->empleados_id = $empleado->id;
      $usuario->status       = $request->est_emp;
      $usuario->save();
      $usuario->assignRole($request->input('cargo_emp'));

      toastr()->success('Registro agregado correctamente.');

      return redirect('empleados');
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

         $empleado = Empleado::findOrFail($id);

         // NOMBRE DE USUARIO INICIAL
         $quitar_puntos  = strtr($empleado->nrodoc, ',', ' ');
         $quitar_guiones = strtr($quitar_puntos, '-', ' ');
         $sin_espacios   = str_replace(' ', '', $quitar_guiones);

         $username = $sin_espacios;
         $clave    = (substr(strtoupper($empleado->apellidos), 0, 1)) . (substr(strtoupper($empleado->nombres), 0, 1)) . ($sin_espacios);

         // OBTENER EL ROL DESDE LARAVEL PERMISSION
         $usuario = User::where('empleados_id', $id)->first();
         // $rol        = Role::pluck('name', 'name')->all();
         $usuarioRol = $usuario->roles->first();

         return response()->json(['empleado' => $empleado, 'usuarioRol' => $usuarioRol, 'username' => $username, 'clave' => $clave]);
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

      $empleado = Empleado::find($id);

      $usuario = User::where('empleados_id', $id)->first();
      $rol     = DB::table('roles')
         ->where([['status', 1]])
         ->orderBy('name')
         ->pluck('name', 'name')
         ->all();

      $usuarioRol = $usuario->roles->pluck('name', 'name')->all();

      return view('empleados.edit', compact('empleado', 'usuarioRol', 'rol'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(EmpleadoERequest $request, $id)
   {
      //***************** TABLA: EMPLEADOS ****************
      $empleado            = Empleado::findOrFail($id);
      $empleado->nombres   = strtoupper($request->nom_emp);
      $empleado->apellidos = strtoupper($request->ape_emp);
      $empleado->completos = strtoupper($request->nom_emp . ' ' . $request->ape_emp);
      $empleado->email     = strtoupper($request->email_emp);
      $empleado->genero    = strtoupper($request->gen_emp);
      $empleado->tipodoc   = strtoupper($request->tipodoc_emp);
      $empleado->nrodoc    = $request->nrodoc_emp;
      $empleado->celular   = $request->cel_emp;
      $empleado->fec_nac   = date('Y-m-d', strtotime($request->fec_nac));
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $empleado->rutaimagen = $empleado->rutaimagen;
      } else {
         $empleado->rutaimagen = $request->file('imagen_emp')->store('personal');
      }
      $empleado->estado = $request->est_emp;
      $empleado->save();

      //***************** TABLA: USUARIOS ****************
      $usuario = User::where('empleados_id', $id)->first();
      DB::table('model_has_roles')->where('model_id', $usuario->id)->delete();
      $usuario->assignRole($request->input('cargo_emp'));

      toastr()->info('Registro actualizado correctamente.');
      return redirect('empleados');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $empleado = Empleado::findOrFail($id);
      $usuario  = User::where('empleados_id', $id)->first();

      $usuario->delete();
      $empleado->delete();
      // DB::table('model_has_roles')->where('model_id', $usuario->id)->delete();
   }

   public function cambiarEstadoEmpleado(Request $request)
   {
      $empleado             = Empleado::find($request->empleado_id);
      $empleado->nombres    = $empleado->nombres;
      $empleado->apellidos  = $empleado->apellidos;
      $empleado->completos  = $empleado->completos;
      $empleado->email      = $empleado->email;
      $empleado->genero     = $empleado->genero;
      $empleado->tipodoc    = $empleado->tipodoc;
      $empleado->nrodoc     = $empleado->nrodoc;
      $empleado->celular    = $empleado->celular;
      $empleado->rutaimagen = $empleado->rutaimagen;
      $empleado->estado     = $request->estado;
      $empleado->save();

      $usuario         = User::where('empleados_id', $request->empleado_id)->first();
      $usuario->status = $request->estado;
      $usuario->save();

      return response()->json(['success' => 'Estado actualizado correctamente.']);
   }
}
