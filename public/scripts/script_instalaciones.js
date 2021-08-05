$(function () {

   function init() {

      $.fn.dataTable.ext.errMode = 'throw';
      var table = $('#tabla_instalaciones').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [1, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('instalaciones.data'),
            data: function (d) {
               d.nomcc_buscar = $('#nomcc_buscar').val();
               d.rutcc_buscar = $('#rutcc_buscar').val();
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
               name: 'instalaciones.nombre'
            },
            {
               data: 'nrodoc',
               name: 'instalaciones.nrodoc'
            },
            {
               data: 'telefono',
               name: 'instalaciones.telefono'
            },
            {
               data: 'nom_contacto',
               name: 'instalaciones.nom_contacto'
            },
            {
               data: 'nrodoc_contacto',
               name: 'instalaciones.nrodoc_contacto'
            },
            {
               data: 'cel_contacto',
               name: 'instalaciones.cel_contacto'
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
      $("#tabla_instalaciones thead tr th").css("pointer-events", "none");

      // ********************* BUSQUEDAS UNITARIAS ***********************
      $('#buscar').on('click', function () {

         var nomcc = $('#nomcc_buscar').val();
         var rutcc = $('#rutcc_buscar').val();
         var nomcontacto = $('#nomcontacto_buscar').val();
         var rutcontacto = $('#rutcontacto_buscar').val();
         var estinstalacion = $('#estado_buscar').val();


         if (nomcc != '' || rutcc != '' || nomcontacto != '' || rutcontacto != '' || estinstalacion != '') {
            if (nomcc != '') {
               $('#tabla_instalaciones').DataTable().draw(true);
            }

            if (rutcc != '') {
               $('#tabla_instalaciones').DataTable().draw(true);
            }

            if (nomcontacto != '') {
               $('#tabla_instalaciones').DataTable().draw(true);
            }

            if (rutcontacto != '') {
               $('#tabla_instalaciones').DataTable().draw(true);
            }

            if (estinstalacion != '') {
               $('#tabla_instalaciones').DataTable().draw(true);
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
         $('#nomcc_buscar').val('');
         $('#rutcc_buscar').val('');
         $('#nomcontacto_buscar').val('');
         $('#rutcontacto_buscar').val('');
         $('#estado_buscar').val('').trigger('change');
         $('#tabla_instalaciones').DataTable().draw(true);
      });



      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on("click", ".toggle", function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find(".toggle-class").attr("id");
         var instalacion_id = $(this).find(".toggle-class").data("id");

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
                     url: route("cambiar.estadoinstalacion"),
                     data: {
                        estado: estado,
                        instalacion_id: instalacion_id,
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
                     url: route("cambiar.estadoinstalacion"),
                     data: {
                        estado: estado,
                        instalacion_id: instalacion_id,
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

      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on('click', '.view', function () {
         var show_id = $(this).attr('id');

         $.ajax({
            url: "instalaciones/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
               $('#lnom_instalacion').text(data.instalacion.nombre);
               $('#lnrodoc_instalacion').text(data.instalacion.nrodoc);

               $('#lregion').text(data.region.nombre + ' - ' + data.provincia.nombre + ' - ' + data.comuna.nombre);

               $('#ldir_instalacion').text(data.instalacion.direccion);
               $('#lemail_instalacion').text(data.instalacion.email);

               $('#lnom_contacto').text(data.instalacion.nom_contacto);
               $('#lemail_contacto').text(data.instalacion.email_contacto);

               // MOSTRAR ESTADO
               if (data.instalacion.estado == '1') {
                  $('#lest_instalacion').text('ACTIVO');
               } else {
                  $('#lest_instalacion').text('INACTIVO');
               }
               // MOSTRAR DESCRIPCION
               if (data.instalacion.telefono == '' || data.instalacion.telefono == null) {
                  $('#ltel_instalacion').text('---------------------------');
               } else {
                  $('#ltel_instalacion').text(data.instalacion.telefono);
               }

               if (data.instalacion.cel_contacto == '' || data.instalacion.cel_contacto == null) {
                  $('#lcel_contacto').text('---------------------------');
               } else {
                  $('#lcel_contacto').text(data.instalacion.cel_contacto);
               }

               if (data.instalacion.nrodoc_contacto == '' || data.instalacion.nrodoc_contacto == null) {
                  $('#lnrodoc_contacto').text('---------------------------');
               } else {
                  $('#lnrodoc_contacto').text(data.instalacion.nrodoc_contacto);
               }

               $('.modal-title').text('DETALLE DEL CENTRO DE COSTO');
               $('#showModal').modal('show');
            }
         });
      });





      // ****************** BORRRAR FILTROS **********************
      $("#btn-filtro").on("click", function () {
         $("#buscar_columna1").val("").keyup();
         $("#buscar_columna2").val("").keyup();
         $("#buscar_columna3").val("").keyup();
         $("#buscar_columna4").val("").keyup();
      });


   }

   function crud() {
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
            url: "/instalaciones/destroy/" + delete_id,
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
                  $("#tabla_instalaciones").DataTable().ajax.reload();
               }, 400);
            },
         });
      });
   }


   function filtrar_instalacion() {

      var path = route('filtrar_instalacion');

      // *********** FILTRAR POR NOMBRE DE LA INSTALACION ***************

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
            html = outerData[data]['nom_instalacion'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_instalacion'] === item);
            $('#nom_instalacion').val(outerData[data]['nom_instalacion']);
            return item;
         },
         minLength: 1,
         items: 10,

      });

      // *********** FILTRAR POR RUT DE LA INSTALACION***************

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
            html = outerData[data]['rut_instalacion'];
            return html;
         },
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['rut_instalacion'] === item);
            $('#rutcc_buscar').val(outerData[data]['rut_instalacion']);
            return item;
         },
         minLength: 1,
         items: 10,
      });

      // *********** FILTRAR POR NOMBRE DEL CONTACTO ***************

      $('#nomcontacto_buscar').typeahead({
         source: function (instalacion, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: instalacion },
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
         source: function (instalacion, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: instalacion },
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