<?php

namespace HCommons\View\Helper;

use Zend\View\Helper\AbstractHelper;

class HPlugin extends AbstractHelper
{

    const DEFAULT_CSS_PATH = "public/css/";

    const DEFAULT_JS_PATH = "public/js/";

    protected $hPluginConfig;

    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config)
    {
        $this->hPluginConfig = $config;
    }

    public function loadPlugin($plugin_name, \Closure $jsCallback = null, \Closure $cssCallback = null)
    {
        foreach ($this->getPluginCss($plugin_name) as $name => $url) {
            if (!$cssCallback) {
                $this->getView()->headLink()->appendStylesheet($url);
            } else {
                $cssCallback($url, $name);
            }
        }

        foreach ($this->getPluginJs($plugin_name) as $name => $url) {
            if (!$jsCallback) {
                $this->getView()->inlineScript()->appendFile($url);
            } else {
                $jsCallback($url, $name);
            }
        }                      
       
    }

    public function getPluginJs($plugin_name)
    {
        $css_js = $this->hPluginConfig['plugins'][$plugin_name];
        if (isset($css_js["js"])) {
            $js_data = (array) $css_js["js"];
            $js_data = $this->normalizeJsFile($js_data);
            return $js_data; 
        }
            return array();     
    }

    public function getPluginCss($plugin_name)
    {
        $css_js = $this->hPluginConfig['plugins'][$plugin_name];
        if (isset($css_js["css"])) {
            $css_data = (array) $css_js["css"];
            $css_data = $this->normalizeCssFile($css_data);
            return $css_data; 
        }
        return array();
    }

    private function getCssPath()
    {
        return isset($this->hPluginConfig['css_path']) ? $this->getView()->basePath()."/".$this->hPluginConfig['css_path'] : self::DEFAULT_CSS_PATH;
    }

    private function getJsPath()
    {
        return isset($this->hPluginConfig['js_path']) ? $this->getView()->basePath()."/".$this->hPluginConfig['js_path'] : self::DEFAULT_JS_PATH;
    }

    private function normalizeCssFile($css_data)
    {
        return $this->normalizePath($css_data, $this->getCssPath());
    }

    private function normalizeJsFile($js_data)
    {
        return $this->normalizePath($js_data, $this->getJsPath());
    }

    private function normalizePath($paths, $default_path)
    {
        foreach ($paths as $name => $path) {
            if (substr($path,0,2) == "//" or substr($path,0,4) == 'http') {
                continue;
            }
            $paths[$name] = $default_path."/".$path;
        }
        return $paths;        
    }

}

