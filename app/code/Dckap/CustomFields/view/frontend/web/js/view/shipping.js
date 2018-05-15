/*
* *
*  @author DCKAP Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*  @package Dckap_CustomFields
*/
define(
   [
       'jquery',
       'underscore',
       'Magento_Ui/js/form/form',
       'ko',
       'Magento_Customer/js/model/customer',
       'Magento_Customer/js/model/address-list',
       'Magento_Checkout/js/model/address-converter',
       'Magento_Checkout/js/model/quote',
       'Magento_Checkout/js/action/create-shipping-address',
       'Magento_Checkout/js/action/select-shipping-address',
       'Magento_Checkout/js/model/shipping-rates-validator',
       'Magento_Checkout/js/model/shipping-address/form-popup-state',
       'Magento_Checkout/js/model/shipping-service',
       'Magento_Checkout/js/action/select-shipping-method',
       'Magento_Checkout/js/model/shipping-rate-registry',
       'Magento_Checkout/js/action/set-shipping-information',
       'Magento_Checkout/js/model/step-navigator',
       'Magento_Ui/js/modal/modal',
       'Magento_Checkout/js/model/checkout-data-resolver',
       'Magento_Checkout/js/checkout-data',
       'uiRegistry',
       'mage/translate',
       'Magento_Checkout/js/model/shipping-rate-service'
   ],function (
       $,
       _,
       Component,
       ko,
       customer,
       addressList,
       addressConverter,
       quote,
       createShippingAddress,
       selectShippingAddress,
       shippingRatesValidator,
       formPopUpState,
       shippingService,
       selectShippingMethodAction,
       rateRegistry,
       setShippingInformationAction,
       stepNavigator,
       modal,
       checkoutDataResolver,
       checkoutData,
       registry,
       $t
   ) {
   'use strict';

   var mixin = {

       initObservable: function () {
           this._super();

           this.selectedMethod = ko.computed(function() {
               var method = quote.shippingMethod();
               var selectedMethod = method != null ? method.carrier_code + '_' + method.method_code : null;
               return selectedMethod;
           }, this);

           return this;
       },

       /**
        * Set shipping information handler
        */
       setShippingInformation: function () {
           if (this.validateCustomFieldsShipping() && this.validateShippingInformation()) {
               setShippingInformationAction().done(
                   function () {
                       stepNavigator.next();
                   }
               );
           }
       },

       validateCustomFieldsShipping: function () {

           var shippingMethod = quote.shippingMethod().method_code+'_'+quote.shippingMethod().carrier_code;

           if (this.source.get('customShippingMethodFields') && shippingMethod == "freeshipping_freeshipping") {
               this.source.set('params.invalid', false);
               this.source.trigger('customShippingMethodFields.data.validate');
               if(this.source.get('params.invalid')) {
                   return false;
               }
           }
           return true;
       }
   };

   return function (target) {
       return target.extend(mixin);
   };
});
