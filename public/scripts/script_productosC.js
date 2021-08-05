$(function () {

   function init() {

      $('#form-producto').on('submit', function () {

         $('#categoria').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",

         }).on("change", function (e) {
            $(this).valid();
         });


         $('#est_producto').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

      });

      events();
      validations();
      categoria();
      alerts();
      alerts_categoria();

   }

   function events() {


      $('#categoria').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         language: "es",
      });

      $('#est_producto').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      // Desactivar option select
      $('#est_producto option:eq(2)').prop('disabled', true);

      // ******** ESTADO CATEGORIA *************
      $("#est_categoria").select2({
         width: "100%",
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      // ************ AUTOFOCUS MODAL *************
      $("#modalCategoria").on("shown.bs.modal", function () {
         $("#nom_categoria").focus();
      });

   }


   function categoria() {
      // LLAMANDO A MODAL PARA AGREGAR REGISTRO
      $('#crear_registro').on('click', function () {
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


      $('#nueva_cat').on('click', function () {

         var nom_categoria = $('#nom_categoria').val();
         var est_categoria = $('#est_categoria').val();

         $.ajax({
            type: "GET",
            dataType: "json",
            url: route("productos.nuevacategoria"),
            data: { 'nom_categoria': nom_categoria, 'est_categoria': est_categoria },
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

                  toastr['success']('Registro agregado correctamente');
                  // Limpiar errores y campos
                  $('#nom_categoria-error').empty();
                  $('#est_categoria-error').empty();
                  $('#nom_categoria-error').addClass('d-none');
                  $('#est_categoria-error').addClass('d-none');
                  $('#nom_categoria').removeClass('is-invalid');
                  $('#est_categoria').parent().removeClass(' has-error-select2');
                  $('#nom_categoria').val('');
                  $('#est_categoria').val("1").trigger("change");

                  // Cargar al Select2 la nueva categoria agregada
                  var newOption = new Option(data.nombre_cat, data.cat_id, false, false);
                  $('#categoria').append(newOption).trigger('change');

                  $('#nom_categoria').focus();
                  $('#modalCategoria').modal('hide');
               }

            },
         });
      });

   }


   function alerts_categoria() {
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


   function validations() {

      const reglas = {
         'categoria': {
            required: true,
         },
         'cod_producto': {
            required: true,
         },
         'nom_producto': {
            required: true,
         },
         'presen_producto': {
            required: true,
         },
         'cant_minima': {
            required: true,
         },
         'est_producto': {
            required: true,
         },
         // 'des_producto': {
         //    required: true,
         // }
      };

      const mensajes = {
         'categoria': {
            required: 'Ingresar la categoria del producto.',
         },
         'cod_producto': {
            required: 'Ingresar el codigo del producto.'
         },
         'nom_producto': {
            required: 'Ingresar el nombre del producto.',
         },
         'presen_producto': {
            required: 'Ingresar el nombre del producto.',
         },
         'cant_minima': {
            required: 'Ingresar el cantidad mínima del producto.',
         },
         'est_producto': {
            required: 'Seleccionar un estado.',
         },
         // 'des_producto': {
         //    required: 'Ingresar el nombre del producto..',
         // }
      };

      Ecolimp.validacionGeneral('form-producto', reglas, mensajes);

   }


   function alerts() {

      // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************

      $('#cod_producto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().find('.alert').length) {
               $('#cod_producto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).next().next('#cod_producto-error').length) {
               $('#cod_producto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#nom_producto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_producto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_producto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }

         }
      });

      $('#presen_producto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#presen_producto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }

         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#presen_producto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#categoria').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#categoria-error').removeClass('d-none');
               $(this).parent().addClass('has-error-select2');
            }

         } else {
            if ($(this).parent().find('.alert').length) {
               $('#categoria-error').addClass('d-none');
               $(this).parent().removeClass('has-error-select2');
            }

         }
      });

      $('#est_producto').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#est_producto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }

         } else {
            if ($(this).parent().find('.alert').length) {
               $('#est_producto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });
   }


   init();


});