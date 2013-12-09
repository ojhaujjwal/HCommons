<?php

namespace HCommons\Model;

class DbResultSetToArray
{
    public static function toArray($resultSet, $exData = false)
    {
        $array = array();
        foreach ($resultSet as $row) {
            if (is_array($row)) {
                $array[] =  $row;
            } elseif ($exData && method_exists($row, 'getExData') && method_exists($row, 'getArrayCopy')) {
                $array[] =  array_merge($row->getArrayCopy(), $row->getExData());
            } elseif (method_exists($row, 'getArrayCopy')) {
                $array[] =  $row->getArrayCopy();
            } else {
                $array[] = get_object_vars($row);
            }
            
        }
        return $array;
    }

    public static function toColumn($resultSet, $column = null , $exData = false)
    {
        if ($resultSet instanceof \Traversable) {
             $array = self::toArray($resultSet, $exData);
        } else {
            $array = $resultSet;
        }
       
        //print_r($array);
        $result = array();
        foreach ($array as $row) {
            if ($column) {
                $result[] = $row[$column];
            } else {
                $result[] = reset($row);
            }
        }
        return $result;
    }
}

