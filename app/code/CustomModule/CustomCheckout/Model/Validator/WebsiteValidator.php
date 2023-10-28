<?php

namespace CustomModule\CustomCheckout\Model\Validator;

class WebsiteValidator
{
    /**
     * Validate the website URL.
     *
     * @param string $website
     * @return bool
     */
    public function validateWebsite($website)
    {
        return filter_var($website, FILTER_VALIDATE_URL) !== false;
    }
}
