<?php
/**
* *
*  @author DCKAP Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*  @package Dckap_CustomFields
*/

namespace Dckap\CustomFields\Plugin\Quote;

use Magento\Quote\Model\QuoteRepository;

/**
* Class SaveToQuote
* @package Dckap\CustomFields\Plugin\Quote
*/
class SaveToQuote
{
   /**
    * @var QuoteRepository
    */
   protected $quoteRepository;

   /**
    * SaveToQuote constructor.
    * @param QuoteRepository $quoteRepository
    */
   public function __construct(
       QuoteRepository $quoteRepository
   ) {
       $this->quoteRepository = $quoteRepository;
   }

   /**
    * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
    * @param $cartId
    * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    */
   public function beforeSaveAddressInformation(
       \Magento\Checkout\Model\ShippingInformationManagement $subject,
       $cartId,
       \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
   ) {
       if(!$extAttributes = $addressInformation->getExtensionAttributes())
           return;

       $quote = $this->quoteRepository->getActive($cartId);

       $quote->setInputCustomShippingField($extAttributes->getInputCustomShippingField());
       $quote->setDateCustomShippingField($extAttributes->getDateCustomShippingField());
       $quote->setSelectCustomShippingField($extAttributes->getSelectCustomShippingField());
   }
}
