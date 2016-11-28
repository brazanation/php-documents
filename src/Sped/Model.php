<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\Sped\Exception\InvalidModel;

class Model
{
    const TYPE_NFE = 55;

    const TYPE_NFCE = 65;

    const TYPE_CTE = 57;

    const TYPE_CTE_OTHER = 67;

    const TYPE_MDFE = 58;

    private $model;

    private $allowed = [
        Model::TYPE_CTE,
        Model::TYPE_CTE_OTHER,
        Model::TYPE_MDFE,
        Model::TYPE_NFCE,
        Model::TYPE_NFE,
    ];

    /**
     * Model constructor.
     *
     * @param int $model
     */
    public function __construct($model)
    {
        $this->validate($model);
        $this->model = (int) $model;
    }

    private function validate($model)
    {
        if (!in_array($model, $this->allowed)) {
            throw InvalidModel::notAllowed($model);
        }
    }

    public static function NFe()
    {
        return new self(self::TYPE_NFE);
    }

    public static function NFCe()
    {
        return new self(self::TYPE_NFCE);
    }

    public static function CTe()
    {
        return new self(self::TYPE_CTE);
    }

    public static function CTeOther()
    {
        return new self(self::TYPE_CTE_OTHER);
    }

    public static function MDFe()
    {
        return new self(self::TYPE_MDFE);
    }

    public function equalsTo(Model $model)
    {
        return $this->model === $model->model;
    }

    public function __toString()
    {
        return "{$this->model}";
    }
}
