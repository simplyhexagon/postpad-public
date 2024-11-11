<?php
    //This part is required so the framework can actually load shit
    #[AllowDynamicProperties]
    class AppCore{
        protected $controller = "main";
        protected $function = "index";
        protected $params = [];

        public function __construct(){
            $url = $this->parseurl();

            if($url != NULL){
                if(file_exists("app/controller/{$url[0]}.php")){
                    $this->controller = $url[0];
                    unset($url[0]);
                }
                else{
                    $this->controller = "notfound";
                    $this->function = "index";
                }
            }
            require_once "app/controller/{$this->controller}.php";

            $this->controller = new $this->controller;

            if(isset($url[1])){
                if(method_exists($this->controller, $url[1])){
                    $this->function = $url[1];
                    unset($url[1]);
                }
            }

            $this->params = $url ? array_values($url) : [];
			call_user_func_array([$this->controller, $this->function], $this->params);
        }

        protected function parseurl(){
            if(isset($_GET['url'])){
                $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
                return $url;
            }
        }
    }
?>