<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 20.06.2019
 * Time: 11:59
 */

class App {

    protected $controller = 'IndexController';
    protected $method = 'Index';
    protected $params = [];

    public $isPost = false;
    public $isGet = false;
    public $isAJAX = false;

    public function __construct()
    {
        $url = $this->parseUrl();

        if(isset($url[0]) && file_exists("../app/controllers/{$url[0]}Controller.php"))
        {
            $this->controller = "{$url[0]}Controller";
            unset($url[0]);
        }

        require_once "../app/controllers/{$this->controller}.php";
        $this->controller = new $this->controller($this);

        if(isset($url[1]) && method_exists($this->controller,$url[1]))
        {
            $this->method=$url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url):[];

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $this->isAJAX=true;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->isPost=true;
        }
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $this->isGet=true;
        }

        session_start();
        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    private function parseUrl()
    {
        if(isset($_GET['url']))
        {
           return $url = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
        }
        return [];
    }
}