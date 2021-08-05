$(function () {

   function init() {

      var table = $('#tabla_consultas').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [1, 'asc'],
            [4, 'asc'],
            // [5, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('consultas.data'),
            type: 'GET',
            data: function (d) {
               d.codproducto_buscar = $('#codproducto_buscar').val();
               d.nomproducto_buscar = $('#nomproducto_buscar').val();
               d.nomcc_buscar = $('#nomcc_buscar').val();
               d.rutcc_buscar = $('#rutcc_buscar').val();
               d.entregado_por = $('#entregado_por').val();
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
               data: 'codProducto',
               name: 'codProducto'
            },
            {
               data: 'nomProducto',
               name: 'nomProducto'
            },
            {
               data: 'presProducto',
               name: 'presProducto'
            },
            {
               data: 'canProducto',
               name: 'canProducto'
            },
            {
               data: 'nomCentroCosto',
               name: 'nomCentroCosto'
            },
            {
               data: 'rutCentroCosto',
               name: 'rutCentroCosto'
            },
            {
               data: 'fechaEntrega',
               name: 'fechaEntrega'
            },
            {
               data: 'repEntrega',
               name: 'repEntrega'
            },
            {
               data: 'resRecibo',
               name: 'resRecibo'
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
               targets: [7],
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
      $("#tabla_consultas thead tr th").css("pointer-events", "none");



      $('#buscar').on('click', function () {

         var codproducto = $('#codproducto_buscar').val();
         var nomproducto = $('#nomproducto_buscar').val();
         var nomcc = $('#nomcc_buscar').val();
         var rutcc = $('#rutcc_buscar').val();
         var responsable = $('#entregado_por').val();
         var fecha_inicial = $('#fecha_inicio').val();
         var fecha_final = $('#fecha_fin').val();

         if (nomproducto != '' || codproducto != '' || nomcc != '' || rutcc != '' || responsable != '' || fecha_inicial != '' || fecha_final != '') {

            if (nomproducto != '') {
               $('#tabla_consultas').DataTable().draw(true);
            }

            if (codproducto != '') {
               $('#tabla_consultas').DataTable().draw(true);
            }

            if (nomcc != '') {
               $('#tabla_consultas').DataTable().draw(true);
            }

            if (rutcc != '') {
               $('#tabla_consultas').DataTable().draw(true);
            }

            if (responsable != '') {
               $('#tabla_consultas').DataTable().draw(true);
            }

            if (fecha_inicial != '') {
               if (fecha_final != '') {
                  $('#tabla_consultas').DataTable().draw(true);
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
                  $('#tabla_consultas').DataTable().draw(true);
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
         $('#codproducto_buscar').val('');
         $('#nomproducto_buscar').val('');
         $('#nomcc_buscar').val('');
         $('#rutcc_buscar').val('');
         $('#entregado_por').val('').trigger('change');
         $('#fecha_inicio').val('');
         $('#fecha_fin').val('');
         $('#tabla_consultas').DataTable().draw(true);
      });



      events();
      buscar_producto();
      buscar_instalacion();
   }

   function events() {

      $("#entregado_por").select2({
         width: "100%",
         placeholder: "TODOS",
         minimumResultsForSearch: -1,
         allowClear: true,
         language: "es",
      });

      // ********************  DATEPICKER *********************
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

      var path = route('buscar_producto.consulta');

      // *********** FILTRAR POR NOMBRE DEL PRODUCTO ***************

      $('#nomproducto_buscar').typeahead({
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
            html = outerData[data]['nom_producto'];
            return html;
         },
         minLength: 1,
         items: 5,

      });

      // *********** FILTRAR POR CODIGO DEL PRODUCTO ***************

      $('#codproducto_buscar').typeahead({
         source: function (producto, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: producto },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.cod_producto;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['cod_producto'] === item);
            html = '';
            html = outerData[data]['cod_producto'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['cod_producto'] === item);
            $('#codproducto_buscar').val(outerData[data]['cod_producto']);
            return item;
         },
         minLength: 1,
         items: 5,

      });
   }


   function buscar_instalacion() {

      var path = route('buscar_instalacion.consulta');
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
})