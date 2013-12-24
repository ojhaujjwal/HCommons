<?php
    
namespace HCommons\View\Strategy;

use HCommons\View\Model;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;
use WebinoImageThumb\WebinoImageThumb;

class ImageStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var WebinoImageThumb
     */
    protected $webinoImageThumb;

    /**
     * Constructor
     *
     * @param  WebinoImageThumb $renderer
     * @return void
     */
    public function setWebinoImageThumb(WebinoImageThumb $webinoImageThumb)
    {
        $this->webinoImageThumb = $webinoImageThumb;
    }


    /**
     * Retrieve the composed renderer
     *
     * @return WebinoImageThumb
     */
    public function getWebinoImageThumb()
    {
        return $this->webinoImageThumb;
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
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'passPhpThumb'), $priority);
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
     * Inject the response with the Image payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $model = $e->getModel();
        
        if (!$model instanceof Model\ImageModel) {
            return ;
        }
        $response = $e->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'image/png');
    }

    public function passPhpThumb(ViewEvent $e)
    {
        $model = $e->getModel();
        
        if (!$model instanceof Model\ImageModel) {
            return ;
        }
        if ($model->getFileName()) {
            $model->setPhpThumb($this->getWebinoImageThumb()->create($model->getFileName()));      
        }
        
    }
        
}
