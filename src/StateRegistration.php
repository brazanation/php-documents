<?php

namespace Brazanation\Documents;

use Brazanation\Documents\StateRegistration\Acre;
use Brazanation\Documents\StateRegistration\Alagoas;
use Brazanation\Documents\StateRegistration\Amapa;
use Brazanation\Documents\StateRegistration\Amazonas;
use Brazanation\Documents\StateRegistration\Bahia;
use Brazanation\Documents\StateRegistration\Ceara;
use Brazanation\Documents\StateRegistration\DistritoFederal;
use Brazanation\Documents\StateRegistration\EspiritoSanto;
use Brazanation\Documents\StateRegistration\Goias;
use Brazanation\Documents\StateRegistration\Maranhao;
use Brazanation\Documents\StateRegistration\MatoGrosso;
use Brazanation\Documents\StateRegistration\MatoGrossoSul;
use Brazanation\Documents\StateRegistration\MinasGerais;
use Brazanation\Documents\StateRegistration\Para;
use Brazanation\Documents\StateRegistration\Paraiba;
use Brazanation\Documents\StateRegistration\Parana;
use Brazanation\Documents\StateRegistration\Pernambuco;
use Brazanation\Documents\StateRegistration\Piaui;
use Brazanation\Documents\StateRegistration\RioDeJaneiro;
use Brazanation\Documents\StateRegistration\RioGrandeDoNorte;
use Brazanation\Documents\StateRegistration\RioGrandeDoSul;
use Brazanation\Documents\StateRegistration\Rondonia;
use Brazanation\Documents\StateRegistration\Roraima;
use Brazanation\Documents\StateRegistration\SantaCatarina;
use Brazanation\Documents\StateRegistration\SaoPaulo;
use Brazanation\Documents\StateRegistration\Sergipe;
use Brazanation\Documents\StateRegistration\StateInterface;
use Brazanation\Documents\StateRegistration\Tocantins;

/**
 * Class StateRegistration
 *
 * @package Brazanation\Documents
 *
 * @method static StateRegistration AC($number)
 * @method static StateRegistration AL($number)
 * @method static StateRegistration AM($number)
 * @method static StateRegistration AP($number)
 * @method static StateRegistration BA($number)
 * @method static StateRegistration CE($number)
 * @method static StateRegistration DF($number)
 * @method static StateRegistration ES($number)
 * @method static StateRegistration GO($number)
 * @method static StateRegistration MA($number)
 * @method static StateRegistration MG($number)
 * @method static StateRegistration MS($number)
 * @method static StateRegistration MT($number)
 * @method static StateRegistration PA($number)
 * @method static StateRegistration PB($number)
 * @method static StateRegistration PE($number)
 * @method static StateRegistration PI($number)
 * @method static StateRegistration PR($number)
 * @method static StateRegistration RJ($number)
 * @method static StateRegistration RN($number)
 * @method static StateRegistration RO($number)
 * @method static StateRegistration RR($number)
 * @method static StateRegistration RS($number)
 * @method static StateRegistration SC($number)
 * @method static StateRegistration SE($number)
 * @method static StateRegistration SP($number)
 * @method static StateRegistration TO($number)
 */
final class StateRegistration extends AbstractDocument
{
    /**
     * @var StateInterface
     */
    private $state;

    /**
     * @var array
     */
    private static $availableStates = [
        Acre::SHORT_NAME => Acre::class,
        Alagoas::SHORT_NAME => Alagoas::class,
        Amapa::SHORT_NAME => Amapa::class,
        Amazonas::SHORT_NAME => Amazonas::class,
        Bahia::SHORT_NAME => Bahia::class,
        Ceara::SHORT_NAME => Ceara::class,
        DistritoFederal::SHORT_NAME => DistritoFederal::class,
        EspiritoSanto::SHORT_NAME => EspiritoSanto::class,
        Goias::SHORT_NAME => Goias::class,
        Maranhao::SHORT_NAME => Maranhao::class,
        MatoGrosso::SHORT_NAME => MatoGrosso::class,
        MatoGrossoSul::SHORT_NAME => MatoGrossoSul::class,
        MinasGerais::SHORT_NAME => MinasGerais::class,
        Para::SHORT_NAME => Para::class,
        Paraiba::SHORT_NAME => Paraiba::class,
        Parana::SHORT_NAME => Parana::class,
        Pernambuco::SHORT_NAME => Pernambuco::class,
        Piaui::SHORT_NAME => Piaui::class,
        RioDeJaneiro::SHORT_NAME => RioDeJaneiro::class,
        RioGrandeDoNorte::SHORT_NAME => RioGrandeDoNorte::class,
        RioGrandeDoSul::SHORT_NAME => RioGrandeDoSul::class,
        Rondonia::SHORT_NAME => Rondonia::class,
        Roraima::SHORT_NAME => Roraima::class,
        SantaCatarina::SHORT_NAME => SantaCatarina::class,
        SaoPaulo::SHORT_NAME => SaoPaulo::class,
        Sergipe::SHORT_NAME => Sergipe::class,
        Tocantins::SHORT_NAME => Tocantins::class,
    ];

    /**
     * StateRegistration constructor.
     *
     * @param string         $number
     * @param StateInterface $state
     */
    public function __construct($number, StateInterface $state)
    {
        $number = $state->normalizeNumber($number);
        $this->state = $state;
        parent::__construct($number, $state->getLength(), $state->getNumberOfDigits(), $state->getState());
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return StateRegistration
     */
    public static function __callStatic($name, $arguments)
    {
        $class = self::$availableStates[$name];
        $reflection = new \ReflectionClass($class);

        /** @var StateInterface $state */
        $state = $reflection->newInstanceArgs();

        return new self($arguments[0], $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractBaseNumber($number)
    {
        return $this->state->extractBaseNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractCheckerDigit($number)
    {
        return $this->state->extractCheckerDigit($number);
    }

    /**
     * Voter does not has a specific format.
     *
     * @return string Returns only numbers.
     */
    public function format()
    {
        return preg_replace($this->state->getRegex(), $this->state->getFormat(), "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $digit = $this->state->calculateDigit($baseNumber);

        return "{$digit}";
    }
}
