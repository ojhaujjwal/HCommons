<?php
    
namespace HCommons\Model;

class EnvironmentConfigManager
{
    const ENV_PRODUCTION = "production";

    const ENV_DEVELOPMENT = "development";

    protected $env;

    protected $allowedEnviroments = array(
        self::ENV_PRODUCTION,
        self::ENV_DEVELOPMENT
    );

    public function getEnv()
    {
        if (!$this->env) {
            $env = getenv('APP_ENV');
            if (!$env) {
                $env = getenv('APPLICATION_ENV') ?: self::ENV_PRODUCTION;
            }
            if (!in_array($env, $this->allowedEnviroments)) {
                throw new \Exception("Unknown application Environment variable");
            }
            $this->env = $env;            
        }
        return $this->env;
    }

    public function isProduction()
    {
        return !$this->isDevelopment();
    }

    public function isDevelopment()
    {
        return strtolower($this->env) == strtolower(self::ENV_DEVELOPMENT);
    }

}
