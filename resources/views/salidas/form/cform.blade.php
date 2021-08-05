<div class="row d-flex justify-content-center">

   <div class="col-12">
      <div class="card card-border">
         <div class="card-body row">

            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 mt-2">
               {!! Html::decode(Form::label('cod_salida', 'N° Registro', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('cod_salida', $num_registro, ['class' => 'form-control', 'placeholder' => 'CÓDIGO SALIDA', 'id' => 'cod_salida', 'readonly']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cod_salida-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-4 mt-2" id="nomcc_typeahead">
               {!! Html::decode(Form::label('nomcc', 'Nombre del C.C. <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_cc', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE DEL C.C.', 'id' => 'nom_cc']) !!}
               {!! Form::hidden('id_cc', null, ['id' => 'id_cc', 'readonly']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nom_cc-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_fantasia', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA C.C.', 'id' => 'nom_fantasia', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'RUT C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_cc', null, ['class' => 'form-control', 'placeholder' => 'RUT DEL C.C.','id' => 'rut_cc', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tel_cc', 'Teléfono C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('tel_cc', null, ['class' => 'form-control', 'placeholder' => 'TELÉFONO C.C.', 'id' => 'tel_cc', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-phone-rotary"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('region', null, ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'id' => 'region', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('provincia', null, ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'id' => 'provincia', 'readonly']) !!}
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('comuna', null, ['class' => 'form-control', 'placeholder' => 'COMUNA', 'id' => 'comuna', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-7 col-xl-5 mt-2">
               {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('dir_cc', null, ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'id' => 'dir_cc', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-5 col-xl-4 mt-2">
               {!! Html::decode(Form::label('nom_contacto', 'Nombre Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_contacto', null, ['class' => 'form-control', 'placeholder' => 'NOMBRE CONTACTO', 'id' => 'nom_contacto', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nro_contacto', 'RUT Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_contacto', null, ['class' => 'form-control', 'placeholder' => 'RUT CONTACTO', 'id' => 'rut_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('cel_contacto', 'Celular Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('cel_contacto', null, ['class' => 'form-control', 'placeholder' => 'CELULAR CONTACTO', 'id' => 'cel_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-mobile-android-alt"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_inicio', 'Fecha Inicio <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_inicio', null, ['class' => 'form-control input_blanco' , 'id' => 'fecha_inicio', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fecha_inicio-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_fin', 'Fecha Fin <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_fin', null, ['class' => 'form-control input_blanco' , 'id' => 'fecha_fin', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fecha_fin-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('usu_responsable', 'Usuario Responsable', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('usu_responsable', $creado_por, ['class' => 'form-control', 'placeholder' => 'RESPONSABLE', 'id' => 'usu_responsable', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-4 mt-2">
               {!! Html::decode(Form::label('recibido_por', 'Recibido por', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('recibido_por', null, ['class' => 'form-control letras', 'placeholder' => 'NOMBRES', 'autocomplete' => 'off', 'maxlength' => '50', 'id' => 'recibido_por']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="recibido_por-error"></div>
            </div>

            <div class="col-12 col-lg-8 col-xl-8 t-2">
               {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::textarea('observaciones', null, ['class' => 'form-control alfanumerico', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="observaciones-error"></div>
            </div>


         </div>

      </div>
   </div>

   <div class="col-12">

      <div class="card card-border px-3" id="card_productos">
         <div class="card-body row">

            <div class="col-12 px-0 table-responsive">
               <table class="table table-sm table-hover table-bordered text-nowrap font-table w-100" id="tabla_salida_productos">
                  <thead class="text-center">
                     <tr class="bg-light-blue ">
                        <th colspan="6" class="py-2">PRODUCTOS ENTREGADOS</th>
                     </tr>
                     <tr class="bg-light-blue">
                        <th width="5%">N°</th>
                        <th width="35%">Producto</th>
                        <th width="20%">Presentación</th>
                        <th width="15%">Stock Actual</th>
                        <th width="15%">Cantidad</th>
                        <th width="10%">Acción</th>
                     </tr>
                  </thead>
                  <tbody class="text-center">
                     <tr>
                        <td>
                           <span>1</span>
                        </td>
                        <td class="producto_typeahead">
                           {!! Form::hidden('producto_id[]', null, ['class' => 'form-control', 'id' => 'productoID_1', 'readonly']) !!}
                           {!! Form::text('producto_ingreso[]', null, ['class' => 'form-control autocomplete_txt alfanumerico producto', 'placeholder' => 'BUSCAR PRODUCTO', 'maxlength' => '15', 'autocomplete' => 'off' , 'id' => 'producto_1']) !!}
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_id-error_1"></div>
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_ingreso-error_1"></div>
                        </td>

                        <td>
                           {!! Form::text('pres_producto[]', null, ['class' => 'form-control ', 'placeholder' => 'PRESENTACION', 'id' => 'presProducto_1', 'readonly']) !!}
                        </td>

                        <td>
                           {!! Form::text('stock_producto[]', null, ['class' => 'form-control ', 'placeholder' => 'STOCK', 'id' => 'stockIN_1', 'readonly']) !!}
                        </td>

                        <td>
                           {!! Form::text('cantidad_ingreso[]', null, ['class' => 'form-control numeros3 decimal producto calcular_total', 'placeholder' => 'CANTIDAD', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'cantidadIN_1']) !!}
                           <div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="cantidad_ingreso-error_1"></div>
                        </td>

                        <td>
                           {!! Form::button('<i class="far fa-plus fa-lg"></i>', ['class'=>'btn btn-success agregar_fila', 'type' => 'button', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Agregar']) !!}
                        </td>


                     </tr>
                  </tbody>
               </table>
            </div>



         </div>



      </div>

   </div>




</div>