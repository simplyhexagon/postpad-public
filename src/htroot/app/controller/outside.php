<?php
    class outside extends controller{
        public function explore(){
            define("ACTIVE_PAGE", "Explore");
            $this->view("basics/header");
            $this->view("outside/explore");
            $this->view("basics/footer");
        }

        public function signup(){
            define("ACTIVE_PAGE", "Sign Up");
            $this->view("basics/header");
            $this->view("outside/signup");
            $this->view("basics/footer");
        }

        public function recover(){
            define("ACTIVE_PAGE", "Account recovery");
            $this->view("basics/header");
            $this->view("outside/recover");
            $this->view("basics/footer");
        }

        public function processor(){
            switch($_POST["action"]){
                case "usersignup":
                    $this->model("signup");
                    $model = new signupmodel();
                    $model->usersignup();
                    break;
            }
        }
    }
?>