$(function () {

   function init() {


      events();
   }

   function events() {

      // ************** SUMA TOTALES ****************

      // ************** SUMA TOTALES ****************
      var sum_totales = 0;

      arrayTotal = new Array();
      $('.total').each(function () {
         arrayTotal.push($(this).val());
      });

      // ------------------------------------

      $.each(arrayTotal, function () {
         val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
         sum_totales += val;
      });

      $('#subTotalFinal').val(sum_totales).number(true, 2);
      $('#ivaFinal').val(sum_totales * 0.19).number(true, 2);
      $('#TotalFinal').val(sum_totales + (sum_totales * 0.19)).number(true, 2);


   }



   init();




})