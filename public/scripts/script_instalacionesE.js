$(function () {


   // ************* SELECT ANINADO PARA REGION - PROVINCIA **********************
   function cargarProvincias() {

      var region_id = $('#region').val();
      $.ajax({
         url: route('instalaciones_provincias.data') + '?regionID=' + region_id,
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
         url: route('instalaciones_comunas.data') + '?provinciaID=' + provincia_id,
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

      events();
      alerts();
      validations();
      nav_tabs();
   }

   function events() {

      // ******* Mask-Input *************
      $('#nrodoc_instalacion').mask('00.000.000-0');
      $('#nrodoc_contacto').mask('00.000.000-0');

      // ********** SELECT2 ************
      $("#est_instalacion").select2({
         width: "100%",
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

   }


   function validations() {

      const reglas = {
         'nom_instalacion': {
            required: true,
            maxlength: 50,
         },
         'nom_fantasia': {
            maxlength: 50,
         },
         'nrodoc_instalacion': {
            required: true,
            minlength: 12,
            maxlength: 12,
         },
         'email_instalacion': {
            required: true,
            email: true,
         },
         'dir_instalacion': {
            required: true,
            maxlength: 50,
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
         'tel_instalacion': {
            minlength: 9,
            maxlength: 9,
         },
         'est_instalacion': {
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

         'nom_instalacion': {
            required: 'Ingresar el nombre del centro de costo.',
            maxlength: 'El nombre del centro de costo debe contener como máximo 50 caracteres.',
         },
         'nom_fantasia': {
            maxlength: 'El nombre del centro de costo debe contener como máximo 50 caracteres.',
         },
         'nrodoc_instalacion': {
            required: 'Ingresar el número de RUT.',
            minlength: 'El número de RUT debe contener como minimo 12 digitos.',
            maxlength: 'El número de RUT debe contener como máximo 12 digitos.',
         },
         'email_instalacion': {
            required: 'Ingresar una dirección de correo electrónico.',
            email: 'Ingresar una dirección de correo electrónico válida.',
            maxlength: 'La dirección de correo electrónico debe contener como máximo 50 caracteres.',
         },
         'dir_instalacion': {
            required: 'Ingresar una dirección válida.',
            maxlength: 'La dirección debe contener como máximo 50 caracteres.'
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
         'tel_instalacion': {
            maxlength: 'El número del teléfono debe contener como máximo 9 digitos.',
            minlength: 'El número del teléfono debe contener al menos 9 digitos.'
         },
         'est_instalacion': {
            required: 'Selecciona un estado para el centro de costo.'
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

      Ecolimp.validacionGeneral('form-instalacion', reglas, mensajes);

   }

   function alerts() {

      // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************

      $('#nom_instalacion').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_instalacion-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nom_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#nrodoc_instalacion').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_instalacion-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#nrodoc_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#email_instalacion').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_instalacion-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });


      $('#dir_instalacion').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#dir_instalacion-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#dir_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });


      $('#tel_instalacion').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().find('.alert').length) {
               $('#tel_instalacion-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#tel_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#est_instalacion').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#est_instalacion-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }
         } else {
            if ($(this).parent().find('.alert').length) {
               $('#est_instalacion-error').addClass('d-none');
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
         if ($('#instalacion-tab').hasClass('active')) {
            // $('#btn-action').attr('disabled', true);
            $('.next_tab').removeClass('d-none');
            $('.back_tab').addClass('d-none');
         } else {
            // $('#btn-action').attr('disabled', false);
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
         // $('#btn-action').attr('disabled', false);

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
         // $('#btn-action').attr('disabled', true);

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