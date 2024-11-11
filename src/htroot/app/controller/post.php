<?php
    class post extends controller{
        public function index($params = ""){
            if($params != ""){
                $this->model("publicuserdetails");
                $this->model("postmanager");
                
                session_start();
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                    define("ACTIVE_PAGE", "Post");
                    
                    $this->view("inside/basics/header");
                    $this->view("inside/basics/sidebar");
                    $this->view("inside/post", ["postid" => $params]);
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
                else{
                    define("ACTIVE_PAGE", "Post");
                    
                    $this->view("basics/header");
                    $this->view("inside/basics/sidebar_guest");
                    $this->view("inside/post", ["postid" => $params]);
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
            }
            else{
                header("Location: /notfound");
            }
        }

        public function processor(){
            switch ($_POST['action']) {
                case "getcomments":
                    $this->model("postmanager");
                    $model = new postmanager();
                    $model->getcomments();
                    break;

                case "newcomment":
                    $this->model("accesschecker");
                    $ac = new accesschecker();
                    if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                        $this->model("postmanager");
                        $model = new postmanager();
                        $model->newcomment();
                    }
                    else{
                        header("Location: /");
                    }
                    break;

                default:
                    break;
            }
        }
    }
?>