<?php

namespace HCommons\Entity;

interface AbstractEntityInterface
{
    public function exchangeArray($data);

    public function getData();

    public function getArrayCopy();

}
