<?php
    
namespace HCommons\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

class OutputCsv extends AbstractPlugin
{

    public function getCsv($results)
    {
            $view = new ViewModel(array('results' => $results));
            $view->setTemplate('download/csv')
                ->setTerminal(true);
            
            $output = $this->getController()
                            ->getServiceLocator()
                            ->get('viewrenderer')
                            ->render($view);
            return $output;           
    }
}
