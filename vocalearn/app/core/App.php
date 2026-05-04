<?php
class App {
    protected $currentController = 'Home'; // Mặc định vào trang Home
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getUrl();

        // Check controller
        if(file_exists('../app/controllers/' . ucwords($url[0])) . '.php'){
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check method
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Params
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return ['home']; // Mặc định
    }
}