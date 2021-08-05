$(function () {

   function init() {

      events();
      datos_proveedor();
      buscar_producto();
      totales_productos();
      enviar_datos();
      alerts();
      alertas_array();
   }

   function events() {

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
            html = '<strong>' + outerData[data]['nom_producto'] + '</strong>' + ' - ' + outerData[data]['pres_producto'];
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


   var tr = $('table tr').length;
   var i = tr - 1;

   function enviar_datos() {

      $('#form-ingreso').on('submit', function (event) {

         event.preventDefault();
         $.ajax({
            url: route('ingresos.update'),
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
                     text: "¿Desea imprimir la actualización del ingreso?",
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

   init();
})