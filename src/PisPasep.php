<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidArgument;

final class PisPasep implements DocumentInterface
{
    const LABEL = 'PisPasep';

    const REGEX = '/^([\d]{3})([\d]{5})([\d]{2})([\d]{1})$/';

    const FORMAT_REGEX = '/^[\d]{3}\.[\d]{5}\.[\d]{2}-[\d]{1}$/';

    /**
     * @var string
     */
    private $pispasep;

    protected $mask = '000.00000.00-0';

    /**
     * PisPasep constructor.
     *
     * @param $pispasep
     */
    public function __construct($pispasep)
    {
        $this->validate($pispasep);
        $this->pispasep = $pispasep;
    }

    private function validate($pispasep)
    {
        if (empty($pispasep)) {
            throw InvalidArgument::notEmpty(static::LABEL);
        }
        if (!$this->isValidCV($pispasep)) {
            throw InvalidArgument::isNotValidPispasep($pispasep);
        }
    }

    private function isValidCV($pispasep)
    {
        $c = preg_replace('/\D/', '', $pispasep);
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        return (new Modulo11(1, 9))->validate($pispasep);
    }

    /**
     * Formats PIS/PASEP number
     *
     * @return string Returns formatted number, such as: 00.00000.00-0
     */
    public function format()
    {
        return preg_replace(static::REGEX, '$1.$2.$3-$4', $this->pispasep);
    }

    public function __toString()
    {
        return (string) $this->pispasep;
    }
}
