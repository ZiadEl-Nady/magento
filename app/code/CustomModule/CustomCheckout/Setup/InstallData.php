<?php
declare(strict_types=1);

namespace CustomModule\CustomCheckout\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;

    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'custom_website',
            [
                'type' => 'text',
                'label' => 'Custom Website',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'position' => 100,
                'system' => false,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'custom_website');
        $attribute->setData('used_in_forms', ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']);
        $attribute->save();

        $setup->endSetup();
    }
}
