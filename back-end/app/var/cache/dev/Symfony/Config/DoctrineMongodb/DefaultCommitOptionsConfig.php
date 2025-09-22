<?php

namespace Symfony\Config\DoctrineMongodb;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class DefaultCommitOptionsConfig 
{
    private $j;
    private $timeout;
    private $w;
    private $wtimeout;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function j($value): static
    {
        $this->_usedProperties['j'] = true;
        $this->j = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function timeout($value): static
    {
        $this->_usedProperties['timeout'] = true;
        $this->timeout = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function w($value): static
    {
        $this->_usedProperties['w'] = true;
        $this->w = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function wtimeout($value): static
    {
        $this->_usedProperties['wtimeout'] = true;
        $this->wtimeout = $value;

        return $this;
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('j', $value)) {
            $this->_usedProperties['j'] = true;
            $this->j = $value['j'];
            unset($value['j']);
        }

        if (array_key_exists('timeout', $value)) {
            $this->_usedProperties['timeout'] = true;
            $this->timeout = $value['timeout'];
            unset($value['timeout']);
        }

        if (array_key_exists('w', $value)) {
            $this->_usedProperties['w'] = true;
            $this->w = $value['w'];
            unset($value['w']);
        }

        if (array_key_exists('wtimeout', $value)) {
            $this->_usedProperties['wtimeout'] = true;
            $this->wtimeout = $value['wtimeout'];
            unset($value['wtimeout']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['j'])) {
            $output['j'] = $this->j;
        }
        if (isset($this->_usedProperties['timeout'])) {
            $output['timeout'] = $this->timeout;
        }
        if (isset($this->_usedProperties['w'])) {
            $output['w'] = $this->w;
        }
        if (isset($this->_usedProperties['wtimeout'])) {
            $output['wtimeout'] = $this->wtimeout;
        }

        return $output;
    }

}
