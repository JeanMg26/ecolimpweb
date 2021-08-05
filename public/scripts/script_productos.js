$(function () {

   function init() {

      // $.fn.dataTable.ext.errMode = 'throw';
      let table = $("#tabla_productos").DataTable({
         serverSide: true,
         pageLength: 10,
         processing: true,
         order: [
            [2, "asc"],
            [3, "asc"],
         ],
         dom:
            'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
         ajax: {
            url: route("productos.data"),
            type: 'GET',
            data: function (d) {
               d.nomproucto_buscar = $('#nomproducto_buscar').val();
               d.codproducto_buscar = $('#codproducto_buscar').val();
               d.categoria_buscar = $('#categoria_buscar').val();
               d.estado_buscar = $('#estado_buscar').val();
               d.stock_mayor = $('#stock_mayor').val();
               d.stock_menor = $('#stock_menor').val();
            }
         },
         columns: [
            {
               data: "DT_RowIndex",
               name: "DT_RowIndex",
               orderable: false,
               searchable: false,
            },
            {
               data: "imgProducto",
               orderable: false,
               searchable: false,
               render: function (data, type, row) {
                  if (row.imgProducto == "" || row.imgProducto == null) {
                     return '<img class="img-fluid" width="50px" src="img/product.png">';
                  } else {
                     return '<img class="img-fluid" width="50px" src="/uploads/' + data + '">';
                  }
               },
            },
            {
               data: "codProducto",
               name: "codProducto",
               orderable: false,
            },
            {
               data: "nomProducto",
               name: "nomProducto",
               orderable: false,
            },
            {
               data: "presProducto",
               name: "presProducto",
               orderable: false,
            },
            {
               data: "nomCategoria",
               name: "nomCategoria",
               orderable: false,
            },
            {
               data: "stock",
               name: "stock",
               orderable: false,
            },
            {
               data: "cantProducto",
               name: "cantProducto",
               orderable: false,
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


      $('#buscar').on('click', function () {

         var nomproducto = $('#nomproducto_buscar').val();
         var codproducto = $('#codproducto_buscar').val();
         var catproducto = $('#categoria_buscar').val();
         var estproducto = $('#estado_buscar').val();
         var stockmayor = $('#stock_mayor').val();
         var stockmenor = $('#stock_menor').val();

         if (nomproducto != '' || codproducto != '' || catproducto != '' || estproducto != '' || stockmayor != '' || stockmenor != '') {
            if (nomproducto != '') {
               $('#tabla_productos').DataTable().draw(true);
            }
            if (codproducto != '') {
               $('#tabla_productos').DataTable().draw(true);
            }

            if (catproducto != '') {
               $('#tabla_productos').DataTable().draw(true);
            }

            if (estproducto != '') {
               $('#tabla_productos').DataTable().draw(true);
            }

            if (stockmayor != '') {
               if (stockmenor != '') {
                  $('#tabla_productos').DataTable().draw(true);
               } else {
                  Swal.fire({
                     icon: 'warning',
                     text: 'Ingresar el stock mayor.',
                     confirmButtonText: "OK",
                     customClass: {
                        confirmButton: "btn btn-success btn-lg px-4",
                     },
                     buttonsStyling: false,
                  });
               }
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
         $('#nomproducto_buscar').val('');
         $('#codproducto_buscar').val('');
         $('#stock_mayor').val('');
         $('#stock_menor').val('');
         $('#categoria_buscar').val('').trigger('change');
         $('#estado_buscar').val('').trigger('change');
         $('#tabla_productos').DataTable().draw(true);
      });



      // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
      $("#tabla_productos thead tr th").css("pointer-events", "none");


      // ***************************************************************************
      // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

      table.on("click", ".toggle", function (e) {
         e.preventDefault();
         e.stopPropagation();

         var toggle_id = $(this).find(".toggle-class").attr("id");
         var producto_id = $(this).find(".toggle-class").data("id");

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
                     url: route("cambiar.estadoproducto"),
                     data: {
                        estado: estado,
                        producto_id: producto_id,
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
                     url: route("cambiar.estadoproducto"),
                     data: {
                        estado: estado,
                        producto_id: producto_id,
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
      crud_productos();
      filtrar_producto();
   }

   function events() {

      // ************** SELECT2 PARA PRODUCTOS ****************
      $("#categoria_buscar").select2({
         width: "100%",
         placeholder: "TODOS",
         minimumResultsForSearch: -1,
         allowClear: true,
         language: "es",
      });

      $("#estado_buscar").select2({
         width: "100%",
         placeholder: "TODOS",
         minimumResultsForSearch: -1,
         allowClear: true,
         language: "es",
      });


      // ****************** BORRRAR FILTROS **********************
      $("#btn-filtro").on("click", function () {
         $("#buscar_columna2").val("").keyup();
         $("#buscar_columna3").val("").keyup();
         $("#buscar_columna4").val("").keyup();
         $("#buscar_select5").val("").trigger("change");
      });

   }

   function crud_productos() {
      // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
      $(document).on('click', '.view', function () {
         var show_id = $(this).attr('id');

         $.ajax({
            url: "productos/" + show_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
               $('#lcod_pro').text(data.producto.codigo);
               $('#lnom_pro').text(data.producto.nombre);
               $('#ltipo_pro').text(data.categoria.nombre);
               $('#lpres_pro').text(data.producto.presentacion);

               // MOSTRAR ESTADO
               if (data.producto.estado == '1') {
                  $('#lest_pro').text('ACTIVO');
               } else {
                  $('#lest_pro').text('INACTIVO');
               }
               // MOSTRAR DESCRIPCION
               if (data.producto.descripcion == '') {
                  $('#ldes_pro').text('---------------------------');
               } else {
                  $('#ldes_pro').text(data.producto.descripcion);
               }
               // MOSTRAR IMAGEN
               if (data.producto.rutaimagen == '') {
                  $('#limagen_pro').attr('src', '/img/product.png');
               } else {
                  $('#limagen_pro').attr('src', '/uploads/' + data.producto.rutaimagen);
               }

               $('.modal-title').text('DETALLE DEL PRODUCTO');
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
            url: "/productos/destroy/" + delete_id,
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
                  $("#tabla_productos").DataTable().ajax.reload();
               }, 400);
            },
         });
      });

   }


   function filtrar_producto() {

      var path = route('filtrar_producto');

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
         updater: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['nom_producto'] === item);
            $('#nomproducto_buscar').val(outerData[data]['nom_producto']);
            return item;
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


   init();




});