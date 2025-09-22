<?php

namespace Symfony\Config\DoctrineMongodb\ConnectionConfig;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class OptionsConfig 
{
    private $authMechanism;
    private $connectTimeoutMS;
    private $db;
    private $authSource;
    private $journal;
    private $password;
    private $readPreference;
    private $readPreferenceTags;
    private $replicaSet;
    private $socketTimeoutMS;
    private $ssl;
    private $tls;
    private $tlsAllowInvalidCertificates;
    private $tlsAllowInvalidHostnames;
    private $tlsCAFile;
    private $tlsCertificateKeyFile;
    private $tlsCertificateKeyFilePassword;
    private $tlsDisableCertificateRevocationCheck;
    private $tlsDisableOCSPEndpointCheck;
    private $tlsInsecure;
    private $username;
    private $retryReads;
    private $retryWrites;
    private $w;
    private $wTimeoutMS;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|'SCRAM-SHA-1'|'SCRAM-SHA-256'|'MONGODB-CR'|'MONGODB-X509'|'PLAIN'|'GSSAPI' $value
     * @return $this
     */
    public function authMechanism($value): static
    {
        $this->_usedProperties['authMechanism'] = true;
        $this->authMechanism = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function connectTimeoutMS($value): static
    {
        $this->_usedProperties['connectTimeoutMS'] = true;
        $this->connectTimeoutMS = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function db($value): static
    {
        $this->_usedProperties['db'] = true;
        $this->db = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function authSource($value): static
    {
        $this->_usedProperties['authSource'] = true;
        $this->authSource = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function journal($value): static
    {
        $this->_usedProperties['journal'] = true;
        $this->journal = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function password($value): static
    {
        $this->_usedProperties['password'] = true;
        $this->password = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|'primary'|'primaryPreferred'|'secondary'|'secondaryPreferred'|'nearest' $value
     * @return $this
     */
    public function readPreference($value): static
    {
        $this->_usedProperties['readPreference'] = true;
        $this->readPreference = $value;

        return $this;
    }

    /**
     * @param ParamConfigurator|list<ParamConfigurator|mixed|array> $value
     *
     * @return $this
     */
    public function readPreferenceTags(ParamConfigurator|array $value): static
    {
        $this->_usedProperties['readPreferenceTags'] = true;
        $this->readPreferenceTags = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function replicaSet($value): static
    {
        $this->_usedProperties['replicaSet'] = true;
        $this->replicaSet = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function socketTimeoutMS($value): static
    {
        $this->_usedProperties['socketTimeoutMS'] = true;
        $this->socketTimeoutMS = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function ssl($value): static
    {
        $this->_usedProperties['ssl'] = true;
        $this->ssl = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tls($value): static
    {
        $this->_usedProperties['tls'] = true;
        $this->tls = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tlsAllowInvalidCertificates($value): static
    {
        $this->_usedProperties['tlsAllowInvalidCertificates'] = true;
        $this->tlsAllowInvalidCertificates = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tlsAllowInvalidHostnames($value): static
    {
        $this->_usedProperties['tlsAllowInvalidHostnames'] = true;
        $this->tlsAllowInvalidHostnames = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function tlsCAFile($value): static
    {
        $this->_usedProperties['tlsCAFile'] = true;
        $this->tlsCAFile = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function tlsCertificateKeyFile($value): static
    {
        $this->_usedProperties['tlsCertificateKeyFile'] = true;
        $this->tlsCertificateKeyFile = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function tlsCertificateKeyFilePassword($value): static
    {
        $this->_usedProperties['tlsCertificateKeyFilePassword'] = true;
        $this->tlsCertificateKeyFilePassword = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tlsDisableCertificateRevocationCheck($value): static
    {
        $this->_usedProperties['tlsDisableCertificateRevocationCheck'] = true;
        $this->tlsDisableCertificateRevocationCheck = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tlsDisableOCSPEndpointCheck($value): static
    {
        $this->_usedProperties['tlsDisableOCSPEndpointCheck'] = true;
        $this->tlsDisableOCSPEndpointCheck = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function tlsInsecure($value): static
    {
        $this->_usedProperties['tlsInsecure'] = true;
        $this->tlsInsecure = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function username($value): static
    {
        $this->_usedProperties['username'] = true;
        $this->username = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function retryReads($value): static
    {
        $this->_usedProperties['retryReads'] = true;
        $this->retryReads = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function retryWrites($value): static
    {
        $this->_usedProperties['retryWrites'] = true;
        $this->retryWrites = $value;

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
    public function wTimeoutMS($value): static
    {
        $this->_usedProperties['wTimeoutMS'] = true;
        $this->wTimeoutMS = $value;

        return $this;
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('authMechanism', $value)) {
            $this->_usedProperties['authMechanism'] = true;
            $this->authMechanism = $value['authMechanism'];
            unset($value['authMechanism']);
        }

        if (array_key_exists('connectTimeoutMS', $value)) {
            $this->_usedProperties['connectTimeoutMS'] = true;
            $this->connectTimeoutMS = $value['connectTimeoutMS'];
            unset($value['connectTimeoutMS']);
        }

        if (array_key_exists('db', $value)) {
            $this->_usedProperties['db'] = true;
            $this->db = $value['db'];
            unset($value['db']);
        }

        if (array_key_exists('authSource', $value)) {
            $this->_usedProperties['authSource'] = true;
            $this->authSource = $value['authSource'];
            unset($value['authSource']);
        }

        if (array_key_exists('journal', $value)) {
            $this->_usedProperties['journal'] = true;
            $this->journal = $value['journal'];
            unset($value['journal']);
        }

        if (array_key_exists('password', $value)) {
            $this->_usedProperties['password'] = true;
            $this->password = $value['password'];
            unset($value['password']);
        }

        if (array_key_exists('readPreference', $value)) {
            $this->_usedProperties['readPreference'] = true;
            $this->readPreference = $value['readPreference'];
            unset($value['readPreference']);
        }

        if (array_key_exists('readPreferenceTags', $value)) {
            $this->_usedProperties['readPreferenceTags'] = true;
            $this->readPreferenceTags = $value['readPreferenceTags'];
            unset($value['readPreferenceTags']);
        }

        if (array_key_exists('replicaSet', $value)) {
            $this->_usedProperties['replicaSet'] = true;
            $this->replicaSet = $value['replicaSet'];
            unset($value['replicaSet']);
        }

        if (array_key_exists('socketTimeoutMS', $value)) {
            $this->_usedProperties['socketTimeoutMS'] = true;
            $this->socketTimeoutMS = $value['socketTimeoutMS'];
            unset($value['socketTimeoutMS']);
        }

        if (array_key_exists('ssl', $value)) {
            $this->_usedProperties['ssl'] = true;
            $this->ssl = $value['ssl'];
            unset($value['ssl']);
        }

        if (array_key_exists('tls', $value)) {
            $this->_usedProperties['tls'] = true;
            $this->tls = $value['tls'];
            unset($value['tls']);
        }

        if (array_key_exists('tlsAllowInvalidCertificates', $value)) {
            $this->_usedProperties['tlsAllowInvalidCertificates'] = true;
            $this->tlsAllowInvalidCertificates = $value['tlsAllowInvalidCertificates'];
            unset($value['tlsAllowInvalidCertificates']);
        }

        if (array_key_exists('tlsAllowInvalidHostnames', $value)) {
            $this->_usedProperties['tlsAllowInvalidHostnames'] = true;
            $this->tlsAllowInvalidHostnames = $value['tlsAllowInvalidHostnames'];
            unset($value['tlsAllowInvalidHostnames']);
        }

        if (array_key_exists('tlsCAFile', $value)) {
            $this->_usedProperties['tlsCAFile'] = true;
            $this->tlsCAFile = $value['tlsCAFile'];
            unset($value['tlsCAFile']);
        }

        if (array_key_exists('tlsCertificateKeyFile', $value)) {
            $this->_usedProperties['tlsCertificateKeyFile'] = true;
            $this->tlsCertificateKeyFile = $value['tlsCertificateKeyFile'];
            unset($value['tlsCertificateKeyFile']);
        }

        if (array_key_exists('tlsCertificateKeyFilePassword', $value)) {
            $this->_usedProperties['tlsCertificateKeyFilePassword'] = true;
            $this->tlsCertificateKeyFilePassword = $value['tlsCertificateKeyFilePassword'];
            unset($value['tlsCertificateKeyFilePassword']);
        }

        if (array_key_exists('tlsDisableCertificateRevocationCheck', $value)) {
            $this->_usedProperties['tlsDisableCertificateRevocationCheck'] = true;
            $this->tlsDisableCertificateRevocationCheck = $value['tlsDisableCertificateRevocationCheck'];
            unset($value['tlsDisableCertificateRevocationCheck']);
        }

        if (array_key_exists('tlsDisableOCSPEndpointCheck', $value)) {
            $this->_usedProperties['tlsDisableOCSPEndpointCheck'] = true;
            $this->tlsDisableOCSPEndpointCheck = $value['tlsDisableOCSPEndpointCheck'];
            unset($value['tlsDisableOCSPEndpointCheck']);
        }

        if (array_key_exists('tlsInsecure', $value)) {
            $this->_usedProperties['tlsInsecure'] = true;
            $this->tlsInsecure = $value['tlsInsecure'];
            unset($value['tlsInsecure']);
        }

        if (array_key_exists('username', $value)) {
            $this->_usedProperties['username'] = true;
            $this->username = $value['username'];
            unset($value['username']);
        }

        if (array_key_exists('retryReads', $value)) {
            $this->_usedProperties['retryReads'] = true;
            $this->retryReads = $value['retryReads'];
            unset($value['retryReads']);
        }

        if (array_key_exists('retryWrites', $value)) {
            $this->_usedProperties['retryWrites'] = true;
            $this->retryWrites = $value['retryWrites'];
            unset($value['retryWrites']);
        }

        if (array_key_exists('w', $value)) {
            $this->_usedProperties['w'] = true;
            $this->w = $value['w'];
            unset($value['w']);
        }

        if (array_key_exists('wTimeoutMS', $value)) {
            $this->_usedProperties['wTimeoutMS'] = true;
            $this->wTimeoutMS = $value['wTimeoutMS'];
            unset($value['wTimeoutMS']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['authMechanism'])) {
            $output['authMechanism'] = $this->authMechanism;
        }
        if (isset($this->_usedProperties['connectTimeoutMS'])) {
            $output['connectTimeoutMS'] = $this->connectTimeoutMS;
        }
        if (isset($this->_usedProperties['db'])) {
            $output['db'] = $this->db;
        }
        if (isset($this->_usedProperties['authSource'])) {
            $output['authSource'] = $this->authSource;
        }
        if (isset($this->_usedProperties['journal'])) {
            $output['journal'] = $this->journal;
        }
        if (isset($this->_usedProperties['password'])) {
            $output['password'] = $this->password;
        }
        if (isset($this->_usedProperties['readPreference'])) {
            $output['readPreference'] = $this->readPreference;
        }
        if (isset($this->_usedProperties['readPreferenceTags'])) {
            $output['readPreferenceTags'] = $this->readPreferenceTags;
        }
        if (isset($this->_usedProperties['replicaSet'])) {
            $output['replicaSet'] = $this->replicaSet;
        }
        if (isset($this->_usedProperties['socketTimeoutMS'])) {
            $output['socketTimeoutMS'] = $this->socketTimeoutMS;
        }
        if (isset($this->_usedProperties['ssl'])) {
            $output['ssl'] = $this->ssl;
        }
        if (isset($this->_usedProperties['tls'])) {
            $output['tls'] = $this->tls;
        }
        if (isset($this->_usedProperties['tlsAllowInvalidCertificates'])) {
            $output['tlsAllowInvalidCertificates'] = $this->tlsAllowInvalidCertificates;
        }
        if (isset($this->_usedProperties['tlsAllowInvalidHostnames'])) {
            $output['tlsAllowInvalidHostnames'] = $this->tlsAllowInvalidHostnames;
        }
        if (isset($this->_usedProperties['tlsCAFile'])) {
            $output['tlsCAFile'] = $this->tlsCAFile;
        }
        if (isset($this->_usedProperties['tlsCertificateKeyFile'])) {
            $output['tlsCertificateKeyFile'] = $this->tlsCertificateKeyFile;
        }
        if (isset($this->_usedProperties['tlsCertificateKeyFilePassword'])) {
            $output['tlsCertificateKeyFilePassword'] = $this->tlsCertificateKeyFilePassword;
        }
        if (isset($this->_usedProperties['tlsDisableCertificateRevocationCheck'])) {
            $output['tlsDisableCertificateRevocationCheck'] = $this->tlsDisableCertificateRevocationCheck;
        }
        if (isset($this->_usedProperties['tlsDisableOCSPEndpointCheck'])) {
            $output['tlsDisableOCSPEndpointCheck'] = $this->tlsDisableOCSPEndpointCheck;
        }
        if (isset($this->_usedProperties['tlsInsecure'])) {
            $output['tlsInsecure'] = $this->tlsInsecure;
        }
        if (isset($this->_usedProperties['username'])) {
            $output['username'] = $this->username;
        }
        if (isset($this->_usedProperties['retryReads'])) {
            $output['retryReads'] = $this->retryReads;
        }
        if (isset($this->_usedProperties['retryWrites'])) {
            $output['retryWrites'] = $this->retryWrites;
        }
        if (isset($this->_usedProperties['w'])) {
            $output['w'] = $this->w;
        }
        if (isset($this->_usedProperties['wTimeoutMS'])) {
            $output['wTimeoutMS'] = $this->wTimeoutMS;
        }

        return $output;
    }

}
