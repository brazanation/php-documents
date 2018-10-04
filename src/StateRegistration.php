<?php

namespace Brazanation\Documents;

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
     * @var StateRegistration\StateInterface
     */
    private $state;

    /**
     * @var array
     */
    private static $availableStates = [
        StateRegistration\Acre::SHORT_NAME => StateRegistration\Acre::class,
        StateRegistration\Alagoas::SHORT_NAME => StateRegistration\Alagoas::class,
        StateRegistration\Amapa::SHORT_NAME => StateRegistration\Amapa::class,
        StateRegistration\Amazonas::SHORT_NAME => StateRegistration\Amazonas::class,
        StateRegistration\Bahia::SHORT_NAME => StateRegistration\Bahia::class,
        StateRegistration\Ceara::SHORT_NAME => StateRegistration\Ceara::class,
        StateRegistration\DistritoFederal::SHORT_NAME => StateRegistration\DistritoFederal::class,
        StateRegistration\EspiritoSanto::SHORT_NAME => StateRegistration\EspiritoSanto::class,
        StateRegistration\Goias::SHORT_NAME => StateRegistration\Goias::class,
        StateRegistration\Maranhao::SHORT_NAME => StateRegistration\Maranhao::class,
        StateRegistration\MatoGrosso::SHORT_NAME => StateRegistration\MatoGrosso::class,
        StateRegistration\MatoGrossoSul::SHORT_NAME => StateRegistration\MatoGrossoSul::class,
        StateRegistration\MinasGerais::SHORT_NAME => StateRegistration\MinasGerais::class,
        StateRegistration\Para::SHORT_NAME => StateRegistration\Para::class,
        StateRegistration\Paraiba::SHORT_NAME => StateRegistration\Paraiba::class,
        StateRegistration\Parana::SHORT_NAME => StateRegistration\Parana::class,
        StateRegistration\Pernambuco::SHORT_NAME => StateRegistration\Pernambuco::class,
        StateRegistration\Piaui::SHORT_NAME => StateRegistration\Piaui::class,
        StateRegistration\RioDeJaneiro::SHORT_NAME => StateRegistration\RioDeJaneiro::class,
        StateRegistration\RioGrandeDoNorte::SHORT_NAME => StateRegistration\RioGrandeDoNorte::class,
        StateRegistration\RioGrandeDoSul::SHORT_NAME => StateRegistration\RioGrandeDoSul::class,
        StateRegistration\Rondonia::SHORT_NAME => StateRegistration\Rondonia::class,
        StateRegistration\Roraima::SHORT_NAME => StateRegistration\Roraima::class,
        StateRegistration\SantaCatarina::SHORT_NAME => StateRegistration\SantaCatarina::class,
        StateRegistration\SaoPaulo::SHORT_NAME => StateRegistration\SaoPaulo::class,
        StateRegistration\Sergipe::SHORT_NAME => StateRegistration\Sergipe::class,
        StateRegistration\Tocantins::SHORT_NAME => StateRegistration\Tocantins::class,
    ];

    /**
     * StateRegistration constructor.
     *
     * @param string $number
     * @param StateRegistration\StateInterface $state
     */
    public function __construct(string $number, StateRegistration\StateInterface $state)
    {
        $number = $state->normalizeNumber($number);
        $this->state = $state;
        parent::__construct($number, $state->getLength(), $state->getNumberOfDigits(), $state->getState());
    }

    /**
     * Try to create a StateRegistration object from given number and state short name.
     *
     * @param string $number Document number to be parsed.
     * @param string $state State short name.
     *
     * @return AbstractDocument|boolean Returns a new Document instance or FALSE on failure.
     */
    public static function createFromString(string $number, string $state = '')
    {
        try {
            return static::$state($number);
        } catch (Exception\InvalidDocument $exception) {
            return false;
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return StateRegistration
     *
     * @throws \ReflectionException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $class = self::$availableStates[$name];
        $reflection = new \ReflectionClass($class);

        /** @var StateRegistration\StateInterface $state */
        $state = $reflection->newInstanceArgs();

        return new self($arguments[0], $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractBaseNumber(string $number) : string
    {
        return $this->state->extractBaseNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractCheckerDigit(string $number) : string
    {
        return $this->state->extractCheckerDigit($number);
    }

    /**
     * Voter does not has a specific format.
     *
     * @return string Returns only numbers.
     */
    public function format() : string
    {
        return preg_replace($this->state->getRegex(), $this->state->getFormat(), "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $digit = $this->state->calculateDigit($baseNumber);

        return "{$digit}";
    }
}
