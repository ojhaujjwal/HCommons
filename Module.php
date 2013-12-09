<?php
namespace HCommons;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HCommonsDbAdapter' => 'Zend\Db\Adapter\AdapterServiceFactory',            
            )
        );
    }

    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'outputCsv' => function ($sm) {
                    return new \HCommons\Controller\Plugin\OutputCsv;
                }, 
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'hPlugin' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $config = $locator->get("Config")['hcommons']['hplugin'];
                    return new View\Helper\HPlugin($config);
                },
            )
        );
    }
}
