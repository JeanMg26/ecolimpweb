<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoriaController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:CATEGORIA-LISTAR')->only('index');
      $this->middleware('permission:CATEGORIA-CREAR')->only('create', 'store');
      $this->middleware('permission:CATEGORIA-EDITAR')->only('edit', 'update');
      $this->middleware('permission:CATEGORIA-ELIMINAR')->only('delete');
   }

   public function datatables()
   {
      $categoria = DB::table('categorias')
         ->select('id', 'nombre', 'estado')
         ->where([
            ['deleted_at', null]
         ])
         ->get();

      return DataTables::of($categoria)
         ->addColumn('acciones', function ($categoria) {
            '<div>';
            if (Auth::user()->can('CATEGORIA-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $categoria->id . '" data-toggle="tooltip"      data-placement="top" title="Ver">
                        <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('CATEGORIA-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $categoria->id . '" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('CATEGORIA-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $categoria->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($categoria) {
            if (Auth::user()->can('CATEGORIA-EDITAR')) {
               if ($categoria->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $categoria->id . '" id="categoria' . $categoria->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($categoria->estado == '0') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $categoria->id . '" id="categoria' . $categoria->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                  </div>';
               }
            } else {
               if ($categoria->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }

               if ($categoria->estado == '0') {
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
      return view('categorias.index');
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
      $rules = [

         'nom_categoria' => 'required|max:40|unique:categorias,nombre',
         'est_categoria' => 'required'
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $categoria         = new Categoria();
      $categoria->nombre = strtoupper($request->nom_categoria);
      $categoria->estado = $request->est_categoria;
      $categoria->save();
      return response()->json(['success' => 'Registro agregado correctamente.']);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      if (request()->ajax()) {
         $categoria = Categoria::findOrFail($id);
         return response()->json(['categoria' => $categoria]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      if (request()->ajax()) {
         $categoria = Categoria::findOrFail($id);
         return response()->json(['categoria' => $categoria]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Categoria $categoria)
   {
      $rules = [
         'nom_categoria' => 'required|max:20|unique:categorias,nombre,' . $request->categoria_id,
         'est_categoria' => 'required'
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $categoria         = Categoria::findOrFail($request->categoria_id);
      $categoria->nombre = strtoupper($request->nom_categoria);
      $categoria->estado = $request->est_categoria;
      $categoria->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);

      // dd('xxxxx');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $categoria = Categoria::findOrFail($id);

      $productos = DB::table('productos')
         ->join('categorias', 'categorias.id', '=', 'productos.categorias_id')
         ->where([
            ['productos.deleted_at', null],
            ['productos.categorias_id', '=', $categoria->id]
         ])
         ->exists();

      if ($productos) {
         return response()->json(['mensaje' => 'No se pudo eliminar, la categoria esta siendo usada.', 'icono' => 'warning']);
      } else {
         $categoria->delete();
         return response()->json(['mensaje' => 'Categoria eliminada correctamente.', 'icono' => 'error']);
      }

   }

   public function cambiarEstadoCategoria(Request $request)
   {
      $categoria         = Categoria::find($request->categoria_id);
      $categoria->nombre = $categoria->nombre;
      $categoria->estado = $request->estado;
      $categoria->save();
      return response()->json(['success' => 'Estado actualizado correctamente.']);
   }
}
