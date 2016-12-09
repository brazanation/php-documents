<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\Sped\Exception\InvalidEmissionType;

class EmissionType
{
    const NORMAL = 1;

    const CONTINGENCY_ON_SAFETY_FORM = 2;

    const CONTINGENCY_SCAN = 3;

    const CONTINGENCY_DPEC = 4;

    const CONTINGENCY_ON_SAFETY_FORM_FSDA = 5;

    const CONTINGENCY_SVCAN = 6;

    const CONTINGENCY_SVCRS = 7;

    private $type;

    private $allowed = [
        EmissionType::CONTINGENCY_DPEC,
        EmissionType::CONTINGENCY_ON_SAFETY_FORM,
        EmissionType::CONTINGENCY_ON_SAFETY_FORM_FSDA,
        EmissionType::CONTINGENCY_SCAN,
        EmissionType::CONTINGENCY_SVCAN,
        EmissionType::CONTINGENCY_SVCRS,
        EmissionType::NORMAL,
    ];

    /**
     * Model constructor.
     *
     * @param int $type
     */
    public function __construct($type)
    {
        $this->validate($type);
        $this->type = (int) $type;
    }

    private function validate($type)
    {
        if (!in_array($type, $this->allowed)) {
            throw InvalidEmissionType::notAllowed($type);
        }
    }

    public static function normal()
    {
        return new self(self::NORMAL);
    }

    public static function contingencyDpec()
    {
        return new self(self::CONTINGENCY_DPEC);
    }

    public static function contingencySVCRS()
    {
        return new self(self::CONTINGENCY_SVCRS);
    }

    public static function contingencySVCAN()
    {
        return new self(self::CONTINGENCY_SVCAN);
    }

    public static function contingencySCAN()
    {
        return new self(self::CONTINGENCY_SCAN);
    }

    public static function contingencyOnSafetyForm()
    {
        return new self(self::CONTINGENCY_ON_SAFETY_FORM);
    }

    public static function contingencyOnSafetyFormFSDA()
    {
        return new self(self::CONTINGENCY_ON_SAFETY_FORM_FSDA);
    }

    public function __toString()
    {
        return "{$this->type}";
    }
}
