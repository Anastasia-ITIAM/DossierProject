<?php

namespace Symfony\Config\DoctrineMongodb;

require_once __DIR__.\DIRECTORY_SEPARATOR.'DocumentManagerConfig'.\DIRECTORY_SEPARATOR.'ProfilerConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DocumentManagerConfig'.\DIRECTORY_SEPARATOR.'FilterConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DocumentManagerConfig'.\DIRECTORY_SEPARATOR.'MetadataCacheDriverConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DocumentManagerConfig'.\DIRECTORY_SEPARATOR.'MappingConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class DocumentManagerConfig 
{
    private $connection;
    private $database;
    private $logging;
    private $profiler;
    private $defaultDocumentRepositoryClass;
    private $defaultGridfsRepositoryClass;
    private $repositoryFactory;
    private $persistentCollectionFactory;
    private $autoMapping;
    private $filters;
    private $metadataCacheDriver;
    private $useTransactionalFlush;
    private $mappings;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function connection($value): static
    {
        $this->_usedProperties['connection'] = true;
        $this->connection = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function database($value): static
    {
        $this->_usedProperties['database'] = true;
        $this->database = $value;

        return $this;
    }

    /**
     * @default '%kernel.debug%'
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function logging($value): static
    {
        $this->_usedProperties['logging'] = true;
        $this->logging = $value;

        return $this;
    }

    /**
     * @default {"enabled":"%kernel.debug%","pretty":"%kernel.debug%"}
    */
    public function profiler(array $value = []): \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\ProfilerConfig
    {
        if (null === $this->profiler) {
            $this->_usedProperties['profiler'] = true;
            $this->profiler = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\ProfilerConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "profiler()" has already been initialized. You cannot pass values the second time you call profiler().');
        }

        return $this->profiler;
    }

    /**
     * @default 'Doctrine\\ODM\\MongoDB\\Repository\\DocumentRepository'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultDocumentRepositoryClass($value): static
    {
        $this->_usedProperties['defaultDocumentRepositoryClass'] = true;
        $this->defaultDocumentRepositoryClass = $value;

        return $this;
    }

    /**
     * @default 'Doctrine\\ODM\\MongoDB\\Repository\\DefaultGridFSRepository'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultGridfsRepositoryClass($value): static
    {
        $this->_usedProperties['defaultGridfsRepositoryClass'] = true;
        $this->defaultGridfsRepositoryClass = $value;

        return $this;
    }

    /**
     * @default 'doctrine_mongodb.odm.container_repository_factory'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function repositoryFactory($value): static
    {
        $this->_usedProperties['repositoryFactory'] = true;
        $this->repositoryFactory = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function persistentCollectionFactory($value): static
    {
        $this->_usedProperties['persistentCollectionFactory'] = true;
        $this->persistentCollectionFactory = $value;

        return $this;
    }

    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function autoMapping($value): static
    {
        $this->_usedProperties['autoMapping'] = true;
        $this->autoMapping = $value;

        return $this;
    }

    /**
     * @template TValue of mixed
     * @param TValue $value
     * @return \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig|$this
     * @psalm-return (TValue is array ? \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig : static)
     */
    public function filter(string $name, mixed $value = []): \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig|static
    {
        if (!\is_array($value)) {
            $this->_usedProperties['filters'] = true;
            $this->filters[$name] = $value;

            return $this;
        }

        if (!isset($this->filters[$name]) || !$this->filters[$name] instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig) {
            $this->_usedProperties['filters'] = true;
            $this->filters[$name] = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "filter()" has already been initialized. You cannot pass values the second time you call filter().');
        }

        return $this->filters[$name];
    }

    /**
     * @template TValue of string|array
     * @param TValue $value
     * @default {"type":"array"}
     * @return \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig|$this
     * @psalm-return (TValue is array ? \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig : static)
     */
    public function metadataCacheDriver(string|array $value = []): \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig|static
    {
        if (!\is_array($value)) {
            $this->_usedProperties['metadataCacheDriver'] = true;
            $this->metadataCacheDriver = $value;

            return $this;
        }

        if (!$this->metadataCacheDriver instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig) {
            $this->_usedProperties['metadataCacheDriver'] = true;
            $this->metadataCacheDriver = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "metadataCacheDriver()" has already been initialized. You cannot pass values the second time you call metadataCacheDriver().');
        }

        return $this->metadataCacheDriver;
    }

    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function useTransactionalFlush($value): static
    {
        $this->_usedProperties['useTransactionalFlush'] = true;
        $this->useTransactionalFlush = $value;

        return $this;
    }

    /**
     * @template TValue of string|array
     * @param TValue $value
     * @return \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig|$this
     * @psalm-return (TValue is array ? \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig : static)
     */
    public function mapping(string $name, string|array $value = []): \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig|static
    {
        if (!\is_array($value)) {
            $this->_usedProperties['mappings'] = true;
            $this->mappings[$name] = $value;

            return $this;
        }

        if (!isset($this->mappings[$name]) || !$this->mappings[$name] instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig) {
            $this->_usedProperties['mappings'] = true;
            $this->mappings[$name] = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "mapping()" has already been initialized. You cannot pass values the second time you call mapping().');
        }

        return $this->mappings[$name];
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('connection', $value)) {
            $this->_usedProperties['connection'] = true;
            $this->connection = $value['connection'];
            unset($value['connection']);
        }

        if (array_key_exists('database', $value)) {
            $this->_usedProperties['database'] = true;
            $this->database = $value['database'];
            unset($value['database']);
        }

        if (array_key_exists('logging', $value)) {
            $this->_usedProperties['logging'] = true;
            $this->logging = $value['logging'];
            unset($value['logging']);
        }

        if (array_key_exists('profiler', $value)) {
            $this->_usedProperties['profiler'] = true;
            $this->profiler = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\ProfilerConfig($value['profiler']);
            unset($value['profiler']);
        }

        if (array_key_exists('default_document_repository_class', $value)) {
            $this->_usedProperties['defaultDocumentRepositoryClass'] = true;
            $this->defaultDocumentRepositoryClass = $value['default_document_repository_class'];
            unset($value['default_document_repository_class']);
        }

        if (array_key_exists('default_gridfs_repository_class', $value)) {
            $this->_usedProperties['defaultGridfsRepositoryClass'] = true;
            $this->defaultGridfsRepositoryClass = $value['default_gridfs_repository_class'];
            unset($value['default_gridfs_repository_class']);
        }

        if (array_key_exists('repository_factory', $value)) {
            $this->_usedProperties['repositoryFactory'] = true;
            $this->repositoryFactory = $value['repository_factory'];
            unset($value['repository_factory']);
        }

        if (array_key_exists('persistent_collection_factory', $value)) {
            $this->_usedProperties['persistentCollectionFactory'] = true;
            $this->persistentCollectionFactory = $value['persistent_collection_factory'];
            unset($value['persistent_collection_factory']);
        }

        if (array_key_exists('auto_mapping', $value)) {
            $this->_usedProperties['autoMapping'] = true;
            $this->autoMapping = $value['auto_mapping'];
            unset($value['auto_mapping']);
        }

        if (array_key_exists('filters', $value)) {
            $this->_usedProperties['filters'] = true;
            $this->filters = array_map(fn ($v) => \is_array($v) ? new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig($v) : $v, $value['filters']);
            unset($value['filters']);
        }

        if (array_key_exists('metadata_cache_driver', $value)) {
            $this->_usedProperties['metadataCacheDriver'] = true;
            $this->metadataCacheDriver = \is_array($value['metadata_cache_driver']) ? new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig($value['metadata_cache_driver']) : $value['metadata_cache_driver'];
            unset($value['metadata_cache_driver']);
        }

        if (array_key_exists('use_transactional_flush', $value)) {
            $this->_usedProperties['useTransactionalFlush'] = true;
            $this->useTransactionalFlush = $value['use_transactional_flush'];
            unset($value['use_transactional_flush']);
        }

        if (array_key_exists('mappings', $value)) {
            $this->_usedProperties['mappings'] = true;
            $this->mappings = array_map(fn ($v) => \is_array($v) ? new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig($v) : $v, $value['mappings']);
            unset($value['mappings']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['connection'])) {
            $output['connection'] = $this->connection;
        }
        if (isset($this->_usedProperties['database'])) {
            $output['database'] = $this->database;
        }
        if (isset($this->_usedProperties['logging'])) {
            $output['logging'] = $this->logging;
        }
        if (isset($this->_usedProperties['profiler'])) {
            $output['profiler'] = $this->profiler->toArray();
        }
        if (isset($this->_usedProperties['defaultDocumentRepositoryClass'])) {
            $output['default_document_repository_class'] = $this->defaultDocumentRepositoryClass;
        }
        if (isset($this->_usedProperties['defaultGridfsRepositoryClass'])) {
            $output['default_gridfs_repository_class'] = $this->defaultGridfsRepositoryClass;
        }
        if (isset($this->_usedProperties['repositoryFactory'])) {
            $output['repository_factory'] = $this->repositoryFactory;
        }
        if (isset($this->_usedProperties['persistentCollectionFactory'])) {
            $output['persistent_collection_factory'] = $this->persistentCollectionFactory;
        }
        if (isset($this->_usedProperties['autoMapping'])) {
            $output['auto_mapping'] = $this->autoMapping;
        }
        if (isset($this->_usedProperties['filters'])) {
            $output['filters'] = array_map(fn ($v) => $v instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\FilterConfig ? $v->toArray() : $v, $this->filters);
        }
        if (isset($this->_usedProperties['metadataCacheDriver'])) {
            $output['metadata_cache_driver'] = $this->metadataCacheDriver instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MetadataCacheDriverConfig ? $this->metadataCacheDriver->toArray() : $this->metadataCacheDriver;
        }
        if (isset($this->_usedProperties['useTransactionalFlush'])) {
            $output['use_transactional_flush'] = $this->useTransactionalFlush;
        }
        if (isset($this->_usedProperties['mappings'])) {
            $output['mappings'] = array_map(fn ($v) => $v instanceof \Symfony\Config\DoctrineMongodb\DocumentManagerConfig\MappingConfig ? $v->toArray() : $v, $this->mappings);
        }

        return $output;
    }

}
