<?php
class App {
    protected $controller = 'LoginController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        // Soporte para ?controller=...&action=...&id=...
        $controllerName = $this->controller;
        if (isset($_GET['controller'])) {
            $controller = ucfirst($_GET['controller']) . 'Controller';
            if (file_exists(__DIR__ . '/../controllers/' . $controller . '.php')) {
                $controllerName = $controller;
            }
        }
        require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
        $this->controller = new $controllerName;

        if (isset($_GET['action']) && method_exists($this->controller, $_GET['action'])) {
            $this->method = $_GET['action'];
        }

        // Si hay parámetro id, pásalo como argumento
        if (isset($_GET['id'])) {
            $this->params[] = $_GET['id'];
        }

        // Si no, usa el ruteo por url amigable
        if (!isset($_GET['controller']) && !isset($_GET['action'])) {
            $url = $this->parseUrl();
            if ($url && isset($url[0]) && file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
                $controllerName = $url[0];
                unset($url[0]);
            }
            require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
            $this->controller = new $controllerName;
            if(isset($url[1])) {
                if(method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
            $this->params = $url ? array_values($url) : [];
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
