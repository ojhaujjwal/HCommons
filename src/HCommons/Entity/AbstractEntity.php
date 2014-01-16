<?php

namespace HCommons\Entity;

abstract class AbstractEntity implements AbstractEntityInterface
{

    /*
    **  @param array $data
    **  contains data that are directly related to the table
    **  @key contains column name && value contains respective column value
    */
    protected $data = array();


    /*
    **  @param array $exData (garbage data)
    **  contains data that are not related the table
    */
    protected $exData;

    public function exchangeArray($data)
    {
        $fields = $this->getFields();
        foreach ($data as $key => $value) {
            if (in_array($key, $fields)) {
                $fname = 'set'.str_replace(" ","",ucwords(str_replace("_"," ",$key)));
                if (method_exists($this, $fname)) {
                    call_user_func_array(array($this, $fname), array($value));
                } else {
                    $this->data[$key] = $value;    
                }
                
            } else {
                $this->exData[$key] = $value;    
            }
        }
    }


    public function getData(){
        return $this->data;
    }

    public function getArrayCopy()
    {
        return $this->getData();
    }

    public function getExData()
    {
        return $this->exData;
    }

    public function __call($name, $arguments)
    {
        $getter = preg_match('/^get/', $name);
        $setter =  preg_match('/^set/', $name);
        if (!$getter && !$setter) {
            throw new \BadMethodCallException('Unknown method,'. $name);
        }
        $field_name = $this->getFieldName($name);
        if ($setter) {
            $this->$field_name = $arguments[0];
        } else {
            return $this->$field_name;
        }
    }

    protected function getFieldName($method)
    {
        $transform = function ($letters) {
            $letter = array_shift($letters);

            return '_' . strtolower($letter);
        };
        //if (preg_match('/^get/', $method) or preg_match('/^set/', $method)) {
            $attribute = substr($method, 3);
            $attribute = lcfirst($attribute);
            $attribute = preg_replace_callback('/([A-Z])/', $transform, $attribute);
            return $attribute;
        //}    
    }

    public function __get($field)
    {
        if(!in_array($field, $this->getFields())) {
            throw new Exception\InvalidColumnException(sprintf("Column, %s does not exists!", $field));
        }

        if (array_key_exists($field, $this->data)) {
            return $this->data[$field];
        } elseif (array_key_exists($name, $this->exData)) {
            return $this->exData[$name];
        } 

        return null;         
    }

    public function __set($name,$value)
    {
        $this->exchangeArray(array($name => $value));
    }


    abstract public function getFields();

}

