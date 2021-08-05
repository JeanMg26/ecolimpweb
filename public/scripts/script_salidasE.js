$(function () {

   // *********** OBTENIENDO LA CANTIDAD DE FILAS **************
   var tr = $('table tr').length;
   var i = tr - 1;
   // **********************************************************

   function init() {


      events();

      buscar_producto();
      datos_instalacion();
      alerta_cantidad();
      enviar_datos();
      quitar_alertas();
      quitar_alertas_array();
   }

   function events() {

      // ********** DATEPICKER PARA FILTRAR POR FECHAS *******************/

      var getDate = function (input) {
         return new Date(input.date.valueOf());
      }

      $('#fecha_inicio').datepicker({
         'format': 'dd-mm-yyyy',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'orientation': 'bottom auto',
      }).on('changeDate',
         function (selected) {
            $('#fecha_fin').datepicker('clearDates');
            $('#fecha_fin').datepicker('setStartDate', getDate(selected));
         });

      $('#fecha_fin').datepicker({
         'format': 'dd-mm-yyyy',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'orientation': 'bottom auto'
      });


   }

   function buscar_producto() {

      var path = route('buscar_producto.salida');

      let outerData = [];

      $('.autocomplete_txt').typeahead({
         source: function (producto, result) {
            // Limpiar inputs cada vez que se cambia de producto
            var id_original = this.$element.attr('id');
            var parte = id_original.split('_');
            var elementoID = parte[parte.length - 1];

            $('#productoID_' + elementoID).val('');
            $('#presProducto_' + elementoID).val('');
            $('#stockIN_' + elementoID).val('');

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
            return item;
         },
         minLength: 1,
         items: 10,

      });
   }

   function datos_instalacion() {

      var path = route('datos_instalacion.salida');

      let outerData = [];
      $('#nom_cc').typeahead({

         source: function (instalacion, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: instalacion },
               dataType: 'json',
               success: function (data) {
                  $('#id_cc').val('');
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.nom_instalacion;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_instalacion'] === item);
            html = '';
            html = outerData[data]['nom_instalacion'];
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['nom_instalacion'] === item);
            $('#id_cc').val(outerData[data]['id_instalacion']);
            $('#nom_cc').val(outerData[data]['nom_instalacion']);
            $('#nom_fantasia').val(outerData[data]['nom_fantasia']);
            $('#rut_cc').val(outerData[data]['rut_instalacion']);
            $('#tel_cc').val(outerData[data]['tel_instalacion']);
            $('#dir_cc').val(outerData[data]['dir_instalacion']);
            $('#region').val(outerData[data]['region']);
            $('#provincia').val(outerData[data]['provincia']);
            $('#comuna').val(outerData[data]['comuna']);
            $('#nom_contacto').val(outerData[data]['nom_contacto']);
            $('#rut_contacto').val(outerData[data]['rut_contacto']);
            $('#cel_contacto').val(outerData[data]['cel_contacto']);

            return item;
         },
         minLength: 1,
         items: 10,

      });
   }

   function quitar_alertas() {

      $("#cod_salida").on("keyup", function () {
         if ($("#cod_salida-error").text() != "") {
            if ($(this).val().length) {
               $("#cod_salida-error").addClass("d-none");
               $("#cod_salida").removeClass("is-invalid");
            } else {
               $("#cod_salida-error").removeClass("d-none");
               $("#cod_salida").addClass("is-invalid");
            }
         }
      });

      $("#recibido_por").on("keyup", function () {
         if ($("#recibido_por-error").text() != "") {
            if ($(this).val().length) {
               $("#recibido_por-error").addClass("d-none");
               $("#recibido_por").removeClass("is-invalid");
            } else {
               $("#recibido_por-error").removeClass("d-none");
               $("#recibido_por").addClass("is-invalid");
            }
         }
      });

      $("#nom_cc").on("keyup", function () {
         if ($("#nom_cc-error").text() != "") {
            if ($(this).val().length) {
               $("#nom_cc-error").addClass("d-none");
               $("#nom_cc").removeClass("is-invalid");
            } else {
               $("#nom_cc-error").removeClass("d-none");
               $("#nom_cc").addClass("is-invalid");
            }
         }
      });

      $("#fecha_inicio").on("change", function () {
         if ($("#fecha_inicio-error").text() != "") {
            if ($(this).val().length) {
               $("#fecha_inicio-error").addClass("d-none");
               $("#fecha_inicio").removeClass("is-invalid");
            } else {
               $("#fecha_inicio-error").removeClass("d-none");
               $("#fecha_inicio").addClass("is-invalid");
            }
         }
      });

      $("#fecha_fin").on("change", function () {
         if ($("#fecha_fin-error").text() != "") {
            if ($(this).val().length) {
               $("#fecha_fin-error").addClass("d-none");
               $("#fecha_fin").removeClass("is-invalid");
            } else {
               $("#fecha_fin-error").removeClass("d-none");
               $("#fecha_fin").addClass("is-invalid");
            }
         }
      });

   }

   function quitar_alertas_array() {

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

   function alerta_cantidad() {
      $(document).on('keyup', 'table tr .calcular_total', function () {

         // OBTENER EL ID DE LA ACTUAL FILA 
         var id_original = $(this).attr('id');
         var parte = id_original.split('_');
         var elementoID = parte[parte.length - 1];

         var producto = $('#producto_' + elementoID).val();
         var stockUnitario = $('#stockIN_' + elementoID).val();
         var cantidad = $('#cantidadIN_' + elementoID).val();


         if (producto == '') {

            toastr["warning"]("Seleccionar un producto.");
            $('#cantidadIN_' + elementoID).val('');

         } else {

            // No permitir ingresar cantidad superior al stock actual
            if (stockUnitario != '') {
               if (cantidad > parseFloat(stockUnitario)) {
                  toastr["warning"]("La cantidad no puede ser exceder al stock actual");
                  $(this).val('');
               }
            }

         }

      });

   }

   function enviar_datos() {

      $('#form-salida').on('submit', function (event) {

         event.preventDefault();
         $.ajax({
            url: route('salidas.update'),
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {

               if (data.errors) {

                  if (data.errors.cod_salida) {
                     $('#cod_salida-error').removeClass('d-none');
                     $('#cod_salida').addClass('is-invalid');
                     $('#cod_salida-error').html(data.errors.cod_salida[0]);
                  }

                  if (data.errors.nom_cc) {
                     $('#nom_cc-error').removeClass('d-none');
                     $('#nom_cc').addClass('is-invalid');
                     $('#nom_cc-error').html(data.errors.nom_cc[0]);
                  }


                  if (data.errors.id_cc) {
                     $('#nom_cc-error').removeClass('d-none');
                     $('#nom_cc').addClass('is-invalid');
                     $('#nom_cc-error').html(data.errors.id_cc[0]);
                  }

                  if (data.errors.fecha_inicio) {
                     $('#fecha_inicio-error').removeClass('d-none');
                     $('#fecha_inicio').addClass('is-invalid');
                     $('#fecha_inicio-error').html(data.errors.fecha_inicio[0]);
                  }

                  if (data.errors.fecha_fin) {
                     $('#fecha_fin-error').removeClass('d-none');
                     $('#fecha_fin').addClass('is-invalid');
                     $('#fecha_fin-error').html(data.errors.fecha_fin[0]);
                  }

                  if (data.errors.recibido_por) {
                     $('#recibido_por-error').removeClass('d-none');
                     $('#recibido_por').addClass('is-invalid');
                     $('#recibido_por-error').html(data.errors.recibido_por[0]);
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

                  }
               }

               if (data.success) {

                  Swal.fire({
                     text: "¿Desea imprimir la entrega de materiales?",
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

                        descargarPDF = route('impresion.salidas') + '?salida_id=' + data.success,
                           window.open(descargarPDF);

                        var loc = window.location;
                        window.location = loc.protocol + "/salidas";
                     } else {
                        // toastr["success"]("Registro agregado correctamente.");
                        var loc = window.location;
                        window.location = loc.protocol + "/salidas";

                     }

                  });

               }

            }
         })


      });
   }



   init();
})