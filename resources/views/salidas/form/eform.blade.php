<div class="row d-flex justify-content-center">

   <div class="col-12">
      <div class="card card-border">
         <div class="card-body row">

            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 mt-2">
               {!! Html::decode(Form::label('cod_salida', 'Código', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('cod_salida', isset($salida) ? $salida->codigo : '', ['class' => 'form-control', 'placeholder' => 'CÓDIGO SALIDA', 'id' => 'cod_salida', 'readonly']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cod_salida-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-4 mt-2" id="nomcc_typeahead">
               {!! Html::decode(Form::label('nomcc', 'Nombre del C.C. <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_cc', isset($salida) ? $salida->instalacion->nombre : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE DEL C.C.', 'id' => 'nom_cc']) !!}
               {!! Form::hidden('id_cc', isset($salida) ? $salida->instalacion->id : '', ['id' => 'id_cc', 'readonly']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="nom_cc-error"></div>
            </div>

            {{-- *************************** CAMPOS AUTORELLENADOS - CENTROS DE COSTO ******************************* --}}
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_fantasia', isset($salida) ? $salida->instalacion->nom_fantasia : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA C.C.', 'id' => 'nom_fantasia', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'RUT C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_cc', isset($salida) ? $salida->instalacion->nrodoc : '', ['class' => 'form-control', 'placeholder' => 'RUT DEL C.C.','id' => 'rut_cc', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('tel_cc', 'Teléfono C.C.', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('tel_cc', isset($salida) ? $salida->instalacion->telefono : '', ['class' => 'form-control', 'placeholder' => 'TELÉFONO C.C.', 'id' => 'tel_cc', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-phone-rotary"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('region', isset($salida) ? $salida->instalacion->region->nombre : '', ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'id' => 'region', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('provincia', isset($salida) ? $salida->instalacion->provincia->nombre : '', ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'id' => 'provincia', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('comuna', isset($salida) ? $salida->instalacion->comuna->nombre : '', ['class' => 'form-control', 'placeholder' => 'COMUNA', 'id' => 'comuna', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-7 col-xl-5 mt-2">
               {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('dir_cc', isset($salida) ? $salida->instalacion->direccion : '', ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'id' => 'dir_cc', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-5 col-xl-4 mt-2">
               {!! Html::decode(Form::label('nom_contacto', 'Nombre Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('nom_contacto', isset($salida) ? $salida->instalacion->nom_contacto : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE CONTACTO', 'id' => 'nom_contacto', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('nro_contacto', 'RUT Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_contacto', isset($salida) ? $salida->instalacion->nrodoc_contacto : '', ['class' => 'form-control', 'placeholder' => 'RUT CONTACTO', 'id' => 'rut_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('cel_contacto', 'Celular Contacto', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('cel_contacto', isset($salida) ? $salida->instalacion->cel_contacto : '', ['class' => 'form-control', 'placeholder' => 'CELULAR CONTACTO', 'id' => 'cel_contacto', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-mobile-android-alt"></i>
                  </div>
               </div>
            </div>
            {{-- *************************** // CAMPOS AUTORELLENADOS - CENTROS DE COSTO ******************************* --}}

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_inicio', 'Fecha Inicio <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_inicio', isset($salida) ? date('d-m-Y', strtotime($salida->fecha_inicial)) : '', ['class' => 'form-control input_blanco' , 'id' => 'fecha_inicio', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fecha_inicio-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('fecha_fin', 'Fecha Fin <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_fin', isset($salida) ? date('d-m-Y', strtotime($salida->fecha_final)) : '', ['class' => 'form-control input_blanco' , 'id' => 'fecha_fin', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fecha_fin-error"></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
               {!! Html::decode(Form::label('usu_responsable', 'Usuario Creador', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('usu_responsable', $salida->usuario_creador->name, ['class' => 'form-control', 'placeholder' => 'RESPONSABLE', 'id' => 'usu_responsable', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-4 mt-2">
               {!! Html::decode(Form::label('recibido_por', 'Recibido por', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::text('recibido_por', isset($salida) ? $salida->recibido_por : '', ['class' => 'form-control letras', 'placeholder' => 'NOMBRES', 'autocomplete' => 'off', 'maxlength' => '50', 'id' => 'recibido_por']) !!}
               <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="recibido_por-error"></div>
            </div>

            <div class="col-12 col-lg-8 col-xl-8 mt-2">
               {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::textarea('observaciones', isset($salida) ? $salida->observaciones : '', ['class' => 'form-control alfanumerico', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
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
                        <th width="40%">Producto</th>
                        <th width="25%">Presentación</th>
                        <th width="15%">Stock Actual</th>
                        <th width="15%">Cantidad</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($mov_productos as $producto)
                     <tr>
                        <td class="text-center">{{ $loop->index + 1  }}</td>
                        <td class="producto_typeahead">
                           {!! Form::hidden('mvproducto_id[]', $producto->idMProducto, ['class' => 'form-control', 'readonly']) !!}
                           {!! Form::hidden('producto_id[]', $producto->idProducto, ['class' => 'form-control', 'id' => 'productoID_'.($loop->index + 1), 'readonly']) !!}
                           {!! Form::text('producto_ingreso[]', $producto->nomProducto, ['class' => 'form-control autocomplete_txt alfanumerico producto', 'placeholder' => 'BUSCAR PRODUCTO', 'maxlength' => '15', 'autocomplete' => 'off' , 'id' => 'producto_'.($loop->index + 1)]) !!}
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

                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>



         </div>



      </div>

   </div>




</div>