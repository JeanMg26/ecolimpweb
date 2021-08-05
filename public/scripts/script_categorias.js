$(function () {

   function init() {

      $.fn.dataTable.ext.errMode = 'throw';
      let table = $('#tabla_categorias').DataTable({
         serverSide: true,
         processing: true,
         pageLength: 15,
         order: [[1, "asc"]],
         dom:
            'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route('categorias.data'),
         },
         columns: [
            {
               data: "DT_RowIndex",
               name: "DT_RowIndex",
               orderable: false,
               searchable: false,
            },
            {
               data: "nombre",
               name: "nombre",
            },
            {
               data: "checkbox-estado",
               orderable: false,
               searchable: false,
            },
            {
               data: "acciones",
               orderable: false,
               searchable: false,
            },
         ],

         language: {
            url: "js/datatables/datatable-es.json",
         },
         fnDrawCallback: function () {
            $(".toggle-class").bootstrapToggle({
               on: '<i class="far fa-check"></i>',
               off: '<i class="far fa-times"></i>',
            });

            $('[data-toggle="tooltip"]').tooltip({
               container: 'table',
               trigger: 'hover'
            });
         },
      });

      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_categorias thead tr th").css("pointer-events", "none");


      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on("click", ".toggle", function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find(".toggle-class").attr("id");
         var categoria_id = $(this).find(".toggle-class").data("id");

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
                     url: route("cambiar.estadocategoria"),
                     data: { 'estado': estado, 'categoria_id': categoria_id },
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
                  cancelButton: "btn btn-secondary btn-lg",
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
                     url: route("cambiar.estadocategoria"),
                     data: { 'estado': estado, 'categoria_id': categoria_id },
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
      alerts();

   }

   function events() {

      // ********** SELECT2 ************
      $("#est_categoria").select2({
         width: "100%",
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      // AUTOFOCUS PARA SELECT2 MODAL
      $("#modalCategoria").on("shown.bs.modal", function () {
         $("#nom_categoria").focus();
      });


   }


   function crud() {

      // LLAMANDO A MODAL PARA AGREGAR REGISTRO
      $('#crear_registro').on('click', function () {

         $('.modal-title').text('NUEVA CATEGORIA');
         $('.action_button').text('Guardar');
         $('.action_button').prepend('<i class="fas fa-save mr-2">');
         $('.action_button').removeClass('btn-light-blue');
         $('.action_button').addClass('btn-success');
         $('#action').val('Agregar');
         $('#nom_categoria-error').empty();
         $('#est_categoria-error').empty();
         $('#nom_categoria-error').addClass('d-none');
         $('#est_categoria-error').addClass('d-none');
         $('#nom_categoria').removeClass('is-invalid');
         $('#est_categoria').parent().removeClass(' has-error-select2');
         $('#nom_categoria').val('');
         $('#est_categoria').val("1").trigger("change");
         $('#est_categoria option:eq(2)').prop('disabled', true);
         $('#modalCategoria').modal('show');
      });

      // VERIFICAR SI EXISTE ERRORES
      $('#form-categoria').on('submit', function (event) {
         event.preventDefault();
         var action_url = '';

         // Accione para agregar
         if ($('#action').val() == 'Agregar') {
            action_url = route('categorias.store');
         }

         // Accione para editar
         if ($('#action').val() == 'Editar') {
            action_url = route('categorias.update');
         }

         $.ajax({
            url: action_url,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {

               if (data.errors) {

                  if (data.errors.nom_categoria) {
                     $('#nom_categoria-error').removeClass('d-none');
                     $('#nom_categoria').addClass('is-invalid');
                     $('#nom_categoria-error').html(data.errors.nom_categoria[0]);
                  }

                  if (data.errors.est_categoria) {
                     $('#est_categoria-error').removeClass('d-none');
                     $('#est_categoria').parent().addClass(' has-error-select2');
                     $('#est_categoria-error').html(data.errors.est_categoria[0]);
                  }
               }

               if (data.success) {
                  if ($('#action').val() == 'Editar') {
                     toastr['info']('Registro actualizado correctamente');
                     // Limpiar errores y campos
                     $('#form-categoria')[0].reset();
                     $('#nom_categoria-error').empty();
                     $('#est_categoria-error').empty();
                     $('#nom_categoria-error').addClass('d-none');
                     $('#est_categoria-error').addClass('d-none');
                     $('#nom_categoria').removeClass('is-invalid');
                     $('#est_categoria').parent().removeClass(' has-error-select2');
                     $('#nom_categoria').val('');
                     $('#est_categoria').val("1").trigger("change");
                     $('#tabla_categorias').DataTable().ajax.reload();
                     $('#modalCategoria').modal('hide');
                  } else {
                     toastr['success']('Registro agregado correctamente');
                     // Limpiar errores y campos
                     $('#form-categoria')[0].reset();
                     $('#nom_categoria-error').empty();
                     $('#est_categoria-error').empty();
                     $('#nom_categoria-error').addClass('d-none');
                     $('#est_categoria-error').addClass('d-none');
                     $('#nom_categoria').removeClass('is-invalid');
                     $('#est_categoria').parent().removeClass(' has-error-select2');
                     $('#nom_categoria').val('');
                     $('#est_categoria').val("1").trigger("change");
                     $('#tabla_categorias').DataTable().ajax.reload();
                     $('#nom_categoria').focus();
                  }
               }
            }
         })
      });

      // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
      $(document).on('click', '.edit', function () {
         var id = $(this).attr('id');
         $('#nom_categoria-error').empty();
         $('#est_categoria-error').empty();
         $('#nom_categoria-error').addClass('d-none');
         $('#est_categoria-error').addClass('d-none');
         $('#nom_categoria').removeClass('is-invalid');
         $('#est_categoria').parent().removeClass(' has-error-select2');
         $('#est_categoria option:eq(2)').attr('disabled', false);

         $.ajax({
            url: '/categorias/' + id + '/edit',
            dataType: 'json',
            success: function (data) {
               $('#nom_categoria').val(data.categoria.nombre);
               $('#est_categoria').val(data.categoria.estado).trigger('change');
               $('#categoria_id').val(id);
               $('.modal-title').text('ACTUALIZAR CATEGORIA');
               $('.action_button').text('Actualizar');
               $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
               $('.action_button').removeClass('btn-success');
               $('.action_button').addClass('btn btn-light-blue');
               $('#action').val('Editar');
               $('#modalCategoria').modal('show');
            }
         });

      });


      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on("click", ".view", function () {
         var show_id = $(this).attr("id");

         $.ajax({
            url: "categorias/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {

               $("#lnom_cat").text(data.categoria.nombre);
               if (data.categoria.estado == "1") {
                  $("#lest_cat").text("ACTIVO");
               } else {
                  $("#lest_cat").text("INACTIVO");
               }
               $(".modal-title").text("DETALLE DEL REGISTRO");
               $("#showModal").modal("show");
            },
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
            url: "/categorias/destroy/" + delete_id,
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
                  $("#tabla_categorias").DataTable().ajax.reload();
               }, 400);
            },
         });
      });

   }


   function alerts() {
      // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
      $("#nom_categoria").on("keyup", function () {
         if ($("#nom_categoria-error").text() != "") {
            if ($(this).val().length) {
               $("#nom_categoria-error").addClass("d-none");
               $("#nom_categoria").removeClass("is-invalid");
            } else {
               $("#nom_categoria-error").removeClass("d-none");
               $("#nom_categoria").addClass("is-invalid");
            }
         }
      });

      $("#mod_permiso").on("keyup", function () {
         if ($("#mod_permiso-error").text() != "") {
            if ($(this).val().length) {
               $("#mod_permiso-error").addClass("d-none");
               $("#mod_permiso").removeClass("is-invalid");
            } else {
               $("#mod_permiso-error").removeClass("d-none");
               $("#mod_permiso").addClass("is-invalid");
            }
         }
      });

      $("#est_categoria").on("change", function () {
         if ($("#est_categoria-error").text() != "") {
            if ($(this).val() == "") {
               $("#est_categoria-error").removeClass("d-none");
               $(this).parent().addClass(" has-error-select2");
            } else {
               $("#est_categoria-error").addClass("d-none");
               $(this).parent().removeClass(" has-error-select2");
            }
         }
      });
   }


   init();

});