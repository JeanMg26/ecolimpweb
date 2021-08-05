<div class="row d-flex justify-content-center">

   <div class="col-12">
      <div class="card card-border">
         <div class="card-body row">

            <div class="col-12 col-sm-6 col-lg-4 col-xl-2 mt-2">
               {!! Html::decode(Form::label('num_registro', 'N° Registro', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('cod_ingreso', $num_registro, ['class' => 'form-control', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-8 col-xl-4 mt-2" id="nomproveedor_typeahead">
               {!! Html::decode(Form::label('proveedor', 'Proveedor <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_proveedor', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE DEL PROVEEDOR', 'id' => 'nom_proveedor']) !!}
               {!! Form::hidden('id_proveedor', null, ['id' => 'id_proveedor']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nom_proveedor-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_fantasia', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA', 'readonly', 'id' => 'nom_fantasia']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'RUT Proveedor', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_proveedor', null, ['class' => 'form-control', 'placeholder' => 'RUT PROVEEDOR','id' => 'rut_proveedor', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tel_proveedor', 'Teléfono Proveedor', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('tel_proveedor', null, ['class' => 'form-control', 'placeholder' => 'TELÉFONO PROVEEDOR', 'id' => 'tel_proveedor', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-phone-rotary"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('region', null, ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'id' => 'region', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('provincia', null, ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'id' => 'provincia', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('comuna', null, ['class' => 'form-control', 'placeholder' => 'COMUNA', 'id' => 'comuna', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-7 col-xl-5 mt-2">
               {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('dir_proveedor', null, ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'id' => 'dir_proveedor', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-5 col-xl-4 mt-2">
               {!! Html::decode(Form::label('nom_contacto', 'Nombre Contacto', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('nom_contacto', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE CONTACTO', 'id' => 'nom_contacto', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nro_contacto', 'RUT Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_contacto', null, ['class' => 'form-control', 'placeholder' => 'RUT CONTACTO', 'id' => 'rut_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('cel_contacto', 'Celular Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('cel_contacto', null, ['class' => 'form-control', 'placeholder' => 'CELULAR CONTACTO', 'id' => 'cel_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-mobile-android-alt"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tipodocumento', 'Tipo de Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold ledit'])) !!}
               {!! Form::select('tipodoc_ingreso', ['BOLETA' => 'BOLETA', 'FACTURA' => 'FACTURA', 'GUÍA DE DESPACHO' => 'GUÍA DE DESPACHO'], null, ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'tipodoc_ingreso']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="tipodoc_ingreso-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'N° Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('nrodoc_ingreso', null, ['class' => 'form-control alfanumerico', 'placeholder' => 'NÚMERO DOCUMENTO', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'nrodoc_ingreso']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-file-invoice"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nrodoc_ingreso-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_emision', 'Fecha Ingreso <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('fec_emision', null, ['class' => 'form-control input_blanco' , 'id' => 'fec_emision', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fec_emision-error"></div>
            </div>

            <div class="col-12 mt-2">
               {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold'])) !!}
               {!! Form::textarea('observaciones', null, ['class' => 'form-control alfanumerico', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="observaciones-error"></div>
            </div>


         </div>

      </div>
   </div>

   <div class="col-12">

      <div class="card card-border px-3" id="card_productos">
         <div class="card-body row">

            <div class="col-12 px-0">
               <div class="table-responsive">
                  <table class="table table-sm table-hover table-bordered text-nowrap font-table w-100" id="tabla_ingres_productos">
                     <thead class="text-center">
                        <tr class="bg-light-blue ">
                           <th colspan="10" class="py-2">PRODUCTOS AGREGADOS</th>
                        </tr>
                        <tr class="bg-light-blue">
                           <th width="5%">N°</th>
                           <th width="25%">Producto</th>
                           <th width="12%">Presentación</th>
                           <th width="8%">Stock Actual</th>
                           <th width="7%">Cantidad</th>
                           <th width="9%">P. Unitario</th>
                           <th width="9%">Total</th>
                           <th width="8%">Acción</th>
                        </tr>
                     </thead>
                     <tbody class="text-center">
                        <tr>
                           <td>
                              <span>1</span>
                           </td>
                           <td class="producto_typeahead" style="min-width: 90px;">
                              {!! Form::hidden('producto_id[]', null, ['class' => 'form-control', 'id' => 'productoID_1', 'readonly']) !!}
                              {!! Form::text('producto_ingreso[]', null, ['class' => 'form-control autocomplete_txt alfanumerico producto', 'placeholder' => 'BUSCAR PRODUCTO', 'maxlength' => '15', 'autocomplete' => 'off' , 'id' => 'producto_1']) !!}
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_id-error_1"></div>
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_ingreso-error_1"></div>
                           </td>

                           <td>
                              {!! Form::text('pres_producto[]', null, ['class' => 'form-control ', 'placeholder' => 'PRESENT.', 'id' => 'presProducto_1', 'readonly']) !!}
                           </td>

                           <td>
                              {!! Form::text('stock_producto[]', null, ['class' => 'form-control ', 'placeholder' => 'STOCK', 'id' => 'stockIN_1', 'readonly']) !!}
                           </td>

                           <td>
                              {!! Form::text('cantidad_ingreso[]', null, ['class' => 'form-control numeros3 decimal producto calcular_total', 'placeholder' => 'CANT.', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'cantidadIN_1']) !!}
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="cantidad_ingreso-error_1"></div>
                           </td>

                           <td>
                              {!! Form::text('precio_unitario[]', null, ['class' => 'form-control numeros3 decimal producto calcular_total', 'placeholder' => 'PRECIO', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'precioIN_1']) !!}
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="precio_unitario-error_1"></div>
                           </td>

                           <td>
                              {!! Form::text('total[]', null, ['class' => 'form-control numeros3 decimal total', 'placeholder' => 'TOTAL', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'totalIN_1', 'readonly']) !!}
                           </td>

                           <td>
                              {!! Form::button('<i class="far fa-plus fa-lg"></i>', ['class'=>'btn btn-success agregar_fila', 'type' => 'button', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Agregar']) !!}
                           </td>


                        </tr>
                     </tbody>
                  </table>
               </div>
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