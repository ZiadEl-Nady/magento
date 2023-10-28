define([
    'jquery',
    'mage/validation'
], function ($) {
    'use strict';

    $.validator.addMethod(
        'validate-website',
        function (value) {
            var regex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;
            return regex.test(value);
        },
        $.mage.__('Please enter a valid website URL.')
    );

    return $;
});
