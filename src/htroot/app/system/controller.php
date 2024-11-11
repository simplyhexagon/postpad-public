<?php
    class controller{
        public function view($view, $params = []){
            require_once "app/system/global_vars.php";
            require_once "app/view/{$view}.php";
        }
        public function model($model){
            require_once "app/model/{$model}.php";
        }
    }
?>