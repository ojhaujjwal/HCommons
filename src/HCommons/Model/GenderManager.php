<?php

namespace HCommons\Model;

class GenderManager
{
    const GENDER_MALE = 1;

    const GENDER_FEMALE = 0;

    public static function getGenderCode($gender)
    {
        switch(strtolower($gender))
        {
            case 'male':
                return self::GENDER_MALE;
            case 'female':
                return self::GENDER_FEMALE;
            default:
                throw new \Exception('Unsupported Gender!');
        }
    }

    public static function getGenderDisplay($gender)
    {
        switch($gender)
        {
            case self::GENDER_MALE:
                return 'Male';
            case self::GENDER_FEMALE:
                return 'Female';
            default:
                throw new \Exception('Unsupported Gender!');
        }        
    }

}

