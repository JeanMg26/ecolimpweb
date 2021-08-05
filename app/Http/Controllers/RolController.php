<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolCRequest;
use App\Http\Requests\RolERequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:ROL-LISTAR')->only('index');
      $this->middleware('permission:ROL-CREAR')->only('create', 'store');
      $this->middleware('permission:ROL-EDITAR')->only('edit', 'update');
      $this->middleware('permission:ROL-ELIMINAR')->only('delete');
   }

   public function datatables()
   {
      $rol = Role::select('roles.*');

      return DataTables::of($rol)
         ->addColumn('acciones', function ($rol) {
            '<div>';
            if (Auth::user()->can('ROL-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view tooltip-direction" id="' . $rol->id . '" data-toggle="tooltip" data-placement="top" title="Ver">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('ROL-EDITAR')) {
               $mostrar .=
               '<a href="' . route("roles.edit", $rol->id) . '" class="btn btn-info btn-accion mr-1" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('ROL-ELIMINAR')) {

               if ($rol->id == '1') {
                  $mostrar .= '';
               } else {
                  $mostrar .=
                  '<button class="btn btn-danger btn-accion delete mr-1" id="' . $rol->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                     <span class="far fa-trash-alt fa-xs"></span>
                  </button>';
               }
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($rol) {
            if (Auth::user()->can('ROL-EDITAR')) {
               if ($rol->status == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $rol->id . '" id="rol' . $rol->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }
               if ($rol->status == '0') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $rol->id . '" id="rol' . $rol->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                  </div>';
               }
            } else {
               if ($rol->status == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($rol->status == '0') {
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
      return view('roles.index');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $permisos = DB::table('permissions')
         ->select('id', 'module', DB::raw('SUBSTRING_INDEX(name,"-",-1) as nombre'))
         ->where('permissions.status', 1)
         ->orderBy('module')
         ->orderBy('nombre')
         ->get()
         ->groupBy('module');

      $collection = $permisos;

      return view('roles.create', compact('permisos', 'collection'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(RolCRequest $request)
   {
      $role         = new Role();
      $role->name   = strtoupper($request->nom_rol);
      $role->status = $request->est_rol;
      $role->save();
      $role->syncPermissions($request->input('permisos'));
      session()->flash("success", "Registro agregado correctamente");
      return redirect('roles');
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
         $rol        = Role::find($id);
         $rolPermiso = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where([
               ["role_has_permissions.role_id", $id],
               ['permissions.status', 1]
            ])
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');
         $collection = $rolPermiso;

         return response()->json(['rol' => $rol, 'rolPermiso' => $rolPermiso, 'collection' => $collection]);
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
      $rol = Role::find($id);

      $permisos = DB::table('permissions')
         ->select('id', 'module', DB::raw('SUBSTRING_INDEX(name,"-",-1) as nombre'))
         ->where('permissions.status', 1)
         ->orderBy('module')
         ->orderBy('nombre')
         ->get()
         ->groupBy('module');

      $collection = $permisos;

      $rolPermiso = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
         ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
         ->all();
      return view('roles.edit', compact('rol', 'permisos', 'rolPermiso', 'collection'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(RolERequest $request, $id)
   {
      $rol         = Role::find($id);
      $rol->name   = strtoupper($request->nom_rol);
      $rol->status = $request->est_rol;
      $rol->save();
      $rol->syncPermissions($request->input('permisos'));
      toastr()->info('Registro actualizado correctamente.');
      return redirect('roles');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $rol = Role::findOrFail($id);

      $usuarioRol = DB::table('model_has_roles')
         ->join('users', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
         ->where(
            [
               ['model_has_roles.role_id', '=', $rol->id],
               ['users.deleted_at', null]
            ]
         )
         ->exists();

      if ($usuarioRol) {
         return response()->json(['mensaje' => 'No se pudo eliminar, el rol esta siendo usado.', 'icono' => 'warning']);
      } else {
         $rolPermiso = DB::table('role_has_permissions')->where('role_id', $id);
         $rol->delete();
         $rolPermiso->delete();
         return response()->json(['mensaje' => 'Registro eliminado correctamente.', 'icono' => 'error']);
      }
   }

   public function cambiarEstadoRol(Request $request)
   {
      $rol         = Role::find($request->rol_id);
      $rol->name   = $rol->name;
      $rol->status = $request->estado;
      $rol->save();
      return response()->json(['success' => 'Estado actualizado correctamente.']);
   }
}
