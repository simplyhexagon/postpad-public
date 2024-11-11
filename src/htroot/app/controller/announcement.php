<?php
    class announcement extends controller{
        public function index($params = ""){
            if($params != ""){
                session_start();
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                    define("ACTIVE_PAGE", "Announcement");
                    
                    $this->view("inside/basics/header");
                    $this->view("inside/basics/sidebar");
                    $this->view("announcement/home", ["announceid" => $params]);
                    $this->view("inside/basics/trending");
                    $this->view("inside/basics/footer");
                }
                else{
                    define("ACTIVE_PAGE", "Announcement");
                    
                    $this->view("basics/header");
                    $this->view("inside/basics/sidebar_guest");
                    $this->view("announcement/home", ["announceid" => $params]);
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
                case "getLatest":
                    $this->model("announcement");
                    $model = new announcementModel();
                    $model->getLatest();
                    break;
                default:
                    break;
            }
        }
    }
?>