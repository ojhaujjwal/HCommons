<?php
namespace HCommons\View\Model;
    
class DbTableCsvModel extends CsvModel
{
    /**
     * Template to use when rendering this model
     *
     * @var string
     */
    protected $template = 'download/table-db-csv';

    public function setHeader(array $header)
    {
        if (!$this->getVariable('fieldsOrder'))  {
            $this->setFieldsOrder(array_keys($header));
        }
        $this->setVariable('header', $header)
    }

    public function getHeader()
    {
        return $this->getVariable('header')
    }

    public function setFieldsOrder(array $fieldsOrder)
    {
        $this->setVariable('fieldsOrder', $fieldsOrder)
    }

    public function getFieldsOrder()
    {
        if (!$this->getVariable('fieldsOrder')) {
            $header = $this->getHeader();
            if (!is_array($header)) {
                throw new \RunTimeException('Please set header first or use CsvModel');
            }
            $this->setFieldsOrder(array_keys($header));
        }
        return $this->getVariable('fieldsOrder');
    }

    public function setFields(array $fields)
    {
        $this->setFieldsOrder($fields);
    }
}
