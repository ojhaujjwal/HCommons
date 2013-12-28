<?php
    
namespace HCommons\Image;

interface ManipulatingInterface
{
    public function setOptions(array $options);

    public function getPhpThumb();

    public function setImagepath($imagePath);

    public function getImagePath();

    public function setSave($save = true);

    public function getSave();    
}
