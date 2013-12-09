<?php
    
namespace HCommons\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression as SqlExpression;
use HCommons\Entity\AbstractEntityInterface; 

class AbstractMapper
{
    protected $tableGateway;

    protected $idColumn = "id";

    protected $nameColumn = 'name';

    public function setTableGateway(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function fetchAll($columns = NULL, \Closure $anonymous = null)
    {
        if (!$columns && !$anonymous) {
            $resultSet = $this->tableGateway->select();    
        } else {
            
            $resultSet = $this->tableGateway->select(function (Select $select) use ($columns, $anonymous) {
                
                if ($columns) {
                    $columns = (array) $columns;
                    $select->columns($columns);
                }
                if ($anonymous) {
                     $anonymous($select);
                 }
            });              
        }
        
        return $resultSet;
    }

    public function listColumn($column)
    {
        $data = array();
        $resultSet = $this->fetchAll(array($column));
        foreach($resultSet as $result) {
            $data[] = $result->$column;
        }
        return $data;
    }


    protected function findByColumn($column, $value, $columns = null)
    {
        if (!$columns) {
            $rowset = $this->tableGateway->select(array($column => $value));    
        } else {
            $columns = (array) $columns;
            $rowset = $this->tableGateway->select(function (Select $select) use ($value, $columns) {
                 $select->columns($columns)->where(array($column => $value));
            });            
        }
        return $rowset;      
    }

    protected function findRowByColumn($column, $value, $columns = null)
    {
        $rowset = $this->findByColumn($column, $value, $columns = null);
        $row = $rowset->current();
        return $row; 
    }

    public function getRow($id, $columns = NULL)
    {
        return $this->findById($id, $columns);    
    }

    public function findById($id, $columns)
    {
        $id = (int) $id;
        return $this->findRowByColumn($this->idColumn, $id, $columns); 
    }

    public function getRowArray($id, $columns)
    {
        $row = $this->getRow($id, $columns);
        return $row->getArrayCopy();
    }

    public function getValue($id, $column)
    {
        $row = $this->getRow($id, array($column));
        return $row->$column;
    }

    public function getName($id)
    {
        return $this->getValue($id, $this->nameColumn);
    }

    public function delete($id)
    {
        if ($id instanceof AbstractEntityInterface) {
            $id = $id->{$this->idColumn};
        } elseif (!is_string($id) and !is_int($id)) {
            throw new InvalidArgumentException(sprintf("%s expected parameter 1 to be id or an instance of HCommons\Entity\AbstractEntityInterface", __METHOD__));
        }
        $id = (int) $id;
        $this->tableGateway->delete(array($this->idColumn => $id));
    }

    public function saveData($ArrayObjectPrototype)
    {
        if (is_object($ArrayObjectPrototype) && $ArrayObjectPrototype instanceof AbstractEntityInterface) {
            $data = $ArrayObjectPrototype->getArrayCopy();    
        } elseif(is_array($ArrayObjectPrototype)) {
            $data = $ArrayObjectPrototype;
        } else {
            throw new \InvalidArgumentException('Exected parameter 1 to be array or instance of AbstractEntityInterface! ');
        }
        $id = $data[$this->idColumn];
        if ($id == 0) {
             $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, array($this->idColumn => $id));
        }
    }

    public function getInsertId()
    {
        return $this->tableGateway->lastInsertValue;
    }

    public function getSelectOptions($key = null, $value = null, \Closure $anonymous = null)
    {
        if (!$key) {
            $key = $this->idColumn;
        }
        if (!$value) {
            $value = $this->nameColumn;
        }
        if ($anonymous) {
            $results = $this->fetchAll(array($key, $value), $anonymous);
        } else {
            $results = $this->fetchAll(array($key, $value));
        }
        $options = array();
        foreach($results as $result)
        {
            $array =  $result->getArrayCopy();
            $options[$array[$key]] = $array[$value];
        }

        return $options;

    }

    public function count(\Closure $Closure = null) {
        $resultSet = $this->getTableGateway()->select(function(Select $select) use ($Closure) {
            $select->columns(array('num' => new SqlExpression('COUNT(*)')));
            if ($Closure) {
                $Closure($select);
            }
        });
        $row = $resultSet->current();
        return $row->num;
    }
    
}
