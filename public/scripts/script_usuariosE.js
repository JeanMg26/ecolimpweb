$(function () {

   function init() {

      $('#form-usuario').on('submit', function () {

         $('#rol').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",

         }).on("change", function (e) {
            $(this).valid();
         });


         $('#est_usuario').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
         }).on("change", function (e) {
            $(this).valid();
         });

      });

      validations();
      alerts();
      events();

   }

   function validations() {

      const reglas = {
         'nom_usu': {
            required: true,
            minlength: 6,
            maxlength: 50,
         },
         'email_usu': {
            required: true,
            email: true,
         },
         'rol_usu': {
            required: true,
         },
         'oldpass_usu': {
            required: true,
            minlength: 6,
            maxlength: 20
         },
         'pass_usu': {
            required: true,
            minlength: 6,
            maxlength: 20
         },
         'repass_usu': {
            required: true,
            equalTo: '#password_usu'
         },
         'est_usu': {
            required: true,
         }
      };

      const mensajes = {
         'nom_usu': {
            required: 'Ingresar el nombre de usuario.',
            minlength: 'Ingresar como mínimo de 6 caracacteres',
            maxlength: 'Ingresar como máximo 50 caracacteres.'
         },
         'rol_usu': {
            required: 'Seleccionar un rol.',
         },
         'email_usu': {
            required: 'Ingresar un correo electronico.',
            email: 'Ingresar un correo electronico valido.',
         },
         'oldpass_usu': {
            required: 'Ingresar la contraseña actual.',
            minlength: 'Ingresar como mínimo de 6 caracacteres',
            maxlength: 'Ingresar como máximo 20 caracacteres.'
         },
         'pass_usu': {
            required: 'Ingresar la nueva contraseña actual.',
            minlength: 'Ingresar como mínimo de 6 caracacteres',
            maxlength: 'Ingresar como máximo 20 caracacteres.'
         },
         'repass_usu': {
            required: 'Repetir la nueva contraseña actual.',
            equalTo: 'Las contraseñas no coincicen.'
         },
         'est_usu': {
            required: 'Seleccionar un estado.',
         }
      };

      Ecolimp.validacionGeneral('form-usuario', reglas, mensajes);

   }

   function events() {

      $('#rol').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         language: "es",
      });

      $('#est_usuario').select2({
         width: '100%',
         placeholder: "SELECCIONAR...",
         allowClear: true,
         minimumResultsForSearch: -1,
         language: "es",
      });

      $('#toggle-pass').bootstrapToggle({
         on: '<i class="far fa-check"></i>',
         off: '<i class="far fa-times"></i>',
         onstyle: 'success',
         offstyle: 'danger',
      });

      // ***************************************************************************
      // *************** Toggles para cambiar a una contrasela nueva *******************
      // ***************************************************************************

      // Cargar campos de contraseña con nombres diferentes para poder validarlos
      $('#oldpassword_usu').attr('name', 'oldpassword_usu');
      $('#password_usu').attr('name', 'password_usu');
      $('#repassword_usu').attr('name', 'repassword_usu');

      // Toogle para activar y desactivar el cambio de contraseña, asi como lo errores a mostrar
      $('#toggle-pass').on('change', function () {

         var error_oldpass = $('#oldpassword_usu-error').text();
         var error_pass = $('#password_usu-error').text();
         var error_repass = $('#repassword_usu-error').text();

         if ($(this).prop('checked')) {
            // Remover el atributo readonly a los campos que lo tienen por defecto
            $('#oldpassword_usu').removeAttr('readonly');
            $('#oldpassword_usu-error').removeClass('d-none');
            $('#password_usu').removeAttr('readonly');
            $('#password_usu-error').removeClass('d-none');
            $('#repassword_usu').removeAttr('readonly');
            $('#repassword_usu-error').removeClass('d-none');
            // Cambiar nombre para validarlo
            $('#oldpassword_usu').attr('name', 'oldpass_usu');
            $('#password_usu').attr('name', 'pass_usu');
            $('#repassword_usu').attr('name', 'repass_usu');
            // Comprobar si existe el mensaje de error
            if (error_oldpass) {
               $('#oldpassword_usu').addClass('is-invalid');
            }
            if (error_pass) {
               $('#password_usu').addClass('is-invalid');
            }
            if (error_repass) {
               $('#repassword_usu').addClass('is-invalid');
            }

         } else {
            // Agregar el atributo readonly a los campos
            $('#oldpassword_usu').attr('readonly', true);
            $('#oldpassword_usu').attr('name', 'oldpassword_usu');
            $('#password_usu').attr('readonly', true);
            $('#password_usu').attr('name', 'password_usu');
            $('#repassword_usu').attr('readonly', true);
            $('#repassword_usu').attr('name', 'repassword_usu');
            // Ocultar errores
            $('#oldpassword_usu-error').addClass('d-none');
            $('#oldpassword_usu').removeClass('is-invalid');
            $('#password_usu-error').addClass('d-none');
            $('#password_usu').removeClass('is-invalid');
            $('#repassword_usu-error').addClass('d-none');
            $('#repassword_usu').removeClass('is-invalid');

         }
      });

   }

   function alerts() {

      // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************

      $('#nom_usuario').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().find('.alert').length) {
               $('#nom_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).next().next('#nom_usu-error').length) {
               $('#nom_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#email_usuario').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#email_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }

         }
      });

      $('#oldpassword_usu').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#oldpass_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }
         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#oldpass_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#pass_usu').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#pass_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }

         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#pass_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }
         }
      });

      $('#repass_usu').on('keyup', function () {
         if ($(this).val().length) {
            if ($(this).parent().parent().find('.alert').length) {
               $('#repass_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error');
            }

         } else {
            if ($(this).parent().parent().find('.alert').length) {
               $('#repass_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error');
            }

         }
      });

      $('#rol').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#rol_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }

         } else {
            if ($(this).parent().find('.alert').length) {
               $('#rol_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }

         }
      });

      $('#est_usuario').on('change', function () {
         if ($(this).val() == '') {
            if ($(this).parent().find('.alert').length) {
               $('#est_usu-error').removeClass('d-none');
               $(this).parent().addClass(' has-error-select2');
            }

         } else {
            if ($(this).parent().find('.alert').length) {
               $('#est_usu-error').addClass('d-none');
               $(this).parent().removeClass(' has-error-select2');
            }
         }
      });
   }


   init();



});