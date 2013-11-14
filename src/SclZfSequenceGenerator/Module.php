<?php

namespace SclZfSequenceGenerator;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../../autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'shared' => [
                'SclZfSequenceGenerator\Entity\SequenceNumber' => false,
            ],
            'aliases' => [
                'SclZfSequenceGenerator\SequenceGenerator' => 'SclZfSequenceGenerator\DoctrineSequenceGenerator',
            ],
            'invokables' => [
                'SclZfSequenceGenerator\Entity\SequenceNumber' => 'SclZfSequenceGenerator\Entity\SequenceNumber',
            ],
            'factories' => [
                'SclZfSequenceGenerator\DoctrineSequenceGenerator' => function ($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new DoctrineSequenceGenerator($entityManager);
                }
            ],
        ];
    }
}
