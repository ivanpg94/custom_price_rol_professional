var iva = drupalSettings.custom_price_rol_professional.iva;
if(iva == 'no_iva') {
  function visibilidadiva() {
    head = document.head || document.getElementsByTagName('head')[0],
      style = document.createElement('style');

    head.appendChild(style);

    style.innerHTML = '.order-total-line__adjustment--tax{display:none!important;}';
  }
  visibilidadiva();
  console.log(visibilidadiva());
}
(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.customPriceRolProfessional = {
    attach: function (context, settings) {
      var intracomunitarioField = drupalSettings.custom_price_rol_professional.intracomunitario_field;

      if(intracomunitarioField === 'no') {
        $('.form-item-payment-information-billing-information-copy-fields-tax-number-0-value', context).css("display", "none");
      }
    }
  };
}(jQuery, Drupal, drupalSettings));
