<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\GiftProduct\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session;

/**
 * Customer edit form block
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class MembershipRenewals extends Template
{

    const XML_GIFTDATE_CONFIG = 'gift_section/gift_group/';
    const XML_GIFTCATEGORY_CONFIG = 'gift_section/gift_group/';

     /**
     * @var Session
     */
    protected $_session;
    /**
     * @var
     */
    protected $request_interface;

    protected $customer; 


    /**
     * MembershipRenewals constructor.
     * @param \SkyPremium\MembershipRenewals\Helper\Data $helper
     * @param Context $context
     * @param array $data
     * @param Session $session
     */
    public function __construct(
        Context $context,
        array $data = [],
        Session $session,
        \Magento\Customer\Model\Customer $customer
    )
    {
        parent::__construct($context, $data);
        $this->_session = $session;
        $this->customer = $customer;
    }

    /**
     * @return mixed|string
     */
    public function getCustomerId()
    {
        $customer_id = '';
        $customer = $this->_session->getCustomer();
        if ($customer) {
            $customer_id = $customer->getId();
        }
        return $customer_id;
    }

    public function getLoadProduct()
    {
        $customer_id = $this->getCustomerId();
        return $this->customer->load($customer_id);
    }

    public function checkLogged()
    {
        if($this->_session->isLoggedIn()){
            return true;
        }else{
            return false;
        }
    }

    public function getGiftDateOfCUstomer()
    {
        $days = $this->_scopeConfig->getValue(
            self::XML_GIFTDATE_CONFIG . 'gift_date',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $days;
    }

    public function getGiftCategory()
    {
        $giftCategoryId = $this->_scopeConfig->getValue(
            self::XML_GIFTDATE_CONFIG . 'gift_category',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $giftCategoryId;
    }
}
