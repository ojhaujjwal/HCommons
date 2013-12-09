<?php

namespace HCommons\Model;

use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\TableGateway\TableGateway;


abstract class AbstractPaginatorList
{

    /*
    **  @var bool $deriveResultSetPrototype
    **  whether or not get ResultSetPrototype from TableGateway
    **  @see protected function getPaginationAdapter
    */
    protected $deriveResultSetPrototype = true;

    protected $tableGateway;

    protected $fields;

    public function __construct(TableGateway $tableGateway)
    {
        $this->setTableGateway($tableGateway);
    }

    public function setTableGateway(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }


    public function getList(\Closure $anonummous = NULL)
    {
        $select = new Select($this->tableGateway->getTable());
        $fields = $this->getFields();
        if ($anonummous) {
            $anonummous($select);
        } elseif(method_exists($this, "UseSelect")) {
            $this->UseSelect($select);
        } elseif (!empty($fields)) {
            $select->columns($this->getFields());
        }
        // create a new pagination adapter object
        $paginatorAdapter = $this->getPaginationAdapter($select);

        $paginator = new Paginator($paginatorAdapter);

        return $paginator;

    }

    protected function getPaginationAdapter($select)
    {
        if ($this->deriveResultSetPrototype) {
            $paginatorAdapter = new DbSelect(
                $select,
                $this->tableGateway->getAdapter(),
                $this->tableGateway->getResultSetPrototype()
            );            
        } else {
            $paginatorAdapter = new DbSelect(
                $select,
                $this->tableGateway->getAdapter()
            );             
        }

        return $paginatorAdapter;        
    }
    
}

