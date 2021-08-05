$(function () {

   function init() {

      // $.fn.dataTable.ext.errMode = 'throw';
      var table = $('#tabla_ingresos').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [2, 'asc'],
            [6, 'asc'],
            // [5, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('ingresos.data'),
            type: 'GET',
            data: function (d) {
               d.tipodoc_buscar = $('#tipodoc_buscar').val();
               d.nrodoc_buscar = $('#nrodoc_buscar').val();
               d.nomproveedor_buscar = $('#nomproveedor_buscar').val();
               d.rutproveedor_buscar = $('#rutproveedor_buscar').val();
               d.num_registro = $('#num_registro').val();
               d.fecInicial_buscar = $('#fec_inicial').val();
               d.fecFinal_buscar = $('#fec_final').val();
            }
         },
         columns: [
            {
               data: 'DT_RowIndex',
               name: 'DT_RowIndex',
               orderable: false,
               searchable: false
            },
            {
               data: 'codigo',
               name: 'codigo'
            },
            {
               data: 'proveedorN',
               name: 'proveedorN'
            },
            {
               data: 'proveedorRUT',
               name: 'proveedorRUT'
            },
            {
               data: 'tipodoc',
               name: 'tipodoc'
            },
            {
               data: 'nrodoc',
               name: 'nrodoc'
            },
            {
               data: 'fecha_emision',
               name: 'fecha_emision'
            },
            {
               data: 'sumTotal',
               name: 'sumTotal',
               render: $.fn.dataTable.render.number(',', '.', 2) // formateador numerico propio del datatable
            },

            {
               data: 'acciones',
               orderable: false,
               searchable: false
            },
         ],
         language: {
            url: 'js/datatables/datatable-es.json',
         },
         columnDefs: [
            {
               targets: [6],
               render: function (data) {
                  return moment(data).format('DD/MM/YYYY');
               }
            },
         ],
         fnDrawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip({
               container: 'table',
               trigger: 'hover'
            });
         }

      });

      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_ingresos thead tr th").css("pointer-events", "none");


      // **************** BUSQUEDAS CON DATATABLES **************

      $('#buscar').on('click', function () {

         var tipodoc = $('#tipodoc_buscar').val();
         var nomproveedor = $('#nomproveedor_buscar').val();
         var rutproveedor = $('#rutproveedor_buscar').val();
         var nrodoc = $('#nrodoc_buscar').val();
         var nroregistro = $('#num_registro').val();
         var fecha_inicial = $('#fec_inicial').val();
         var fecha_final = $('#fec_final').val();

         if (nomproveedor != '' || rutproveedor != '' || tipodoc != '' || nrodoc != '' || nroregistro != '' || fecha_inicial != '' || fecha_final != '') {

            if (nomproveedor != '') {
               $('#tabla_ingresos').DataTable().draw(true);
            }

            if (rutproveedor != '') {
               $('#tabla_ingresos').DataTable().draw(true);
            }


            if (tipodoc != '') {
               $('#tabla_ingresos').DataTable().draw(true);
            }

            if (nrodoc != '') {
               $('#tabla_ingresos').DataTable().draw(true);
            }

            if (nroregistro != '') {
               $('#tabla_ingresos').DataTable().draw(true);
            }

            if (fecha_inicial != '') {
               if (fecha_final != '') {
                  $('#tabla_ingresos').DataTable().draw(true);
               } else {
                  Swal.fire({
                     icon: 'warning',
                     text: 'Ingresar la fecha final.',
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: "btn btn-success btn-lg px-4",
                     },
                     buttonsStyling: false,
                  });
               }
            }

            if (fecha_final != '') {
               if (fecha_inicial != '') {
                  $('#tabla_ingresos').DataTable().draw(true);
               } else {
                  Swal.fire({
                     icon: 'warning',
                     text: 'Ingresar la fecha inicial.',
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: "btn btn-success btn-lg px-4",
                     },
                     buttonsStyling: false,
                  });
               }
            }
         }
         else {
            Swal.fire({
               icon: 'warning',
               text: 'Ingresar datos para la búsqueda.',
               confirmButtonText: "OK",
               customClass: {
                  confirmButton: "btn btn-success btn-lg px-4",
               },
               buttonsStyling: false,
            });
         }




      });

      $('#reiniciar').on('click', function () {
         $('#tipodoc_buscar').val('0').trigger('change');
         $('#nomproveedor_buscar').val('');
         $('#rutproveedor_buscar').val('');
         $('#nrodoc_buscar').val('');
         $('#num_registro').val('');
         $('#fec_inicial').val('');
         $('#fec_final').val('');
         $('#tabla_ingresos').DataTable().draw(true);
      });

      events();
      buscar_proveedor();
      eliminar_registro();
   }

   function events() {

      $('#tipodoc_buscar').select2({
         width: '100%',
         placeholder: "TODOS",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      // ********** DATEPICKER PARA FILTRAR POR FECHAS *******************/

      var getDate = function (input) {
         return new Date(input.date.valueOf());
      }

      $('#fec_inicial').datepicker({
         'format': 'dd-mm-yyyy',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'orientation': 'bottom auto',
      }).on('changeDate',
         function (selected) {
            $('#fec_final').datepicker('clearDates');
            $('#fec_final').datepicker('setStartDate', getDate(selected));
         });

      $('#fec_final').datepicker({
         'format': 'dd-mm-yyyy',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'orientation': 'bottom auto'
      });


   }

   function buscar_proveedor() {

      var path = route('buscar_proveedor');
      let outerData = [];

      // ************* BUSQUEDA POR NOMBRE DE PROVEEDOR ***************
      $('#nomproveedor_buscar').typeahead({
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
            html = '<span>' + outerData[data]['nom_proveedor'] + '</span>';
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['nom_proveedor'] === item);
            $('#nomproveedor_buscar').val(outerData[data]['nom_proveedor']);
            return item;
         },
         minLength: 1,
         items: 5,
      });

      // ************* BUSQUEDA POR RUT DE PROVEEDOR ***************
      $('#rutproveedor_buscar').typeahead({
         source: function (proveedor, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: proveedor },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.rut_proveedor;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_proveedor'] === item);
            html = '';
            html = '<span>' + outerData[data]['rut_proveedor'] + '</span>';
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['rut_proveedor'] === item);
            $('#rutproveedor_buscar').val(outerData[data]['rut_proveedor']);
            return item;
         },
         minLength: 1,
         items: 5,
      });
   }

   function eliminar_registro() {
      // ************* ELIMINAR MODAL DESDE AJAX *************
      var delete_id;
      $(document).on("click", ".delete", function () {
         delete_id = $(this).attr("id");
         $("#confirmModal").modal("show");
         $(".modal-title").text("ELIMINAR REGISTRO");
         $("#ok_button").text("Si, Eliminar");
      });

      $("#ok_button").on("click", function () {
         $.ajax({
            url: "/ingresos/destroy/" + delete_id,
            beforeSend: function () {
               $("#ok_button").text("Eliminando...");
               // toastr["error"]("Registro eliminado correctamente");
            },
            success: function (data) {

               if (data.icono == 'warning') {
                  toastr.warning(data.mensaje);
               } else {
                  toastr.error(data.mensaje);
               }


               setTimeout(function () {
                  $("#confirmModal").modal("hide");
                  $("#tabla_ingresos").DataTable().ajax.reload();
               }, 400);
            },
         });
      });
   }



   init();






});