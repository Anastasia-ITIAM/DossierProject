<?php

namespace Symfony\Config\DoctrineMongodb\ConnectionConfig\AutoEncryption\EncryptedFieldsMapConfig\FieldsConfig;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class QueriesConfig 
{
    private $queryType;
    private $min;
    private $max;
    private $sparsity;
    private $precision;
    private $trimFactor;
    private $contention;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function queryType($value): static
    {
        $this->_usedProperties['queryType'] = true;
        $this->queryType = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     *
     * @return $this
     */
    public function min(mixed $value): static
    {
        $this->_usedProperties['min'] = true;
        $this->min = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     *
     * @return $this
     */
    public function max(mixed $value): static
    {
        $this->_usedProperties['max'] = true;
        $this->max = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function sparsity($value): static
    {
        $this->_usedProperties['sparsity'] = true;
        $this->sparsity = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function precision($value): static
    {
        $this->_usedProperties['precision'] = true;
        $this->precision = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function trimFactor($value): static
    {
        $this->_usedProperties['trimFactor'] = true;
        $this->trimFactor = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function contention($value): static
    {
        $this->_usedProperties['contention'] = true;
        $this->contention = $value;

        return $this;
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('queryType', $value)) {
            $this->_usedProperties['queryType'] = true;
            $this->queryType = $value['queryType'];
            unset($value['queryType']);
        }

        if (array_key_exists('min', $value)) {
            $this->_usedProperties['min'] = true;
            $this->min = $value['min'];
            unset($value['min']);
        }

        if (array_key_exists('max', $value)) {
            $this->_usedProperties['max'] = true;
            $this->max = $value['max'];
            unset($value['max']);
        }

        if (array_key_exists('sparsity', $value)) {
            $this->_usedProperties['sparsity'] = true;
            $this->sparsity = $value['sparsity'];
            unset($value['sparsity']);
        }

        if (array_key_exists('precision', $value)) {
            $this->_usedProperties['precision'] = true;
            $this->precision = $value['precision'];
            unset($value['precision']);
        }

        if (array_key_exists('trimFactor', $value)) {
            $this->_usedProperties['trimFactor'] = true;
            $this->trimFactor = $value['trimFactor'];
            unset($value['trimFactor']);
        }

        if (array_key_exists('contention', $value)) {
            $this->_usedProperties['contention'] = true;
            $this->contention = $value['contention'];
            unset($value['contention']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['queryType'])) {
            $output['queryType'] = $this->queryType;
        }
        if (isset($this->_usedProperties['min'])) {
            $output['min'] = $this->min;
        }
        if (isset($this->_usedProperties['max'])) {
            $output['max'] = $this->max;
        }
        if (isset($this->_usedProperties['sparsity'])) {
            $output['sparsity'] = $this->sparsity;
        }
        if (isset($this->_usedProperties['precision'])) {
            $output['precision'] = $this->precision;
        }
        if (isset($this->_usedProperties['trimFactor'])) {
            $output['trimFactor'] = $this->trimFactor;
        }
        if (isset($this->_usedProperties['contention'])) {
            $output['contention'] = $this->contention;
        }

        return $output;
    }

}
