<?php

namespace SclZfSequenceGenerator;

class Module
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'shared' => array(
                'SclZfSequenceGenerator\Entity\SequenceNumber' => false,
            ),
            'invokables' => array(
                'SclZfSequenceGenerator\Entity\SequenceNumber' => 'SclZfSequenceGenerator\Entity\SequenceNumber',
                'SclZfSequenceGenerator\SequenceGenerator'     => 'SclZfSequenceGenerator\DoctrineSequenceGenerator',
            ),
        );
    }
}
