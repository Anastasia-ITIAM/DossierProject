<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMongodb'.\DIRECTORY_SEPARATOR.'DocumentManagerConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMongodb'.\DIRECTORY_SEPARATOR.'ConnectionConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMongodb'.\DIRECTORY_SEPARATOR.'TypeConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMongodb'.\DIRECTORY_SEPARATOR.'DefaultCommitOptionsConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMongodb'.\DIRECTORY_SEPARATOR.'ControllerResolverConfig.php';

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Loader\ParamConfigurator;

/**
 * This class is automatically generated to help in creating a config.
 */
class DoctrineMongodbConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $documentManagers;
    private $connections;
    private $resolveTargetDocuments;
    private $types;
    private $proxyNamespace;
    private $proxyDir;
    private $enableLazyGhostObjects;
    private $autoGenerateProxyClasses;
    private $hydratorNamespace;
    private $hydratorDir;
    private $autoGenerateHydratorClasses;
    private $persistentCollectionNamespace;
    private $persistentCollectionDir;
    private $autoGeneratePersistentCollectionClasses;
    private $defaultDocumentManager;
    private $defaultConnection;
    private $defaultDatabase;
    private $defaultCommitOptions;
    private $controllerResolver;
    private $_usedProperties = [];

    public function documentManager(string $id, array $value = []): \Symfony\Config\DoctrineMongodb\DocumentManagerConfig
    {
        if (!isset($this->documentManagers[$id])) {
            $this->_usedProperties['documentManagers'] = true;
            $this->documentManagers[$id] = new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "documentManager()" has already been initialized. You cannot pass values the second time you call documentManager().');
        }

        return $this->documentManagers[$id];
    }

    public function connection(string $id, array $value = []): \Symfony\Config\DoctrineMongodb\ConnectionConfig
    {
        if (!isset($this->connections[$id])) {
            $this->_usedProperties['connections'] = true;
            $this->connections[$id] = new \Symfony\Config\DoctrineMongodb\ConnectionConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "connection()" has already been initialized. You cannot pass values the second time you call connection().');
        }

        return $this->connections[$id];
    }

    /**
     * @return $this
     */
    public function resolveTargetDocument(string $interface, mixed $value): static
    {
        $this->_usedProperties['resolveTargetDocuments'] = true;
        $this->resolveTargetDocuments[$interface] = $value;

        return $this;
    }

    /**
     * @template TValue of string|array
     * @param TValue $value
     * @return \Symfony\Config\DoctrineMongodb\TypeConfig|$this
     * @psalm-return (TValue is array ? \Symfony\Config\DoctrineMongodb\TypeConfig : static)
     */
    public function type(string $name, string|array $value = []): \Symfony\Config\DoctrineMongodb\TypeConfig|static
    {
        if (!\is_array($value)) {
            $this->_usedProperties['types'] = true;
            $this->types[$name] = $value;

            return $this;
        }

        if (!isset($this->types[$name]) || !$this->types[$name] instanceof \Symfony\Config\DoctrineMongodb\TypeConfig) {
            $this->_usedProperties['types'] = true;
            $this->types[$name] = new \Symfony\Config\DoctrineMongodb\TypeConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "type()" has already been initialized. You cannot pass values the second time you call type().');
        }

        return $this->types[$name];
    }

    /**
     * @default 'MongoDBODMProxies'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function proxyNamespace($value): static
    {
        $this->_usedProperties['proxyNamespace'] = true;
        $this->proxyNamespace = $value;

        return $this;
    }

    /**
     * @default '%kernel.cache_dir%/doctrine/odm/mongodb/Proxies'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function proxyDir($value): static
    {
        $this->_usedProperties['proxyDir'] = true;
        $this->proxyDir = $value;

        return $this;
    }

    /**
     * @default true
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function enableLazyGhostObjects($value): static
    {
        $this->_usedProperties['enableLazyGhostObjects'] = true;
        $this->enableLazyGhostObjects = $value;

        return $this;
    }

    /**
     * @default 3
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function autoGenerateProxyClasses($value): static
    {
        $this->_usedProperties['autoGenerateProxyClasses'] = true;
        $this->autoGenerateProxyClasses = $value;

        return $this;
    }

    /**
     * @default 'Hydrators'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function hydratorNamespace($value): static
    {
        $this->_usedProperties['hydratorNamespace'] = true;
        $this->hydratorNamespace = $value;

        return $this;
    }

    /**
     * @default '%kernel.cache_dir%/doctrine/odm/mongodb/Hydrators'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function hydratorDir($value): static
    {
        $this->_usedProperties['hydratorDir'] = true;
        $this->hydratorDir = $value;

        return $this;
    }

    /**
     * @default 0
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function autoGenerateHydratorClasses($value): static
    {
        $this->_usedProperties['autoGenerateHydratorClasses'] = true;
        $this->autoGenerateHydratorClasses = $value;

        return $this;
    }

    /**
     * @default 'PersistentCollections'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function persistentCollectionNamespace($value): static
    {
        $this->_usedProperties['persistentCollectionNamespace'] = true;
        $this->persistentCollectionNamespace = $value;

        return $this;
    }

    /**
     * @default '%kernel.cache_dir%/doctrine/odm/mongodb/PersistentCollections'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function persistentCollectionDir($value): static
    {
        $this->_usedProperties['persistentCollectionDir'] = true;
        $this->persistentCollectionDir = $value;

        return $this;
    }

    /**
     * @default 0
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function autoGeneratePersistentCollectionClasses($value): static
    {
        $this->_usedProperties['autoGeneratePersistentCollectionClasses'] = true;
        $this->autoGeneratePersistentCollectionClasses = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultDocumentManager($value): static
    {
        $this->_usedProperties['defaultDocumentManager'] = true;
        $this->defaultDocumentManager = $value;

        return $this;
    }

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultConnection($value): static
    {
        $this->_usedProperties['defaultConnection'] = true;
        $this->defaultConnection = $value;

        return $this;
    }

    /**
     * @default 'default'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultDatabase($value): static
    {
        $this->_usedProperties['defaultDatabase'] = true;
        $this->defaultDatabase = $value;

        return $this;
    }

    public function defaultCommitOptions(array $value = []): \Symfony\Config\DoctrineMongodb\DefaultCommitOptionsConfig
    {
        if (null === $this->defaultCommitOptions) {
            $this->_usedProperties['defaultCommitOptions'] = true;
            $this->defaultCommitOptions = new \Symfony\Config\DoctrineMongodb\DefaultCommitOptionsConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "defaultCommitOptions()" has already been initialized. You cannot pass values the second time you call defaultCommitOptions().');
        }

        return $this->defaultCommitOptions;
    }

    /**
     * @default {"enabled":true,"auto_mapping":true}
    */
    public function controllerResolver(array $value = []): \Symfony\Config\DoctrineMongodb\ControllerResolverConfig
    {
        if (null === $this->controllerResolver) {
            $this->_usedProperties['controllerResolver'] = true;
            $this->controllerResolver = new \Symfony\Config\DoctrineMongodb\ControllerResolverConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "controllerResolver()" has already been initialized. You cannot pass values the second time you call controllerResolver().');
        }

        return $this->controllerResolver;
    }

    public function getExtensionAlias(): string
    {
        return 'doctrine_mongodb';
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('document_managers', $value)) {
            $this->_usedProperties['documentManagers'] = true;
            $this->documentManagers = array_map(fn ($v) => new \Symfony\Config\DoctrineMongodb\DocumentManagerConfig($v), $value['document_managers']);
            unset($value['document_managers']);
        }

        if (array_key_exists('connections', $value)) {
            $this->_usedProperties['connections'] = true;
            $this->connections = array_map(fn ($v) => new \Symfony\Config\DoctrineMongodb\ConnectionConfig($v), $value['connections']);
            unset($value['connections']);
        }

        if (array_key_exists('resolve_target_documents', $value)) {
            $this->_usedProperties['resolveTargetDocuments'] = true;
            $this->resolveTargetDocuments = $value['resolve_target_documents'];
            unset($value['resolve_target_documents']);
        }

        if (array_key_exists('types', $value)) {
            $this->_usedProperties['types'] = true;
            $this->types = array_map(fn ($v) => \is_array($v) ? new \Symfony\Config\DoctrineMongodb\TypeConfig($v) : $v, $value['types']);
            unset($value['types']);
        }

        if (array_key_exists('proxy_namespace', $value)) {
            $this->_usedProperties['proxyNamespace'] = true;
            $this->proxyNamespace = $value['proxy_namespace'];
            unset($value['proxy_namespace']);
        }

        if (array_key_exists('proxy_dir', $value)) {
            $this->_usedProperties['proxyDir'] = true;
            $this->proxyDir = $value['proxy_dir'];
            unset($value['proxy_dir']);
        }

        if (array_key_exists('enable_lazy_ghost_objects', $value)) {
            $this->_usedProperties['enableLazyGhostObjects'] = true;
            $this->enableLazyGhostObjects = $value['enable_lazy_ghost_objects'];
            unset($value['enable_lazy_ghost_objects']);
        }

        if (array_key_exists('auto_generate_proxy_classes', $value)) {
            $this->_usedProperties['autoGenerateProxyClasses'] = true;
            $this->autoGenerateProxyClasses = $value['auto_generate_proxy_classes'];
            unset($value['auto_generate_proxy_classes']);
        }

        if (array_key_exists('hydrator_namespace', $value)) {
            $this->_usedProperties['hydratorNamespace'] = true;
            $this->hydratorNamespace = $value['hydrator_namespace'];
            unset($value['hydrator_namespace']);
        }

        if (array_key_exists('hydrator_dir', $value)) {
            $this->_usedProperties['hydratorDir'] = true;
            $this->hydratorDir = $value['hydrator_dir'];
            unset($value['hydrator_dir']);
        }

        if (array_key_exists('auto_generate_hydrator_classes', $value)) {
            $this->_usedProperties['autoGenerateHydratorClasses'] = true;
            $this->autoGenerateHydratorClasses = $value['auto_generate_hydrator_classes'];
            unset($value['auto_generate_hydrator_classes']);
        }

        if (array_key_exists('persistent_collection_namespace', $value)) {
            $this->_usedProperties['persistentCollectionNamespace'] = true;
            $this->persistentCollectionNamespace = $value['persistent_collection_namespace'];
            unset($value['persistent_collection_namespace']);
        }

        if (array_key_exists('persistent_collection_dir', $value)) {
            $this->_usedProperties['persistentCollectionDir'] = true;
            $this->persistentCollectionDir = $value['persistent_collection_dir'];
            unset($value['persistent_collection_dir']);
        }

        if (array_key_exists('auto_generate_persistent_collection_classes', $value)) {
            $this->_usedProperties['autoGeneratePersistentCollectionClasses'] = true;
            $this->autoGeneratePersistentCollectionClasses = $value['auto_generate_persistent_collection_classes'];
            unset($value['auto_generate_persistent_collection_classes']);
        }

        if (array_key_exists('default_document_manager', $value)) {
            $this->_usedProperties['defaultDocumentManager'] = true;
            $this->defaultDocumentManager = $value['default_document_manager'];
            unset($value['default_document_manager']);
        }

        if (array_key_exists('default_connection', $value)) {
            $this->_usedProperties['defaultConnection'] = true;
            $this->defaultConnection = $value['default_connection'];
            unset($value['default_connection']);
        }

        if (array_key_exists('default_database', $value)) {
            $this->_usedProperties['defaultDatabase'] = true;
            $this->defaultDatabase = $value['default_database'];
            unset($value['default_database']);
        }

        if (array_key_exists('default_commit_options', $value)) {
            $this->_usedProperties['defaultCommitOptions'] = true;
            $this->defaultCommitOptions = new \Symfony\Config\DoctrineMongodb\DefaultCommitOptionsConfig($value['default_commit_options']);
            unset($value['default_commit_options']);
        }

        if (array_key_exists('controller_resolver', $value)) {
            $this->_usedProperties['controllerResolver'] = true;
            $this->controllerResolver = new \Symfony\Config\DoctrineMongodb\ControllerResolverConfig($value['controller_resolver']);
            unset($value['controller_resolver']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['documentManagers'])) {
            $output['document_managers'] = array_map(fn ($v) => $v->toArray(), $this->documentManagers);
        }
        if (isset($this->_usedProperties['connections'])) {
            $output['connections'] = array_map(fn ($v) => $v->toArray(), $this->connections);
        }
        if (isset($this->_usedProperties['resolveTargetDocuments'])) {
            $output['resolve_target_documents'] = $this->resolveTargetDocuments;
        }
        if (isset($this->_usedProperties['types'])) {
            $output['types'] = array_map(fn ($v) => $v instanceof \Symfony\Config\DoctrineMongodb\TypeConfig ? $v->toArray() : $v, $this->types);
        }
        if (isset($this->_usedProperties['proxyNamespace'])) {
            $output['proxy_namespace'] = $this->proxyNamespace;
        }
        if (isset($this->_usedProperties['proxyDir'])) {
            $output['proxy_dir'] = $this->proxyDir;
        }
        if (isset($this->_usedProperties['enableLazyGhostObjects'])) {
            $output['enable_lazy_ghost_objects'] = $this->enableLazyGhostObjects;
        }
        if (isset($this->_usedProperties['autoGenerateProxyClasses'])) {
            $output['auto_generate_proxy_classes'] = $this->autoGenerateProxyClasses;
        }
        if (isset($this->_usedProperties['hydratorNamespace'])) {
            $output['hydrator_namespace'] = $this->hydratorNamespace;
        }
        if (isset($this->_usedProperties['hydratorDir'])) {
            $output['hydrator_dir'] = $this->hydratorDir;
        }
        if (isset($this->_usedProperties['autoGenerateHydratorClasses'])) {
            $output['auto_generate_hydrator_classes'] = $this->autoGenerateHydratorClasses;
        }
        if (isset($this->_usedProperties['persistentCollectionNamespace'])) {
            $output['persistent_collection_namespace'] = $this->persistentCollectionNamespace;
        }
        if (isset($this->_usedProperties['persistentCollectionDir'])) {
            $output['persistent_collection_dir'] = $this->persistentCollectionDir;
        }
        if (isset($this->_usedProperties['autoGeneratePersistentCollectionClasses'])) {
            $output['auto_generate_persistent_collection_classes'] = $this->autoGeneratePersistentCollectionClasses;
        }
        if (isset($this->_usedProperties['defaultDocumentManager'])) {
            $output['default_document_manager'] = $this->defaultDocumentManager;
        }
        if (isset($this->_usedProperties['defaultConnection'])) {
            $output['default_connection'] = $this->defaultConnection;
        }
        if (isset($this->_usedProperties['defaultDatabase'])) {
            $output['default_database'] = $this->defaultDatabase;
        }
        if (isset($this->_usedProperties['defaultCommitOptions'])) {
            $output['default_commit_options'] = $this->defaultCommitOptions->toArray();
        }
        if (isset($this->_usedProperties['controllerResolver'])) {
            $output['controller_resolver'] = $this->controllerResolver->toArray();
        }

        return $output;
    }

}
