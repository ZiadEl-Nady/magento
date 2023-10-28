define([
    'jquery',
    'mage/validation',
    'mage/url',
    'Magento_Customer/js/customer-data',
    'Magento_Config/js/system/config'
], function ($, validation, url, customerData, config) {
    'use strict';

    return function (config, element) {
        function validateWebsite(value) {
            var regex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;
            return regex.test(value);
        }

        function handleSuccess(response) {

            var customerDataObject = customerData.get('customer');
            customerDataObject.reload(['customer'], true);
        }

        $(element).on('input', function () {
            var enableValidation = config.getConfig('checkout/custom_section/enable_custom_field_validation');
            if (enableValidation === '1') {
                var value = $(this).val();
                var isValid = validateWebsite(value);

                if (isValid) {
                    $(this).removeClass('validation-failed');
                    $(this).addClass('validation-passed');
                } else {
                    $(this).removeClass('validation-passed');
                    $(this).addClass('validation-failed');
                }
            }
        });

        function updateCustomerWebsite(websiteValue) {
            var customerDataObject = customerData.get('customer');
            var customerId = customerDataObject().customer_id;

            $.ajax({
                url: url.build('custommodule/customcheckout/updatewebsite'),
                type: 'POST',
                data: {
                    customer_id: customerId,
                    website: websiteValue
                },
                success: handleSuccess,
                error: function () {

                }
            });
        }

        $(element).on('blur', function () {
            var websiteValue = $(this).val();
            updateCustomerWebsite(websiteValue);
        });
    };
});
