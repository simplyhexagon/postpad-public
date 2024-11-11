<?php
    class home extends controller{

        public function index(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                define("ACTIVE_PAGE", "Home");
                $this->view("inside/basics/header");
                $this->view("inside/basics/sidebar");
                $this->view("inside/home");
                $this->view("inside/basics/trending");
                $this->view("inside/basics/footer");
            }
            else{
                header("Location: /");
            }
        }
    }
?>