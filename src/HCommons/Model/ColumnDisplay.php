<?php
    
namespace HCommons\Model;

abstract class ColumnDisplay
{
    abstract public function getColumnsDisplay();

    public function getColumnDisplay($column)
    {
        return $this->getColumnsDisplay()[$column];
    }

}
