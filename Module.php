<?php
    
namespace HCommons;

use HCommons\View\Renderer\CsvRenderer;
use HCommons\View\Strategy\CsvStrategy;
use HCommons\View\Strategy\ImageStrategy;

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
                'ViewCsvStrategy' => function($sm){
                    return new CsvStrategy($sm->get('view_manager')->getRenderer());
                },
                'HCommons\View\ImageStrategy' => function ($sm) {
                    return new ImageStrategy($sm->get('WebinoImageThumb'));
                }
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
