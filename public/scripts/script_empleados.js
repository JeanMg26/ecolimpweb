$(function () {

   function init() {

      $.fn.dataTable.ext.errMode = 'throw';
      var table = $('#tabla_empleados').DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [2, 'asc'],
         ],
         dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('empleados.data'),
         },
         columns: [
            {
               data: 'DT_RowIndex',
               name: 'DT_RowIndex',
               orderable: false,
               searchable: false
            },
            {
               data: 'rutaimagen',
               className: 'text-center',
               orderable: false,
               searchable: false,
               render: function (data, type, row) {
                  if (row.rutaimagen == '' || row.rutaimagen == null) {
                     return '<img class="img-fluid" width="50px" src="img/user.jpg">';
                  } else
                     return '<img class="img-fluid" width="50px" src="/uploads/' + data + '">';
               }
            },
            {
               data: 'completos',
               name: 'completos'
            },
            {
               data: 'celular',
               name: 'celular'
            },
            {
               data: 'rol',
               name: 'roles.name',
               render: function (data, type, row) {
                  return ('<span class="badge bg-primary">' + row.rol + '</span>');
               }
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

      // BUSQUEDA INDIVIDUAL POR COLUMNA
      $('#buscar_columna2').on('keyup', function () {
         table.columns(2).search(this.value).draw();
      });

      $('#buscar_columna3').on('keyup', function () {
         table.columns(3).search(this.value).draw();
      });

      $("#buscar_select4").change(function () {
         table.columns(4).search(this.value).draw();
      });

      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_empleados thead tr th").css("pointer-events", "none");

      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on('click', '.toggle', function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find('.toggle-class').attr('id');
         var empleado_id = $(this).find('.toggle-class').data('id');

         if ($('#' + toggle_id).prop("checked")) {

            Swal.fire({
               title: "¿Estas seguro?",
               text: "El registro será desactivado.",
               icon: "question",
               showCancelButton: true,
               confirmButtonText: "Si, Desactivar",
               cancelButtonText: "No, Cancelar",
               customClass: {
                  confirmButton: 'btn btn-success btn-lg mr-3',
                  cancelButton: 'btn btn-secondary btn-lg'
               },
               buttonsStyling: false
            }).then((result) => {
               if (result.value) {
                  Swal.fire({
                     title: "Desactivado",
                     text: "El registro fue desactivado exitosamente",
                     icon: "success",
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: 'btn btn-success btn-lg px-4',
                     },
                     buttonsStyling: false
                  });

                  $('#' + toggle_id).bootstrapToggle('off');
                  var estado = '0';

                  $.ajax({
                     type: "GET",
                     dataType: "json",
                     url: route('cambiar.estadoempleado'),
                     data: { 'estado': estado, 'empleado_id': empleado_id },
                     beforeSend: function () {
                        toastr.info('Estado actualizado correctamente');
                     },
                     success: function (data) {
                        console.log(data.success);
                     }
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
                  confirmButton: 'btn btn-success btn-lg mr-3',
                  cancelButton: 'btn btn-secondary btn-lg'
               },
               buttonsStyling: false
            }).then((result) => {
               if (result.value) {
                  Swal.fire({
                     title: "Activado",
                     text: "El registro fue activado exitosamente",
                     icon: "success",
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: 'btn btn-success btn-lg px-4',
                     },
                     buttonsStyling: false
                  });

                  $('#' + toggle_id).bootstrapToggle('on');
                  var estado = '1';

                  $.ajax({
                     type: "GET",
                     dataType: "json",
                     url: route('cambiar.estadoempleado'),
                     data: { 'estado': estado, 'empleado_id': empleado_id },
                     beforeSend: function () {
                        toastr.info('Estado actualizado correctamente');
                     },
                     success: function (data) {
                        console.log(data.success);
                     }
                  });
               }
            });
         }
      });

      // ********************* /FIN - ACTUALIZAR REGISTRO *********************


      events();
      acciones();
   }


   function events() {


      $("#buscar_select4").select2({
         width: "100%",
         placeholder: "SELECCIONAR ROL",
         allowClear: true,
         // minimumResultsForSearch: -1,
         language: "es",
         dropdownParent: $("#parent"),
      });

      // ****************** BORRRAR FILTROS **********************
      $("#btn-filtro").on("click", function () {
         $("#buscar_columna2").val("").keyup();
         $("#buscar_columna3").val("").keyup();
         $("#buscar_select4").val("").trigger("change");
      });


   }


   function acciones() {

      // ************* ELIMINAR MODAL DESDE AJAX *************
      var delete_id;
      $(document).on('click', '.delete', function () {
         delete_id = $(this).attr('id');
         $('#confirmModal').modal('show');
         $('.modal-title').text('ELIMINAR REGISTRO');
         $('#ok_button').text('Si, Eliminar');

      });

      $('#ok_button').on('click', function () {
         $.ajax({
            url: '/empleados/destroy/' + delete_id,
            beforeSend: function () {
               $('#ok_button').text('Eliminando...');
               toastr['error']('Registro eliminado correctamente');
            },
            success: function (data) {
               setTimeout(function () {
                  $('#confirmModal').modal('hide');
                  $('#tabla_empleados').DataTable().ajax.reload();
               }, 400);
            }
         })
      });


      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on('click', '.view', function () {
         var show_id = $(this).attr('id');

         $.ajax({
            url: "empleados/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
               $('#lcomp_emp').text(data.empleado.completos);
               $('#lemail_emp').text(data.empleado.email);
               if (data.empleado.genero == 'M') {
                  $('#lgen_emp').text('MASCULINO');
               } else {
                  $('#lgen_emp').text('FEMENINO');
               }
               var fec_nac = data.empleado.fec_nac;
               var ffec_nac = moment(fec_nac).format('DD-MM-YYYY');
               $('#lfec_nac').text(ffec_nac);

               $('#ltipodoc_emp').text(data.empleado.tipodoc);
               $('#lnrodoc_emp').text(data.empleado.nrodoc);
               $('#lcargo_emp').text(data.usuarioRol.name);
               $('#lnom_usu').text(data.username);
               $('#lpass_usu').text(data.clave);
               // MOSTRAR NUMERO DE CELULAR
               if (data.empleado.celular == '' || data.empleado.celular == null) {
                  $('#lcelu_emp').text('--------------');
               } else {
                  $('#lcelu_emp').text(data.empleado.celular);
               }
               // MOSTRAR ESTADO
               if (data.empleado.estado == '1') {
                  $('#lest_emp').text('ACTIVO');
               } else {
                  $('#lest_emp').text('INACTIVO');
               }
               // MOSTRAR IMAGEN
               if (data.empleado.rutaimagen == '') {
                  $('#limagen_emp').attr('src', '/img/user.jpg');
               } else {
                  $('#limagen_emp').attr('src', '/uploads/' + data.empleado.rutaimagen);
               }

               $('.modal-title').text('DETALLE DEL REGISTRO');
               $('#showModal').modal('show');
            }
         });
      });

   }

   init();




})