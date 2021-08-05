$(function () {


   function init() {

      events();
      validations();
      alerts();

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



   init()

});