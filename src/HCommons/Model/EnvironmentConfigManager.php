<?php
    
namespace HCommons\Model;

class EnvironmentConfigManager
{
    const ENV_PRODUCTION = "production";

    const ENV_DEVELOPMENT = "development";

    protected static $env;
    
    protected static $isDevelopment = null;

    protected static $allowedEnviroments = array(
        self::ENV_PRODUCTION,
        self::ENV_DEVELOPMENT
    );

    public static function getEnv()
    {
        if (!self::$env) {
            $env = getenv('APP_ENV');
            if (!$env) {
                $env = getenv('APPLICATION_ENV') ?: self::ENV_PRODUCTION;
            }
            if (!in_array($env, self::$allowedEnviroments)) {
                throw new \Exception("Unknown application Environment variable");
            }
            self::$env = $env;            
        }
        return self::$env;
    }

    public static function isProduction()
    {
        return !self::isDevelopment();
    }

    public static function isDevelopment()
    {
        if (self::$isDevelopment === null) {
            self::$isDevelopment = (self::getEnv() == self::ENV_DEVELOPMENT);
        }
        return self::$isDevelopment;
        //return strtolower(self::getEnv()) == strtolower(self::ENV_DEVELOPMENT);
    }

}
