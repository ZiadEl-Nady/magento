<?php

namespace CustomModule\CustomCheckout\Controller;

use CustomModule\CustomCheckout\Model\Customer\CustomerService;
use CustomModule\CustomCheckout\Model\Validator\WebsiteValidator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Controller\Result\JsonFactory;

class UpdateWebsite extends Action
{
    private $customerSession;
    private $jsonResultFactory;
    private $customerService;
    private $websiteValidator;

    public function __construct(
        Context $context,
        Session $customerSession,
        JsonFactory $jsonResultFactory,
        CustomerService $customerService,
        WebsiteValidator $websiteValidator
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->customerService = $customerService; // Initialize the service
    }

    public function execute()
    {
        $result = $this->jsonResultFactory->create();

        if ($this->customerSession->isLoggedIn()) {
            $customerId = $this->customerSession->getCustomerId();
            $website = $this->getRequest()->getParam('website');

            if ($this->websiteValidator->validateWebsite($website)) {
                $success = $this->customerService->setCustomWebsite($customerId, $website);

                if ($success) {
                    $result->setData(['success' => true]);
                } else {
                    $result->setData(['error' => 'Failed to save website']);
                }
            } else {
                $result->setData(['error' => 'Invalid website format']);
            }
        } else {
            $result->setData(['error' => 'Customer not logged in']);
        }

        return $result;
    }
}
