$(function () {

   function init() {

      // $.fn.dataTable.ext.errMode = 'throw';
      var table = $('#tabla_salidas').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [2, 'asc'],
            [6, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('salidas.data'),
            type: 'GET',
            data: function (d) {
               d.nomcc_buscar = $('#nomcc_buscar').val();
               d.rutcc_buscar = $('#rutcc_buscar').val();
               d.num_registro = $('#num_registro').val();
               d.fecInicial_buscar = $('#fecha_inicio').val();
               d.fecFinal_buscar = $('#fecha_fin').val();
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
               data: 'codSalida',
               name: 'codSalida'
            },
            {
               data: 'nomInstalacion',
               name: 'nomInstalacion'
            },
            {
               data: 'rutInstalacion',
               name: 'rutInstalacion'
            },
            {
               data: 'telInstalacion',
               name: 'telInstalacion'
            },
            {
               data: 'dirInstalacion',
               name: 'dirInstalacion'
            },
            {
               data: 'fecInicio',
               name: 'fecInicio'
            },
            {
               data: 'respEntrega',
               name: 'respEntrega'
            },
            {
               data: 'respRecibio',
               name: 'respRecibio'
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
      $("#tabla_salidas thead tr th").css("pointer-events", "none");


      $('#buscar').on('click', function () {

         var nomcc = $('#nomcc_buscar').val();
         var rutcc = $('#rutcc_buscar').val();
         var nroregistro = $('#num_registro').val();
         var fecha_inicial = $('#fecha_inicio').val();
         var fecha_final = $('#fecha_fin').val();

         if (nomcc != '' || rutcc != '' || nroregistro != '' || fecha_inicial != '' || fecha_final != '') {

            if (nomcc != '') {
               $('#tabla_salidas').DataTable().draw(true);
            }

            if (rutcc != '') {
               $('#tabla_salidas').DataTable().draw(true);
            }

            if (nroregistro != '') {
               $('#tabla_salidas').DataTable().draw(true);
            }

            if (fecha_inicial != '') {
               if (fecha_final != '') {
                  $('#tabla_salidas').DataTable().draw(true);
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
                  $('#tabla_salidas').DataTable().draw(true);
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
         $('#nomcc_buscar').val('');
         $('#rutcc_buscar').val('');
         $('#num_registro').val('');
         $('#fecha_inicio').val('');
         $('#fecha_fin').val('');
         $('#tabla_salidas').DataTable().draw(true);
      });



      events();
      eliminar_registro();
      buscar_instalacion();

   }

   function events() {

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
            url: "/salidas/destroy/" + delete_id,
            beforeSend: function () {
               $("#ok_button").text("Eliminando...");
               toastr["error"]("Registro eliminado correctamente");
            },
            success: function (data) {
               setTimeout(function () {
                  $("#confirmModal").modal("hide");
                  $("#tabla_salidas").DataTable().ajax.reload();
               }, 400);
            },
         });
      });
   }

   function buscar_instalacion() {

      var path = route('buscar_instalacion');
      let outerData = [];

      // ************* BUSQUEDA POR NOMBRE DE INSTALACION ***************
      $('#nomcc_buscar').typeahead({
         source: function (instalacion, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: instalacion },
               dataType: 'json',
               success: function (data) {
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
            html = '<span>' + outerData[data]['nom_instalacion'] + '</span>';
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['nom_instalacion'] === item);
            $('#nomcc_buscar').val(outerData[data]['nom_instalacion']);
            return item;
         },
         minLength: 1,
         items: 5,
      });

      // ************* BUSQUEDA POR RUT DE INSTALACION ***************
      $('#rutcc_buscar').typeahead({
         source: function (instalacion, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: instalacion },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.rut_instalacion;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_instalacion'] === item);
            html = '';
            html = '<span>' + outerData[data]['rut_instalacion'] + '</span>';
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['rut_instalacion'] === item);
            $('#rutcc_buscar').val(outerData[data]['rut_instalacion']);
            return item;
         },
         minLength: 1,
         items: 5,
      });
   }



   init();



});