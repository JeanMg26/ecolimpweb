<div class="row">
   <div class="col-12">



      <div class="card card-border">
         <div class="card-body row">

            <div class="col-12 col-sm-6 col-lg-4 col-xl-2 mt-2">
               {!! Html::decode(Form::label('num_registro', 'N° Registro', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('cod_ingreso', isset($ingreso) ? $ingreso->codigo : '', ['class' => 'form-control', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-8 col-xl-4 mt-2" id="nomproveedor_typeahead">
               {!! Html::decode(Form::label('proveedor', 'Proveedor <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_proveedor', $ingreso->proveedor->nombre, ['class' => 'form-control', 'placeholder' => 'NOMBRE DEL PROVEEDOR','id' => 'nom_proveedor']) !!}
               {!! Form::hidden('id_proveedor', $ingreso->proveedor->id, ['id' => 'id_proveedor']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nom_proveedor-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_fantasia', isset($ingreso) ? $ingreso->proveedor->nom_fantasia : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA', 'readonly', 'id' => 'nom_fantasia']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'RUT Proveedor', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_proveedor', isset($ingreso) ? $ingreso->proveedor->nrodoc : '', ['class' => 'form-control', 'placeholder' => 'RUT PROVEEDOR','id' => 'rut_proveedor', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tel_proveedor', 'Teléfono Proveedor', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('tel_proveedor', isset($ingreso) ? $ingreso->proveedor->telefono : '', ['class' => 'form-control', 'placeholder' => 'TELÉFONO PROVEEDOR', 'id' => 'tel_proveedor', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-phone-rotary"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('region', isset($ingreso->proveedor) ? $ingreso->proveedor->region->nombre : '', ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'id' => 'region', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('provincia', isset($ingreso->proveedor) ? $ingreso->proveedor->provincia->nombre : '', ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'id' => 'provincia', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('comuna', isset($ingreso->proveedor) ? $ingreso->proveedor->comuna->nombre : '', ['class' => 'form-control', 'placeholder' => 'COMUNA', 'id' => 'comuna', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-7 col-xl-5 mt-2">
               {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('dir_proveedor', isset($ingreso->proveedor) ? $ingreso->proveedor->direccion : '', ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'id' => 'dir_proveedor', 'readonly']) !!}
            </div>


            <div class="col-12 col-sm-6 col-lg-5 col-xl-4 mt-2">
               {!! Html::decode(Form::label('nom_contacto', 'Nombre Contacto', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('nom_contacto', isset($ingreso) ? $ingreso->proveedor->nom_contacto : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE CONTACTO', 'id' => 'nom_contacto', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('rut_contacto', 'RUT Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_contacto', isset($ingreso) ? $ingreso->proveedor->nrodoc_contacto : '', ['class' => 'form-control', 'placeholder' => 'RUT CONTACTO', 'id' => 'rut_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('cel_contacto', 'Celular Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('cel_contacto', isset($ingreso) ? $ingreso->proveedor->cel_contacto : '', ['class' => 'form-control', 'placeholder' => 'CELULAR CONTACTO', 'id' => 'cel_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-mobile-android-alt"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tipodocumento', 'Tipo de Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold ledit'])) !!}
               {!! Form::select('tipodoc_ingreso', ['BOLETA' => 'BOLETA', 'FACTURA' => 'FACTURA', 'GUÍA DE DESPACHO' => 'GUÍA DE DESPACHO'], isset($ingreso) ? $ingreso->tipodoc : '', ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'tipodoc_ingreso']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="tipodoc_ingreso-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'N° Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('nrodoc_ingreso', isset($ingreso) ? $ingreso->nrodoc : '', ['class' => 'form-control alfanumerico', 'placeholder' => 'NÚMERO DOCUMENTO', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'nrodoc_ingreso']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-file-invoice"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nrodoc_ingreso-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_emision', 'Fecha Ingreso <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group{{ $errors->has('fec_emision') ? ' has-error' : ''}}">
                  {!! Form::text('fec_emision', isset($ingreso) ? date('d-m-Y', strtotime($ingreso->fecha_emision)) : '', ['class' => 'form-control input_blanco' , 'id' => 'fec_emision', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fec_emision-error"></div>
            </div>

            <div class="col-12 mt-2">
               {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold'])) !!}
               {!! Form::textarea('observaciones', isset($ingreso) ? $ingreso->observaciones : '', ['class' => 'form-control alfanumerico', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="observaciones-error"></div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-12">

      <div class="card card-border px-3" id="card_productos">
         <div class="card-body row">
            <div class="col-12 px-0 table-responsive">
               <table class="table table-sm table-hover table-bordered text-nowrap font-table w-100" id="tabla_ingres_productos">
                  <thead class="text-center">
                     <tr class="bg-light-blue ">
                        <th colspan="8" class="py-2">PRODUCTOS AGREGADOS</th>
                     </tr>
                     <tr class="bg-light-blue">
                        <th width="4%">N°</th>
                        <th width="26%">Producto</th>
                        <th width="12%">Presentación</th>
                        <th width="10%">Stock Actual</th>
                        <th width="8%">Cantidad</th>
                        <th width="10%">P. Unitario</th>
                        <th width="10%">Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($mov_productos as $producto)
                     <tr>
                        <td class="text-center">{{ $loop->index + 1  }}</td>
                        <td class="producto_typeahead" style="min-width: 90px;">
                           {!! Form::hidden('mvproducto_id[]', $producto->idMProducto, ['class' => 'form-control', 'readonly']) !!}
                           {!! Form::hidden('producto_id[]', $producto->idProducto, ['class' => 'form-control', 'id' => 'productoID_'.($loop->index + 1), 'readonly']) !!}
                           {!! Form::text('producto_ingreso[]', $producto->nomProducto, ['class' => 'form-control autocomplete_txt alfanumerico producto', 'placeholder' => 'BUSCAR PRODUCTO', 'maxlength' => '15', 'autocomplete' => 'off' , 'id' => 'producto_'.($loop->index + 1)]) !!}
                           <div class=" text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_id-error_{{ $loop->index + 1 }}">
                           </div>
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_ingreso-error_{{ $loop->index + 1 }}"></div>
                        </td>
                        <td>
                           {!! Form::text('pres_producto[]', $producto->presProducto, ['class' => 'form-control ', 'placeholder' => 'PRES.', 'id' => 'presProducto_'.($loop->index+1), 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('stock_producto[]', $producto->stock, ['class' => 'form-control ', 'placeholder' => 'STOCK', 'id' => 'stockIN_'.($loop->index+1), 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('cantidad_ingreso[]', $producto->cantidad, ['class' => 'form-control numeros3 decimal producto calcular_total ', 'placeholder' => 'CANTIDAD', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'cantidadIN_'.($loop->index+1) ]) !!}
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="cantidad_ingreso-error_{{ $loop->index + 1 }}"></div>
                        </td>
                        <td>
                           {!! Form::text('precio_unitario[]', $producto->precio_unitario, ['class' => 'form-control numeros3 decimal producto calcular_total', 'placeholder' => 'PRECIO', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'precioIN_'.($loop->index + 1)]) !!}
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="precio_unitario-error_{{ $loop->index + 1 }}"></div>
                        </td>
                        <td>
                           {!! Form::text('total[]', number_format($producto->total, 2), ['class' => 'form-control numeros3 decimal total', 'placeholder' => 'TOTAL', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'totalIN_'.($loop->index + 1), 'readonly']) !!}
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>

            <div class="col-12">
               <div class="row d-flex justify-content-end">
                  <div class="col-6 col-xl-2">
                     {!! Form::label('subtotal', 'SUBTOTAL', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-6 col-xl-2">
                     {!! Form::text('subTotalFinal', null, ['class' => 'form-control', 'placeholder' => 'SUBTOTAL', 'id' => 'subTotalFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>
            <div class="col-12 mt-2">
               <div class="row d-flex justify-content-end">
                  <div class="col-6 col-xl-2">
                     {!! Form::label('iva', 'IVA', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-6 col-xl-2">
                     {!! Form::text('ivaFinal', null, ['class' => 'form-control', 'placeholder' => 'IVA', 'id' => 'ivaFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>
            <div class="col-12 mt-2">
               <div class="row d-flex justify-content-end">
                  <div class="col-6 col-xl-2">
                     {!! Form::label('total', 'TOTAL', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-6 col-xl-2">
                     {!! Form::text('totalFinal', null, ['class' => 'form-control', 'placeholder' => 'TOTAL', 'id' => 'TotalFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>


         </div>



      </div>

   </div>
</div>