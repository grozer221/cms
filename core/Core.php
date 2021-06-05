<?php


namespace core;

/**
 * Головний клас ядра системи
 * (синглтон)
 */
class Core
{
    private static $instance;
    private function __construct()
    {

    }
    /**
     * Повертає екземпляр ядра системи
     * @return Core
     */
    public static function getInstance()
    {
        if (empty(self::$instance)){
            self::$instance = new Core();
            return self::getInstance();
        }
        else
            return self::$instance;
    }
    /**
     * Ініціалізація системи
     */
    public function init()
    {
        session_start();
        spl_autoload_register('\core\Core::__autoload');
    }
    /**
     * Виконує основний процес роботи CMS-системи
     */
    public  function run()
    {
        $path = $_GET['path'];
        $pathParts = explode('/', $path);
        $className = ucfirst($pathParts[0]);
        if(empty($className))
            $fullClassName = 'controllers\\Site';
        else
            $fullClassName = 'controllers\\'.$className;
        $methodName = ucfirst($pathParts[1]);
        if(empty($methodName))
            $fullMethodName = 'actionIndex';
        else
            $fullMethodName = 'action'.$methodName;
        if(class_exists($fullClassName)) {
            $controller = new $fullClassName();
            if (method_exists($controller, $fullMethodName))
                $controller->$fullMethodName();
            else
                throw new \Exception('404 Not Found');
        }
        else
            throw new \Exception('404 Not Found');
        //echo "Class : {$className}, method : {$fullMethodName}";
    }
    /**
     * Автозавантажувач класів
     * @param $className string Назва класу
     */
    public static function __autoload($className)
    {
        $fileName = $className.'.php';
        if(is_file($fileName))
            include($fileName);
    }
}