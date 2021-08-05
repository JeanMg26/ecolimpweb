$(function () {

   function init() {

      $.fn.dataTable.ext.errMode = 'throw';
      var table = $('#tabla_proveedores').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [1, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('proveedores.data'),
            data: function (d) {
               d.nomproveedor_buscar = $('#nomproveedor_buscar').val();
               d.rutproveedor_buscar = $('#rutproveedor_buscar').val();
               d.nomcontacto_buscar = $('#nomcontacto_buscar').val();
               d.rutcontacto_buscar = $('#rutcontacto_buscar').val();
               d.estado_buscar = $('#estado_buscar').val();
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
               data: 'nombre',
               name: 'proveedores.nombre'
            },
            {
               data: 'nrodoc',
               name: 'proveedores.nrodoc'
            },
            {
               data: 'telefono',
               name: 'proveedores.telefono'
            },
            {
               data: 'nom_contacto',
               name: 'proveedores.nom_contacto'
            },
            {
               data: 'nrodoc_contacto',
               name: 'proveedores.nrodoc_contacto'
            },
            {
               data: 'cel_contacto',
               name: 'proveedores.cel_contacto'
            },

            {
               data: 'checkbox-estado',
               orderable: false,
               searchable: false
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
         fnDrawCallback: function () {
            $('.toggle-class').bootstrapToggle({
               on: '<i class="far fa-check"></i>',
               off: '<i class="far fa-times"></i>'
            });

            $('[data-toggle="tooltip"]').tooltip({
               container: 'table',
               trigger: 'hover'
            });
         }

      });

      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_proveedores thead tr th").css("pointer-events", "none");


      // *****************************************************************
      // ********************* BUSQUEDAS UNITARIAS ***********************
      // *****************************************************************
      $('#buscar').on('click', function () {

         var nomproveedor = $('#nomproveedor_buscar').val();
         var rutproveedor = $('#rutproveedor_buscar').val();
         var nomcontacto = $('#nomcontacto_buscar').val();
         var rutcontacto = $('#rutcontacto_buscar').val();
         var estproveedor = $('#estado_buscar').val();


         if (nomproveedor != '' || rutproveedor != '' || nomcontacto != '' || rutcontacto != '' || estproveedor != '') {
            if (nomproveedor != '') {
               $('#tabla_proveedores').DataTable().draw(true);
            }

            if (rutproveedor != '') {
               $('#tabla_proveedores').DataTable().draw(true);
            }

            if (nomcontacto != '') {
               $('#tabla_proveedores').DataTable().draw(true);
            }

            if (rutcontacto != '') {
               $('#tabla_proveedores').DataTable().draw(true);
            }

            if (estproveedor != '') {
               $('#tabla_proveedores').DataTable().draw(true);
            }
         } else {
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
         $('#nomproveedor_buscar').val('');
         $('#rutproveedor_buscar').val('');
         $('#nomcontacto_buscar').val('');
         $('#rutcontacto_buscar').val('');
         $('#estado_buscar').val('').trigger('change');
         $('#tabla_proveedores').DataTable().draw(true);
      });



      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on("click", ".toggle", function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find(".toggle-class").attr("id");
         var proveedor_id = $(this).find(".toggle-class").data("id");

         if ($("#" + toggle_id).prop("checked")) {
            Swal.fire({
               title: "¿Estas seguro?",
               text: "El registro será desactivado.",
               icon: "question",
               showCancelButton: true,
               confirmButtonText: "Si, Desactivar",
               cancelButtonText: "No, Cancelar",
               customClass: {
                  confirmButton: "btn btn-success btn-lg mr-3",
                  cancelButton: "btn btn-light btn-lg",
               },
               buttonsStyling: false,
            }).then((result) => {
               if (result.value) {
                  Swal.fire({
                     title: "Desactivado",
                     text: "El registro fue desactivado exitosamente",
                     icon: "success",
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: "btn btn-success btn-lg px-4",
                     },
                     buttonsStyling: false,
                  });

                  $("#" + toggle_id).bootstrapToggle("off");
                  var estado = "0";

                  $.ajax({
                     type: "GET",
                     dataType: "json",
                     url: route("cambiar.estadoproveedor"),
                     data: {
                        estado: estado,
                        proveedor_id: proveedor_id,
                     },
                     beforeSend: function () {
                        toastr.info("Estado actualizado correctamente");
                     },
                     success: function (data) {
                        console.log(data.success);
                     },
                  });
               }
            });
         } else {
            Swal.fire({
               title: "¿Estas seguro?",
               text: "El registro será activado.",
               icon: "question",
               showCancelButton: true,
               confirmButtonText: "Si, Activar",
               cancelButtonText: "No, Cancelar",
               customClass: {
                  confirmButton: "btn btn-success btn-lg mr-3",
                  cancelButton: "btn btn-light btn-lg",
               },
               buttonsStyling: false,
            }).then((result) => {
               if (result.value) {
                  Swal.fire({
                     title: "Activado",
                     text: "El registro fue activado exitosamente",
                     icon: "success",
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: "btn btn-success btn-lg px-4",
                     },
                     buttonsStyling: false,
                  });

                  $("#" + toggle_id).bootstrapToggle("on");
                  var estado = "1";

                  $.ajax({
                     type: "GET",
                     dataType: "json",
                     url: route("cambiar.estadoproveedor"),
                     data: {
                        estado: estado,
                        proveedor_id: proveedor_id,
                     },
                     beforeSend: function () {
                        toastr.info("Estado actualizado correctamente");
                     },
                     success: function (data) {
                        console.log(data.success);
                     },
                  });
               }
            });
         }
      });
      // ********************* /FIN - ACTUALIZAR REGISTRO *********************


      events();
      crud();
      filtrar_instalacion();

   }

   function events() {


      $("#estado_buscar").select2({
         width: "100%",
         placeholder: "TODOS",
         minimumResultsForSearch: -1,
         allowClear: true,
         language: "es",
      });



   }

   function crud() {
      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on('click', '.view', function () {
         var show_id = $(this).attr('id');

         $.ajax({
            url: "proveedores/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
               $('#lnom_proveedor').text(data.proveedor.nombre);
               // $('#lnom_fantasia').text(data.proveedor.nom_fantasia);
               $('#lnrodoc_proveedor').text(data.proveedor.nrodoc);

               $('#lregion').text(data.region.nombre + ' - ' + data.provincia.nombre + ' - ' + data.comuna.nombre);

               $('#ldir_proveedor').text(data.proveedor.direccion);
               $('#lemail_proveedor').text(data.proveedor.email);

               $('#lnom_contacto').text(data.proveedor.nom_contacto);
               $('#lemail_contacto').text(data.proveedor.email_contacto);

               // MOSTRAR ESTADO
               if (data.proveedor.estado == '1') {
                  $('#lest_proveedor').text('ACTIVO');
               } else {
                  $('#lest_proveedor').text('INACTIVO');
               }

               // MOSTRAR NOMBRE FANTASIA
               if (data.proveedor.nom_fantasia == '' || data.proveedor.nom_fantasia == null) {
                  $('#lnom_fantasia').text('---------------------------');
               } else {
                  $('#lnom_fantasia').text(data.proveedor.nom_fantasia);
               }

               // MOSTRAR CELULAR
               if (data.proveedor.telefono == '' || data.proveedor.telefono == null) {
                  $('#ltel_proveedor').text('---------------------------');
               } else {
                  $('#ltel_proveedor').text(data.proveedor.telefono);
               }

               if (data.proveedor.cel_contacto == '' || data.proveedor.cel_contacto == null) {
                  $('#lcel_contacto').text('---------------------------');
               } else {
                  $('#lcel_contacto').text(data.proveedor.cel_contacto);
               }

               if (data.proveedor.nrodoc_contacto == '' || data.proveedor.nrodoc_contacto == null) {
                  $('#lnrodoc_contacto').text('---------------------------');
               } else {
                  $('#lnrodoc_contacto').text(data.proveedor.nrodoc_contacto);
               }

               $('.modal-title').text('DETALLE DEL CENTRO DE COSTO');
               $('#showModal').modal('show');
            }
         });
      });


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
            url: "/proveedores/destroy/" + delete_id,
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
                  $("#tabla_proveedores").DataTable().ajax.reload();
               }, 400);
            },
         });
      });

   }

   function filtrar_instalacion() {

      var path = route('filtrar_proveedor');

      // *********** FILTRAR POR NOMBRE DEL PROVEEDOR ***************

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
            html = outerData[data]['nom_proveedor'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_proveedor'] === item);
            $('#nom_proveedor').val(outerData[data]['nom_proveedor']);
            return item;
         },
         minLength: 1,
         items: 10,

      });

      // *********** FILTRAR POR RUT DEL PROVEEDOR ***************

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
            html = outerData[data]['rut_proveedor'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_proveedor'] === item);
            $('#rutproveedor_buscar').val(outerData[data]['rut_proveedor']);
            return item;
         },
         minLength: 1,
         items: 10,
      });

      // *********** FILTRAR POR NOMBRE DEL CONTACTO ***************

      $('#nomcontacto_buscar').typeahead({
         source: function (proveedor, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: proveedor },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.nom_contacto;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_contacto'] === item);
            html = '';
            html = outerData[data]['nom_contacto'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_contacto'] === item);
            $('#nomcontacto_buscar').val(outerData[data]['nom_contacto']);
            return item;
         },
         minLength: 1,
         items: 10,
      });

      // *********** FILTRAR POR NOMBRE DEL CONTACTO ***************
      $('#rutcontacto_buscar').typeahead({
         source: function (proveedor, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: proveedor },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.rut_contacto;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_contacto'] === item);
            html = '';
            html = outerData[data]['rut_contacto'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_contacto'] === item);
            $('#rutcontacto_buscar').val(outerData[data]['rut_contacto']);
            return item;
         },
         minLength: 1,
         items: 10,
      });

   }



   init();




})