<?php
    
namespace HCommons\Model;

class EnvironmentConfigManager
{
    const ENV_PRODUCTION = "production";

    const ENV_DEVELOPMENT = "development";

    protected static $env;

    protected static $allowedEnviroments = array(
        self::ENV_PRODUCTION,
        self::ENV_DEVELOPMENT
    );

    public function getEnv()
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

    public function isProduction()
    {
        return !self::isDevelopment();
    }

    public function isDevelopment()
    {
        return strtolower(self::$env) == strtolower(self::ENV_DEVELOPMENT);
    }

}