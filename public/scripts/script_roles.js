$(function () {

   function init() {

      $.fn.dataTable.ext.errMode = 'throw';
      let table = $("#tabla_roles").DataTable({
         serverSide: true,
         pageLength: 15,
         processing: true,
         order: [[1, "asc"]],
         dom:
            'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route("roles.data"),
         },
         columns: [
            {
               data: "DT_RowIndex",
               name: "DT_RowIndex",
               orderable: false,
               searchable: false,
            },
            {
               data: "name",
               name: "name",
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

      // BUSQUEDA INDIVIDUAL POR COLUMNA
      $("#buscar_columna1").on("keyup", function () {
         table.columns(1).search(this.value).draw();
      });

      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_roles thead tr th").css("pointer-events", "none");


      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on("click", ".toggle", function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find(".toggle-class").attr("id");
         var rol_id = $(this).find(".toggle-class").data("id");

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
                     url: route("cambiar.estadorol"),
                     data: {
                        estado: estado,
                        rol_id: rol_id,
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
                     url: route("cambiar.estadorol"),
                     data: {
                        estado: estado,
                        rol_id: rol_id,
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
   }

   function events() {

      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on("click", ".view", function () {
         $("#permisito").empty();
         $(".modal-title").text("Detalle del Registro");
         var show_id = $(this).attr("id");

         $.ajax({
            url: "roles/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
               $("#lnom_rol").text(data.rol.name);

               // MOSTRANDO LOS PERMISOS ASIGANADOS
               var html = "";

               $.each(data.collection, function (key, permisos) {
                  html += '<div class="col-6 col-sm-4 col-lg-3">';
                  html += '<p class="font-weight-bold">' + key + "</p>";
                  html += '<ul class="list-unstyled">';


                  $.each(permisos, function (index, permiso) {

                     var cadena = permiso.name;
                     var final = cadena.split("-");
                     var nombre = final[1];

                     html += '<li class="mb-2"><i class="far fa-check mr-2"></i>' + nombre;
                     html += "</li>";

                  });
                  html += "</ul>";
                  html += "</div>";

               });

               // $("#permisos").append(html);
               $("#permisito").append(html);

               // ESTADO DEL ROL
               if (data.rol.status == "1") {
                  $("#lest_rol").text("ACTIVO");
               } else {
                  $("#lest_rol").text("INACTIVO");
               }
               $(".modal-title").text("DETALLES DEL REGISTRO");
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
            url: "/roles/destroy/" + delete_id,
            beforeSend: function () {
               $("#ok_button").text("Eliminando...");
            },
            success: function (data) {

               if (data.icono == 'warning') {
                  toastr.warning(data.mensaje);
               } else {
                  toastr.error(data.mensaje);
               }

               setTimeout(function () {
                  $("#confirmModal").modal("hide");
                  $("#tabla_roles").DataTable().ajax.reload();
               }, 400);
            },
         });
      });

   }


   init();


});