<?php
    class user extends controller{
        public function index($params = ""){
            if($params != ""){
                $this->model("publicuserdetails");
                session_start();
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                    define("ACTIVE_PAGE", $params);
                    
                    $this->view("inside/basics/header");
                    $this->view("inside/basics/sidebar");
                    $this->view("inside/user", ["user" => $params]);
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
                else{
                    define("ACTIVE_PAGE", $params);
                    
                    $this->view("basics/header");
                    $this->view("inside/basics/sidebar_guest");
                    $this->view("inside/user", ["user" => $params]);
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
            }
            else{
                header("Location: /notfound");
            }
        }

        public function processor(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                switch($_POST['action']){
                    case "a":
                        /*$this->model("usermanager");
                        $model = new usermanager();
                        $model->savechanges();*/
                        break;
                }
            }
            else{
                header("Location: /");
            }
        }
    }
?>