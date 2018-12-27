<?php

namespace Axlon\PostalCodeValidation;

use InvalidArgumentException;
use Sirprize\PostalCodeValidator\Validator as Library;

class Validator
{
    protected $library;

    public function __construct(Library $library)
    {
        $this->library = $library;
    }

    public function validate(string $attribute, string $value, array $countryCodes)
    {
        $countryCodes = array_map('strtoupper', $countryCodes);

        foreach ($countryCodes as $countryCode) {
            if (!$this->library->hasCountry($countryCode)) {
                throw new InvalidArgumentException("Unsupported country code $countryCode");
            }

            if ($this->library->isValid($countryCode, $value, true)) {
                return true;
            }
        }

        return false;
    }
}
