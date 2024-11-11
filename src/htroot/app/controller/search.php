<?php
    class search extends controller{
        public function index($params = ""){
            if($params == ""){
                session_start();
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                    define("ACTIVE_PAGE", "Search");
                    
                    $this->view("inside/basics/header");
                    $this->view("inside/basics/sidebar");
                    $this->view("search/home");
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
                else{
                    header("Location: /");
                }
            }
        }

        public function user(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                $this->model("searchmodel");
                $model = new searchmodel();
                $model->usersearch();
            }
            else{
                $response = Array(
                    "response" => "no_access"
                );

                echo json_encode($response);
            }
        }
        
        public function posts(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                $this->model("searchmodel");
                $model = new searchmodel();
                $model->postsearch();
            }
            else{
                $response = Array(
                    "response" => "no_access"
                );

                echo json_encode($response);
            }
        }
    }
?>