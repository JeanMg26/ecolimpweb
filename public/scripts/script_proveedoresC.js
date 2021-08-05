
$(function () {

   // ************* SELECT ANINADO PARA REGION - PROVINCIA **********************
   function cargarProvincias() {
      var region_id = $('#region').val();
      $.ajax({
         url: route('proveedor_provincias.data') + '?regionID=' + region_id,
         type: "GET",
         dataType: "json",
         beforeSend: function () {
            $('#provincia').select2({ placeholder: 'CARGANDO PROVINCIAS...' });
         },
         success: function (provincia) {
            var old = $('#provincia_id').val() != '' ? $('#provincia_id').val() : '';
            $('#provincia').empty();
            $('#provincia').select2({
               width: '100%',
               placeholder: "SELECCIONAR...",
               allowClear: true,
               language: "es",
            }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
            $.each(provincia, function (index, data) {
               $('#provincia').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.nombre) + "</option>";
            });
            cargarComunas();
         }
      })
   }
   cargarProvincias();
   $('#region').on('change', cargarProvincias);
   // ********************************* FIN **********************************

   // ************* SELECT ANINADO PARA PROVINCIA - COMUNA **********************
   function cargarComunas() {
      var provincia_id = $('#provincia').val();
      $.ajax({
         url: route('proveedor_comunas.data') + '?provinciaID=' + provincia_id,
         type: "GET",
         dataType: "json",
         beforeSend: function () {
            $('#comuna').select2({ placeholder: 'CARGANDO COMUNAS...' });
         },
         success: function (comuna) {
            var old = $('#comuna_id').val() != '' ? $('#comuna_id').val() : '';
            $('#comuna').empty();
            $('#comuna').select2({
               width: '100%',
               placeholder: "SELECCIONAR...",
               allowClear: true,
               language: "es",
            }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
            $.each(comuna, function (index, data) {
               $('#comuna').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.nombre + "</option>");
            });
         }
      });
   }
   cargarComunas();
   $('#provincia').on('change', function () {
      cargarComunas();
      var id_provincia = $(this).val();
      $('#provincia_id').val(id_provincia);
   });

   $('#comuna').on('change', function () {
      var id_comuna = $(this).val();
      $('#comuna_id').val(id_comuna);
   });
   // ********************************* FIN **********************************

   function init() {

      $('#form-proveedor').on('submit', function () {

         $('#est_proveedor').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

         $('#region').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            // minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

         $('#provincia').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            // minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

         $('#comuna').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            // minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

      });

      events();
      validations();
      alerts();
      nav_tabs();
   }

   function events() {

      // ******* Mask-Input *************
      $('#nrodoc_proveedor').mask('00.000.000-0');
      $('#nrodoc_contacto').mask('00.000.000-0');

      // SELECT2
      $('#est_proveedor').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      $('#region').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         // minimumResultsForSearch: -1,
         language: "es",
      });

      $('#provincia').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         // minimumResultsForSearch: -1,
         language: "es",
      });

      $('#comuna').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         // minimumResultsForSearch: -1,
         language: "es",
      });

   }

   function validations() {

      const reglas = {
         'nom_proveedor': {
            required: true,
            maxlength: 50,
         },
         'nom_fantasia': {
            maxlength: 50,
         },
         'nrodoc_proveedor': {
            required: true,
            minlength: 12,
            maxlength: 12,
         },
         'email_proveedor': {
            required: true,
            email: true,
         },
         'dir_proveedor': {
            required: true,
            maxlength: 50,
         },
         'cel_proveedor': {
            minlength: 9,
            maxlength: 9,
         },
         'est_proveedor': {
            required: true,
         },
         'region': {
            required: true,
         },
         'provincia': {
            required: true,
         },
         'comuna': {
            required: true,
         },
         'nom_contacto': {
            required: true,
            maxlength: 40,
         },
         'nrodoc_contacto': {
            required: true,
            minlength: 12,
            maxlength: 12,
         },
         'email_contacto': {
            required: true,
            email: true,
            maxlength: 50,
         },
         'cel_contacto': {
            minlength: 9,
            maxlength: 9,
         },

      };

      const mensajes = {

         'nom_proveedor': {
            required: 'Ingresar el nombre del proveedor.',
            maxlength: 'El nombre del centro de costo debe contener como máximo 50 caracteres.',
         },
         'nom_fantasia': {
            maxlength: 'El nombre del centro de costo debe contener como máximo 50 caracteres.',
         },
         'nrodoc_proveedor': {
            required: 'Ingresar el número de RUT.',
            minlength: 'El número de RUT debe contener como minimo 12 digitos.',
            maxlength: 'El número de RUT debe contener como máximo 12 digitos.',
         },
         'email_proveedor': {
            required: 'Ingresar una dirección de correo electrónico.',
            email: 'Ingresar una dirección de correo electrónico válida.',
            maxlength: 'La dirección de correo electrónico debe contener como máximo 50 caracteres.',
         },
         'dir_proveedor': {
            required: 'Ingresar una dirección válida.',
            maxlength: 'La dirección debe contener como máximo 50 caracteres.'
         },
         'cel_proveedor': {
            maxlength: 'El número de celular debe contener como máximo 9 digitos.',
            minlength: 'El número de celular debe contener al menos 9 digitos.'
         },
         'est_proveedor': {
            required: 'Selecciona un estado para el proveedor.'
         },

         'region': {
            required: 'Selecciona una región.'
         },
         'provincia': {
            required: 'Selecciona una provincia.'
         },
         'comuna': {
            required: 'Selecciona una comuna.'
         },

         'nom_contacto': {
            required: 'Ingresar el nombre de contacto.',
            maxlength: 'El nombre de contacto debe contener como máximo 40 caracteres.',
         },
         'nrodoc_contacto': {
            required: 'Ingresar el RUN del contacto.',
            minlength: 'El número de RUN debe contener como minimo 12 digitos.',
            maxlength: 'El número de RUN debe contener como máximo 12 digitos.',
         },
         'email_contacto': {
            required: 'Ingresar una dirección de correo electrónico.',
            email: 'Ingresar una dirección de correo electrónico válida.',
            maxlength: 'La dirección de correo electrónico debe contener como máximo 50 caracteres.',
         },
         'cel_contacto': {
            maxlength: 'El número de celular debe contener como máximo 9 digitos.',
            minlength: 'El número de celular debe contener al menos 9 digitos.'
         },


      };

      Ecolimp.validacionGeneral('form-proveedor', reglas, mensajes);

   }



   function alerts() {

      // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************


      $('#nom_proveedor').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#nom_fantasia').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_fantasia-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_fantasia-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#nrodoc_proveedor').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#email_proveedor').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });


      $('#dir_proveedor').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#dir_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#dir_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#cel_proveedor').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().find('.alert').length) {
               $('#cel_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#cel_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });


      $('#est_proveedor').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#est_proveedor-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#est_proveedor-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });

      $('#region').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#region-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#region-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });

      $('#provincia').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#provincia-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#provincia-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });

      $('#comuna').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#comuna-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#comuna-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });

      $('#nom_contacto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_contacto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_contacto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#nrodoc_contacto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_contacto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_contacto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#email_contacto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_contacto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_contacto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#cel_contacto').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_contacto-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_contacto-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

   }


   function nav_tabs() {

      // *************** Funciones con Tabs ******************
      $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
         if ($('#proveedor-tab').hasClass('active')) {
            $('#btn-action').attr('disabled', true);
            $('.next_tab').removeClass('d-none');
            $('.back_tab').addClass('d-none');
         } else {
            $('#btn-action').attr('disabled', false);
            $('.next_tab').addClass('d-none');
            $('.back_tab').removeClass('d-none');
         }
      });

      // *************** Funciones con Botones ******************
      var i, items = $('.tab-button'), pane = $('.tab-pane');

      //******************* Siguiente ********************/
      $('.next_tab').on('click', function () {

         $('.back_tab').removeClass('d-none');
         $('.next_tab').addClass('d-none');
         $('#btn-action').attr('disabled', false);

         // Econtramos el boton active
         for (i = 0; i < items.length; i++) {
            if ($(items[i]).hasClass('active') == true) {
               break;
            }
         }
         // Econtrado el boton activo, activamos el siguiente boton
         if (i < items.length - 1) {
            // Para los tab-button
            $(items[i]).removeClass('active');
            $(items[i + 1]).addClass('active');
            // Para los tab-pane
            $(pane[i]).removeClass('show active');
            $(pane[i + 1]).addClass('show active');
         }
      });

      //******************* Atras ********************/
      $('.back_tab').on('click', function () {

         $('.back_tab').addClass('d-none');
         $('.next_tab').removeClass('d-none');
         $('#btn-action').attr('disabled', true);

         // Econtramos el boton active
         for (i = 0; i < items.length; i++) {
            if ($(items[i]).hasClass('active') == true) {
               break;
            }
         }
         // Econtrado el boton activo, activamos el siguiente boton
         if (i != 0) {
            // Para los tab-button
            $(items[i]).removeClass('active');
            $(items[i - 1]).addClass('active');
            // Para los tab-pane
            $(pane[i]).removeClass('show active');
            $(pane[i - 1]).addClass('show active');
         }
      });

   }





   init();






})