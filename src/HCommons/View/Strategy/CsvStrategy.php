<?php
    
namespace HCommons\View\Strategy;

use HCommons\View\Model;
use Zend\View\Renderer\PhpRenderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class CsvStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  PhpRenderer $renderer
     * @return void
     */
    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * Retrieve the composed renderer
     *
     * @return PhpRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
    
    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }
    
    
    /**
     * Detach aggregate listeners from the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    
    /**
     * Detect if we should use the PhpRenderer based on model type
     *
     * @param  ViewEvent $e
     * @return null|PhpRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        
        if ($model instanceof Model\CsvModel) {
            return $this->renderer;
        }

        return;
    }
    
    
    /**
     * Inject the response with the Csv payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $model = $e->getModel();
        
        if (!$model instanceof Model\CsvModel) {
            return ;
        }

        $result = $e->getResult();

        if (!is_string($result)) {
            return;
        }
        
        $response = $e->getResponse();
        $response->setContent($result);

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/csv')
            ->addHeaderLine('Accept-Ranges', 'bytes')
            ->addHeaderLine('Content-Length', strlen($result));
        $response->setContent($result);
        

        $fileName = $e->getModel()->getFileName();
        if (substr($fileName, -4) != '.csv') {
            $fileName .= '.csv';
        }
        // force download
        $headers->addHeaderLine('Content-Disposition', "attachment; filename=$fileName.csv");       

    }                    
}
