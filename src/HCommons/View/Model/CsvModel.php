<?php
    
namespace HCommons\View\Model;
    
use Zend\View\Model\ViewModel;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class CsvModel extends ViewModel
{

    const DEFAULT_FILENAME = "export";

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
    protected $template = 'download/csv';
    
 
    /**
     * Constructor
     *
     * @param  array|Traversable $data
     * @return void
     */    
    public function __construct($data = null)
    {
        $this->setData($data);
        $this->setFileName(self::DEFAULT_FILENAME);               
    }
    
    public function setData($data)
    {
        
        if ($data instanceof Traversable) {
            $data = ArrayUtils::iteratorToArray($data);
        }
        if (!is_array($data)) {
            throw new \InvalidArgumentException(sprintf(
                '%s: expects an array, or Traversable argument; received "%s"',
                __METHOD__,
                (is_object($data) ? get_class($data) : gettype($data))
            ));
        }
        $this->setVariable('results', $data);         
    }

    public function setFileName($filename)
    {
        $this->setOption('filename', $filename);               
    }

    public function getFileName()
    {
        return $this->getOption('filename');
    }
              
}
