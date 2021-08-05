<style>
   body {
      font-size: 13px;
   }

   .imagen {
      vertical-align: top;
      top: 0;
      position: relative;
   }

   hr.linea {
      border: 0.1px solid #adb5bd;
   }


   .documento {
      text-align: center;
      font-size: 25px;
      padding: 20px 0px;
   }

   .proveedor,
   .nomproducto {
      text-align: center;
      font-size: 15px;
      padding: 5px 0px;
      background-color: #4dabf7;
   }

   .cabecera {
      text-align: left;
      font-size: 13px;
      padding: 5px;
      background-color: #74c0fc;
   }

   .productos {
      text-align: left;
      padding: 5px 5px 5px 3px;
   }

   .totales {
      text-align: right;
      padding: 5px;
      background-color: #74c0fc;
   }

   .nom_totales {
      text-align: right;
      padding: 5px;
      background-color: #74c0fc;
   }
</style>

<table width="100%">
   <tr>
      <td class="imagen" rowspan="4" width="20%"><img src="{{ asset('img/ecolimp.png') }}" alt="homepage" width="130" class="light-logo" /> </td>
      <td width="33%">ECOLIMP - SISTEMA DE LIMPIEZA</td>
      <td width="17%"><strong>N° Registro:</strong></td>
      <td width="30%">{{ $ingreso->codigo }}</td>
   </tr>
   <tr>
      <td>253.256.369-5</td>
      <td><strong>Fecha de Ingreso:</strong></td>
      <td>{{ date('d-m-Y', strtotime($ingreso->fecha_emision)) }}</td>
   </tr>
   <tr>
      <td>Calle Anonima 130, Antofogasta, Chile</td>
      <td><strong>Ingresado por:</strong></td>
      <td>{{ $ingreso->usuario_creador->name }}</td>
   </tr>
   <tr>
      <td>Teléfono: 043256982</td>
      <td><strong>Documento:</strong></td>
      <td>{{ $ingreso->tipodoc }}: {{ $ingreso->nrodoc }}</td>
   </tr>
</table>

<div style="margin-top: 10px">
   <hr class="linea">
</div>

<div class="documento">
   {{-- <strong>{{ $ingreso->tipodoc }} - {{ $ingreso->nrodoc }}</strong> --}}
   <strong>REGISTRO DE MATERIALES</strong>
</div>



<table width="100%">
   <tr style="border: 1px solid">
      <td colspan="2" width="50%" class="proveedor"><strong>Datos de Proveedor</strong></td>
      <td colspan="2" width="50%" class="proveedor"><strong>Datos del Contacto</strong></td>
   </tr>
   <tr>
      <td width="20%" style="padding-top: 15px"><strong>Nombre:</strong></td>
      <td width="30%" style="padding-top: 15px">{{ $ingreso->proveedor->nombre }}</td>
      <td width="20%" style="padding-top: 15px"><strong>Nombre:</strong></td>
      <td width="30%" style="padding-top: 15px">{{ $ingreso->proveedor->nom_contacto }}</td>
   </tr>
   <tr>
      <td width="20%"><strong>Nombre Fantasia:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->nom_fantasia }}</td>
      <td width="20%"><strong>RUT:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->nrodoc_contacto }}</td>
   </tr>
   <tr>
      <td width="20%"><strong>RUT:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->nrodoc }}</td>
      <td width="20%"><strong>Celular:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->cel_contacto }}</td>
   </tr>
   <tr>
      <td width="20%"><strong>Telefono:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->telefono }}</td>
      <td width="20%"><strong>Email:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->email_contacto }}</td>
   </tr>
   <tr>
      <td width="20%"><strong>Email:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->email }}</td>
      <td width="20%"></td>
      <td width="30%"></td>
   </tr>
   <tr>
      <td width="20%"><strong>Dirección:</strong></td>
      <td width="30%">{{ $ingreso->proveedor->direccion }} - {{ $ingreso->proveedor->region->nombre }}, {{ $ingreso->proveedor->provincia->nombre }}, {{ $ingreso->proveedor->comuna->nombre }}</td>
      <td width="20%"></td>
      <td width="30%"></td>
   </tr>
</table>

<div style="padding-top: 15px">
   <hr class="linea">
</div>

<table width="100%" style="margin: 30px 0px 80px 0px">
   <thead>
      <tr>
         <th colspan="10" class="nomproducto">PRODUCTOS INGRESADOS</th>
      </tr>
      <tr class="bg-light-blue">
         <th width="5%" class="cabecera">N°</th>
         <th width="25%" class="cabecera">Producto</th>
         <th width="15%" class="cabecera">Presentación</th>
         <th width="15%" class="cabecera">Stock Actual</th>
         <th width="10%" class="cabecera">Cant.</th>
         <th width="15%" class="cabecera">P. Unitario</th>
         <th width="15%" class="cabecera">Total</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($mov_productos as $producto)
      <tr>
         <td class="productos">{{ $loop->index + 1  }}</td>
         <td class="productos">{{ $producto->nomProducto }}</td>
         <td class="productos">{{  $producto->presProducto }}</td>
         <td class="productos" style="text-align: right">{{ $producto->stock }}</td>
         <td class="productos" style="text-align: right">{{ $producto->cantidad }}</td>
         <td class="productos" style="text-align: right">{{ number_format($producto->precio_unitario, 2) }}</td>
         <td class="productos" style="text-align: right">{{ number_format($producto->total, 2) }}</td>
      </tr>
      @endforeach
   </tbody>
</table>



<table width="100%" style="margin-top: 15px">
   <tr>
      <td width="80%" class="nom_totales"><strong>SUB TOTAL</strong></td>
      <td width="20%" class="totales"> {{ number_format($ingreso->mov_producto->sum('total'), 2) }}</td>
   </tr>
   <tr>
      <td width="80%" class="nom_totales"><strong>IVA</strong></td>
      <td width="20%" class="totales"> {{ number_format(($ingreso->mov_producto->sum('total')*0.19), 2) }}</td>
   </tr>
   <tr>
      <td width="80%" class="nom_totales"><strong>TOTAL</strong></td>
      <td width="20%" class="totales">{{ number_format(($ingreso->mov_producto->sum('total')+($ingreso->mov_producto->sum('total')*0.19)), 2) }}</td>
   </tr>
</table>

{{-- <div>
   <hr class="linea">
</div> --}}

<table width="100%" style="margin-top: 50px">
   <tr>
      <td><strong>Observaciones:</strong></td>
   </tr>
   <tr>
      <td>{{ $ingreso->observaciones }}</td>
   </tr>
</table>