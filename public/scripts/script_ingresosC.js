$(function () {

   function init() {


      events();
      agregar_fila();
      eliminar_fila();
      datos_proveedor();
      buscar_producto();
      total_productos();
      alerts();
      enviar_datos();
      alertas_array();
      totales_productos();

   }

   function events() {

      $('#proveedor').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         // minimumResultsForSearch: -1,
         language: "es",
      });

      $('#tipodoc_ingreso').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      // ********** DATEPICKER *******************/
      $('#fec_emision').datepicker({
         'format': 'dd-mm-yyyy',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'orientation': "bottom",
      });
   }


   // *********************************************************************
   // ******************* Añadir y Remover Campos *************************
   // *********************************************************************

   var tr = $('table tr').length;
   var i = tr - 1;

   function agregar_fila() {

      $('tbody').on('click', '.agregar_fila', function () {

         var count = $('table tbody tr').length;

         var html = '';
         html += '<tr>';
         html += '<td>';
         html += '<span>' + [count + 1] + '</span>';
         html += '</td>';
         html += '<td class="producto_typeahead">';
         html += '<input type="hidden" name="producto_id[]" id="productoID_' + i + '" class="form-control" readonly/>';
         html += '<input type="text" name="producto_ingreso[]" id="producto_' + i + '" class="form-control autocomplete_txt alfanumerico producto" placeholder="BUSCAR PRODUCTO" maxlength="40" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_id-error_' + i + '"></div>'
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="producto_ingreso-error_' + i + '"></div>'
         html += '</td>';
         html += '<td>'
         html += '<input type="text" name="pres_producto[]" id="presProducto_' + i + '" class="form-control" placeholder="PRES." readonly/>';
         html += '</td>';
         html += '<td>'
         html += '<input type="text" name="stock_producto[]" id="stockIN_' + i + '" class="form-control" placeholder="STOCK" readonly/>';
         html += '</td>';
         html += '<td>'
         html += '<input type="text" name="cantidad_ingreso[]" id="cantidadIN_' + i + '" class="form-control numeros3 decimal calcular_total producto" placeholder="CANTIDAD" maxlength="9" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="cantidad_ingreso-error_' + i + '"></div>'
         html += '</td>';
         html += '<td>';
         html += '<input type="text" name="precio_unitario[]" id="precioIN_' + i + '" class="form-control numeros3 decimal producto calcular_total" placeholder="PRECIO" maxlength="9" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="precio_unitario-error_' + i + '"></div>'
         html += '</td>';
         // html += '<td>';
         // html += '<input type="text" name="iva[]" id="ivaIN_' + i + '" class="form-control numeros3 decimal producto calcular_total" placeholder="IVA(%)" maxlength="9" autocomplete="off"/>';
         // html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert alert_table" id="iva-error_' + i + '"></div>';
         // html += '</td>';
         // html += '<td>';
         // html += '<input type="text" name="sub_total[]" id="subtotalIN_' + i + '" class="form-control numeros3 decimal producto subtotal" placeholder="SUBTOTAL" autocomplete="off" readonly/>';
         // html += '</td>';
         html += '<td>';
         html += '<input type="text" name="total[]" id="totalIN_' + i + '" class="form-control numeros3 decimal producto total" placeholder="TOTAL" autocomplete="off" readonly/>';
         html += '</td>';
         html += '<td>';
         html += '<button type="button" class="btn btn-danger eliminar_fila" data-bs-toggle="tooltip" data-bs-placement="top" title= "Eliminar"/><i class="far fa-minus fa-lg"></i></button>';
         html += '</td>';
         html += '</tr>';

         $('tbody').append(html);
         buscar_producto();
         i++;



         // *************************** VALIDACIONES NÚMERICAS *************************
         // *************** PERMITIR SOLO LETRAS Y NUMEROS *******************
         $(".alfanumerico").bind('keypress', function (event) {
            var regex = new RegExp("^[a-zA-Z0-9 -]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
         });

         $(".alfanumerico2").bind('keypress', function (event) {
            var regex = new RegExp("^[a-zA-Z0-9 -.#]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
         });


         $(".numeros3").bind('keypress', function (event) {
            var regex = new RegExp("^[0-9.]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
         });

         // ************** ACEPTAR N CANTIDAD DE DECIMALES ****************

         $('.decimal').on('keypress', function (e) {
            var character = String.fromCharCode(e.keyCode)
            var newValue = this.value + character;
            if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
               e.preventDefault();
               return false;
            }
         });

         function hasDecimalPlace(value, x) {
            var pointIndex = value.indexOf('.');
            return pointIndex >= 0 && pointIndex < value.length - x;
         }

         // ******************* FIN VALIDACIONES *****************


      });

   }

   function eliminar_fila() {
      $('tbody').on('click', '.eliminar_fila', function () {
         $(this).parents('tr').remove();

         $('table tbody tr').each(function (i) {
            $($(this).find('td')[0]).html(i + 1);
         });
         i--
      });
   }


   function total_productos() {


      $(document).on('keyup', 'table tr .form-control', function () {

         var id_sum = $(this).attr('id');
         var id = id_sum.split('_');
         var elementID = id[id.length - 1];

         var cantidad = $('#cantidadIN_' + elementID).val();
         var precio = $('#precioIN_' + elementID).val();
         var iva = $('#ivaIN_' + elementID).val();

         if (iva == "" || iva == null) {
            var total = (cantidad * precio);
         } else {
            var total = (cantidad * precio) / iva;
         }

         $('#totalIN_' + elementID).val(total);


      });

   }

   function datos_proveedor() {

      var path = route('datos_proveedor');

      let outerData = [];
      $('#nom_proveedor').typeahead({

         source: function (proveedor, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: proveedor },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.nom_proveedor;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_proveedor'] === item);
            html = '';
            html = outerData[data]['nom_proveedor'];
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['nom_proveedor'] === item);
            $('#id_proveedor').val(outerData[data]['id_proveedor']);
            $('#nom_proveedor').val(outerData[data]['nom_proveedor']);
            $('#nom_fantasia').val(outerData[data]['nom_fantasia']);
            $('#rut_proveedor').val(outerData[data]['rut_proveedor']);
            $('#tel_proveedor').val(outerData[data]['tel_proveedor']);
            $('#dir_proveedor').val(outerData[data]['dir_proveedor']);
            $('#nom_contacto').val(outerData[data]['nom_contacto']);
            $('#rut_contacto').val(outerData[data]['rut_contacto']);
            $('#cel_contacto').val(outerData[data]['cel_contacto']);
            $('#region').val(outerData[data]['region']);
            $('#provincia').val(outerData[data]['provincia']);
            $('#comuna').val(outerData[data]['comuna']);

            return item;
         },
         minLength: 1,
         items: 10,

      });
   }


   function buscar_producto() {

      var path = route('buscar_producto');

      let outerData = [];
      $('.autocomplete_txt').typeahead({

         source: function (producto, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: producto },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.nom_producto;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_producto'] === item);
            html = '';
            html += '<strong>' + outerData[data]['nom_producto'] + '</strong>' + ' - ' + outerData[data]['pres_producto'];
            return html;
         },
         updater: function (item) {
            // OBTENER EL ID DE LA ACTUAL FILA
            var id_original = this.$element.attr('id');
            var parte = id_original.split('_');
            var elementoID = parte[parte.length - 1];

            let data = Object.keys(outerData).find(key => outerData[key]['nom_producto'] === item);
            $('#presProducto_' + elementoID).val(outerData[data]['pres_producto']);
            $('#productoID_' + elementoID).val(outerData[data]['id_producto']);
            $('#stockIN_' + elementoID).val(outerData[data]['stock_producto']);
            // Vaciar campos para evitar agregar cantidad superior al stock actual
            $('#cantidadIN_' + elementoID).val('');
            $('#precioIN_' + elementoID).val('');
            $('#ivaIN_' + elementoID).val('');
            return item;
         },
         minLength: 1,
         items: 10,

      });
   }


   function alerts() {

      $("#nom_proveedor").on("keyup", function () {
         if ($("#nom_proveedor-error").text() != "") {
            if ($(this).val().length) {
               $("#nom_proveedor-error").addClass("d-none");
               $("#nom_proveedor").removeClass("is-invalid");
            } else {
               $("#nom_proveedor-error").removeClass("d-none");
               $("#nom_proveedor").addClass("is-invalid");
            }
         }
      });

      $("#tipodoc_ingreso").on("change", function () {
         if ($("#tipodoc_ingreso-error").text() != "") {
            if ($(this).val() == "") {
               $("#tipodoc_ingreso-error").removeClass("d-none");
               $(this).parent().addClass(" has-error-select2");
            } else {
               $("#tipodoc_ingreso-error").addClass("d-none");
               $(this).parent().removeClass(" has-error-select2");
            }
         }
      });

      $("#nrodoc_ingreso").on("keyup", function () {
         if ($("#nrodoc_ingreso-error").text() != "") {
            if ($(this).val().length) {
               $("#nrodoc_ingreso-error").addClass("d-none");
               $("#nrodoc_ingreso").removeClass("is-invalid");
            } else {
               $("#nrodoc_ingreso-error").removeClass("d-none");
               $("#nrodoc_ingreso").addClass("is-invalid");
            }
         }
      });

      $("#fec_emision").on("change", function () {
         if ($("#fec_emision-error").text() != "") {
            if ($(this).val().length) {
               $("#fec_emision-error").addClass("d-none");
               $("#fec_emision").removeClass("is-invalid");
            } else {
               $("#fec_emision-error").removeClass("d-none");
               $("#fec_emision").addClass("is-invalid");
            }
         }
      });

   }

   function alertas_array() {

      $(document).on('keyup', '.producto', function () {

         var id = $(this).attr('id');

         $('#' + id).removeClass("is-invalid");
         var texto = $('#' + id).closest('td').find('div').text();
         var clase = $('#' + id).closest('td').find('div');
         var borde = $('#' + id);

         if (texto != "") {
            if ($(this).val().length) {
               clase.addClass('d-none');
               borde.removeClass('is-invalid');
            } else {
               clase.removeClass('d-none');
               borde.addClass('is-invalid');
            }
         }

      });

   }

   function totales_productos() {
      $(document).on('keyup', 'table tr .calcular_total', function () {

         // OBTENER EL ID DE LA ACTUAL FILA 
         var id_original = $(this).attr('id');
         var parte = id_original.split('_');
         var elementoID = parte[parte.length - 1];

         var producto = $('#producto_' + elementoID).val();
         var cantidad = $('#cantidadIN_' + elementoID).val();
         var p_unitario = $('#precioIN_' + elementoID).val();

         if (producto == '') {

            toastr["warning"]("Seleccionar un producto.");
            $('#cantidadIN_' + elementoID).val('');
            $('#precioIN_' + elementoID).val('');

         } else {

            var cantidadUnitaria = isNaN(cantidad) || $.trim(cantidad) === "" ? 0 : parseFloat(cantidad);
            var costoUnitario = isNaN(p_unitario) || $.trim(p_unitario) === "" ? 0 : parseFloat(p_unitario);

            var total = cantidadUnitaria * costoUnitario;
            $('#totalIN_' + elementoID).val(total).number(true, 2);

            // ************** SUMA TOTALES ****************
            var sum_totales = 0;

            arrayTotal = new Array();
            $('.total').each(function () {
               arrayTotal.push($(this).val());
            });

            // ------------------------------------

            $.each(arrayTotal, function () {
               val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
               sum_totales += val;
            });

            $('#subTotalFinal').val(sum_totales).number(true, 2);
            $('#ivaFinal').val(sum_totales * 0.19).number(true, 2);
            $('#TotalFinal').val(sum_totales + (sum_totales * 0.19)).number(true, 2);

         }

      });

   }

   function enviar_datos() {

      $('#form-ingreso').on('submit', function (event) {

         event.preventDefault();
         $.ajax({
            url: route('ingresos.store'),
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {

               if (data.errors) {

                  if (data.errors.nom_proveedor) {
                     $('#nom_proveedor-error').removeClass('d-none');
                     $('#nom_proveedor').addClass('is-invalid');
                     $('#nom_proveedor-error').html(data.errors.nom_proveedor[0]);
                  }

                  if (data.errors.id_proveedor) {
                     $('#nom_proveedor-error').removeClass('d-none');
                     $('#nom_proveedor').addClass('is-invalid');
                     $('#nom_proveedor-error').html(data.errors.id_proveedor[0]);
                  }

                  if (data.errors.tipodoc_ingreso) {
                     $('#tipodoc_ingreso-error').removeClass('d-none');
                     $('#tipodoc_ingreso').parent().addClass('has-error-select2');
                     $('#tipodoc_ingreso-error').html(data.errors.tipodoc_ingreso[0]);
                  }

                  if (data.errors.nrodoc_ingreso) {
                     $('#nrodoc_ingreso-error').removeClass('d-none');
                     $('#nrodoc_ingreso').addClass('is-invalid');
                     $('#nrodoc_ingreso-error').html(data.errors.nrodoc_ingreso[0]);
                  }

                  if (data.errors.fec_emision) {
                     $('#fec_emision-error').removeClass('d-none');
                     $('#fec_emision').addClass('is-invalid');
                     $('#fec_emision-error').html(data.errors.fec_emision[0]);
                  }

                  // ********** VALIDACIONES ARRAY *************

                  for (c = 0; c <= i; c++) {

                     // **************** VALIDACIONES - OTROS ALMACENES *******************

                     if (data.errors["producto_id." + [c - 1]]) {
                        $('#producto_ingreso-error_' + c).removeClass('d-none');
                        $('#producto_' + c).addClass('is-invalid');
                        $('#producto_ingreso-error_' + c).html(data.errors["producto_id." + [c - 1]][0]);
                     }

                     if (data.errors["producto_ingreso." + [c - 1]]) {
                        $('#producto_ingreso-error_' + c).removeClass('d-none');
                        $('#producto_' + c).addClass('is-invalid');
                        $('#producto_ingreso-error_' + c).html(data.errors["producto_ingreso." + [c - 1]][0]);
                     }

                     if (data.errors["cantidad_ingreso." + [c - 1]]) {
                        $('#cantidad_ingreso-error_' + c).removeClass('d-none');
                        $('#cantidadIN_' + c).addClass('is-invalid');
                        $('#cantidad_ingreso-error_' + c).html(data.errors["cantidad_ingreso." + [c - 1]][0]);
                     }

                     if (data.errors["precio_unitario." + [c - 1]]) {
                        $('#precio_unitario-error_' + c).removeClass('d-none');
                        $('#precioIN_' + c).addClass('is-invalid');
                        $('#precio_unitario-error_' + c).html(data.errors["precio_unitario." + [c - 1]][0]);
                     }

                     if (data.errors["iva." + [c - 1]]) {
                        $('#iva-error_' + c).removeClass('d-none');
                        $('#ivaIN_' + c).addClass('is-invalid');
                        $('#iva-error_' + c).html(data.errors["iva." + [c - 1]][0]);
                     }
                  }
               }

               if (data.success) {

                  Swal.fire({
                     text: "¿Desea imprimir el nuevo ingreso?",
                     icon: "success",
                     showCancelButton: true,
                     confirmButtonText: "Si",
                     cancelButtonText: "No",
                     customClass: {
                        confirmButton: "btn btn-success  px-5 mr-2",
                        cancelButton: "btn btn-light px-5",
                     },
                     buttonsStyling: false,
                  }).then((result) => {
                     if (result.value) {

                        descargarPDF = route('impresion.ingresos') + '?ingreso_id=' + data.success,
                           window.open(descargarPDF);

                        var loc = window.location;
                        window.location = loc.protocol + "/ingresos";
                     } else {

                        var loc = window.location;
                        window.location = loc.protocol + "/ingresos";

                     }

                  });

               }

            }
         })


      });
   }




   init();


});