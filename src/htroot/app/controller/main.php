<?php
    class main extends controller{
        public function index(){
            define("ACTIVE_PAGE", "Home");
            $this->view("basics/header");
            $this->view("landing/home");
            $this->view("basics/footer");
        }

        public function processor(){
            switch($_POST['action']){
                case "signin":
                    $this->model('usermanager');
                    $model = new usermanager();
                    $model->signin();
                    break;

                case "signout":
                    $this->model('usermanager');
                    $model = new usermanager();
                    $model->signout();
                    break;

                case "autologin":
                    $this->model('usermanager');
                    $model = new usermanager();
                    $model->autologin();
                    break;
                }
        }

        public function postmanager(){
            session_start();
            switch ($_POST['action']) {
                case "newpost":
                    $this->model("accesschecker");
                    $ac = new accesschecker();
                    if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                        $this->model('postmanager');
                        $model = new postmanager();
                        $model->newpost();
                    }
                    else{
                        header("Location: /");
                    }
                    
                    break;

                case "newpostquill":
                    $this->model("accesschecker");
                    $ac = new accesschecker();
                    if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                        $this->model('postmanager');
                        $model = new postmanager();
                        $model->newpost(true);
                    }
                    else{
                        header("Location: /");
                    }
                    
                    break;

                case "fillPosts":
                    $this->model('postmanager');
                    $model = new postmanager();
                    $model->fillPosts();
                    break;
            }

            
        }
    }
?>