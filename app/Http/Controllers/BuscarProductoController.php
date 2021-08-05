<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class BuscarProductoController extends Controller
{
   public function productos(Request $request)
   {
      $producto_buscado = $request->get('termino');

      $productos = Producto::where('nombre', 'LIKE', '%' . $producto_buscado . '%')->get();

      $data = [];

      foreach ($productos as $producto) {
         $data[] = [
            'label' => $producto->nombre
         ];
      }

      return $data;
   }
}
