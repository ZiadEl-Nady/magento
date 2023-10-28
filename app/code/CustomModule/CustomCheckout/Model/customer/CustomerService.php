<?php

namespace CustomModule\CustomCheckout\Model\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerService
{
    private $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function setCustomWebsite($customerId, $website)
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
            $customer->setCustomAttribute('custom_website', $website);
            $this->customerRepository->save($customer);

            return true;
        } catch (\Exception $e) {
            return false; 
        }
    }
}
