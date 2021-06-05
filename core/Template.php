<?php


namespace core;


/**
 * Клас шаблонізатора
 * @package core
 */
class Template
{
    protected $parameters;
    public function __construct()
    {
        $this->parameters=[];
    }
    public function setParam($name, $value)
    {
        $this->parameters[$name] = $value;
    }
    public function getParam($name)
    {
        return $this->parameters[$name];
    }
    public function setParams($array)
    {
        foreach ($array as $key => $value)
        $this->parameters[$key] = $value;
    }
    public function render($path)
    {
        extract($this->parameters);
        ob_start();
        include($path);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    public function display($path)
    {
        echo $this->render($path);
    }



}