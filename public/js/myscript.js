$(function () {

   // ******* CORREGIR ERROR DE SIDEBAR - ACTIVE *************
   var url_origin = window.location.origin;
   var url_href = location.href;
   var separador = "/";
   var url_separada = url_href.split(separador);
   var union_url = url_origin + '/' + url_separada[3];

   $('ul.sidebar-nav a').filter(function () {
      return this.href == union_url;
   }).parent().addClass('activar').parent().addClass('show').parent().addClass('padre').find('a').first().addClass('activar');
   //   ******* FIN *************

   // *********** CARGAR Y MOSTRAR IMAGEN EN FORMULARIO ***********
   function LeerURL(input) {
      if (input.files && input.files[0]) {

         var image = input.files[0];
         var type = image.type;

         if (type == 'image/jpeg' || type == 'image/jpg' || type == 'image/png') {

            var reader = new FileReader();
            reader.onload = function (e) {
               $('#mi_img').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);

         } else {
            Swal.fire({
               title: "Error",
               text: "Archivo inválido.",
               type: "error",
               confirmButtonText: "OK",
               customClass: {
                  confirmButton: 'btn btn-success btn-lg px-4',
               },
               buttonsStyling: false
            });

            $('#miImagenInput').val('');
            return false;

         }
      }
      return false;
   }

   $('#miImagenInput').change(function () {
      LeerURL(this);
   });
   // *************************** FIN ***************************


   // *********** CARGAR Y MOSTRAR IMAGEN EN FORMULARIO USUARIO MODAL ***********
   function LeerURLModal(input) {
      if (input.files && input.files[0]) {

         var image = input.files[0];
         var type = image.type;

         if (type == 'image/jpeg' || type == 'image/jpg' || type == 'image/png') {

            var reader = new FileReader();
            reader.onload = function (e) {
               $('#mi_img_modal').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);

         } else {

            Swal.fire({
               title: "Error",
               text: "Archivo inválido.",
               type: "error",
               confirmButtonText: "OK",
               customClass: {
                  confirmButton: 'btn btn-success btn-lg px-4',
               },
               buttonsStyling: false
            });

            $('#miImagenInputModal').val('');
            return false;

         }
      }
      return false;
   }

   $('#miImagenInputModal').change(function () {
      LeerURLModal(this);
   });
   // *************************** FIN ***************************


   // *************** PERMITIR SOLO LETRAS Y NUMEROS *******************
   $(".alfanumerico").bind('keypress', function (event) {
      var regex = new RegExp("^[a-zA-Z0-9 -]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   $(".alfanumerico2").bind('keypress', function (event) {
      var regex = new RegExp("^[a-zA-Z0-9 -.#]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   $(".letras").bind('keypress', function (event) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   $(".numeros").bind('keypress', function (event) {
      var regex = new RegExp("^[0-9]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   $(".numeros2").bind('keypress', function (event) {
      var regex = new RegExp("^[0-9-.]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   $(".numeros3").bind('keypress', function (event) {
      var regex = new RegExp("^[0-9.]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
   });

   // ************** ACEPTAR N CANTIDAD DE DECIMALES ****************

   $('.decimal').on('keypress', function (e) {
      var character = String.fromCharCode(e.keyCode)
      var newValue = this.value + character;
      if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
         e.preventDefault();
         return false;
      }
   });

   function hasDecimalPlace(value, x) {
      var pointIndex = value.indexOf('.');
      return pointIndex >= 0 && pointIndex < value.length - x;
   }

   // ************** FIN ****************


   //PERMITIR SOLO LETRAS EN SELECT2
   $(document).on('keypress', '.select2-search__field', function () {
      $(this).val($(this).val().replace(/[^a-zA-Z0-9 _]/g, ''));
      if ((event.which < 48 || event.which > 57) && (event.which < 97 || event.which > 122)) {
         event.preventDefault();
      }
   });

   // ******************** Habilitar Tooltip Categoria *************************
   var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
   var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
   })

   function saltar() {

      // $(document).off('keydown ,select2:close', '.form-control,.select2-search__field')
      // $.extend($.expr[':'], {
      //    focusable: function (el, index, selector) {
      //       return $(el).is('a, button, :input, [tabindex]');
      //    }
      // });

      // $(document).on('keydown ,select2:close', '.form-control,.select2-search__field', function (e) {

      //    if (e.which == 13) {
      //       e.preventDefault();
      //       $.tabNext();
      //    }
      // });

   }

   saltar();



});


$(function () {

   function init() {

      events();
   }

   function events() {


   }

   init();





})