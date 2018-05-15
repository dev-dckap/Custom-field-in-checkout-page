/*
* *
*  @author DCKAP Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*  @package Dckap_CustomFields
*/

var config = {
   config: {
       mixins: {
           'Magento_Checkout/js/view/shipping': {
               'Dckap_CustomFields/js/view/shipping': true
           }
       }
   },
   "map": {
       "*": {
           "Magento_Checkout/js/model/shipping-save-processor/default" : "Dckap_CustomFields/js/shipping-save-processor"
       }
   }
};
