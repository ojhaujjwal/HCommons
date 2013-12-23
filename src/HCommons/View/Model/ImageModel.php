<?php
    
namespace HCommons\View\Model;
    
use Zend\View\Model\ViewModel;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class ImageModel extends ViewModel
{
    /**
     * Csv probably won't need to be captured into a 
     * a parent container by default.
     * 
     * @var string
     */
    protected $captureTo = null;

    /**
     * Csv is terminal
     * 
     * @var bool
     */
    protected $terminate = true;  
    
    /**
     * Template to use when rendering this model
     *
     * @var string
     */
    protected $template = 'hcommons/image/png';

    protected $fileName;

    protected $phpThumb;

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        
    }

    public function getFileName()
    {
        return $this->fileName;
    }
    
    public function setPhpThumb(\PHPThumb\GD $phpThumb)
    {
        $this->phpThumb = $phpThumb;
        $this->setVariable('phpThumb', $phpThumb);
    }

    public function getPhpThubm()
    {
        return $this->phpThumb;
    }
       
}