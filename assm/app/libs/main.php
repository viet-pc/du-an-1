<?php
class main
{
    protected $controller = 'loi';
    protected $action = 'index';
    protected $params = array();
    function __construct()
    {
        include_once('load.php');
        include_once('database.php');
        include_once('defineURL.php');

        session_start();
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            $url = filter_var(trim($url, "/"));
            $url = explode("/", $url);
        }
        // xử lí controllers
        if (isset($url[0])) {
            if (file_exists("./app/controllers/" . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        } else {
            $this->controller = 'home';
        }
        require_once("./app/controllers/" .  $this->controller . ".php");
        $this->controller = new $this->controller;
        // xử lí accion
        if (isset($url[1])) {
            echo method_exists($this->controller, $url[1]);
            if (method_exists($this->controller, $url[1]) == 1) {
                $this->action = $url[1];
                unset($url[1]);
                // xử lí params
                $this->params = $url ? array_values($url) : [];
            } else {
                $this->controller = 'loi';
                require_once("./app/controllers/" .  $this->controller . ".php");
                $this->controller = new $this->controller;
            }
        }
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
}
