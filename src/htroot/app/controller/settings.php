<?php
    class settings extends controller{
        public function index(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                define("ACTIVE_PAGE", "Settings");
                $this->model("userdetailfactory");
                $this->view("inside/basics/header");
                $this->view("inside/settings");
                $this->view("inside/basics/footer");
            }
            else{
                header("Location: /");
            }
        }

        public function processor(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                switch($_POST['action']){
                    case "savechanges":
                        $this->model("settings");
                        $model = new settingsmodel();
                        $model->savechanges();
                        break;
                    case "queryactivesessions":
                        $this->model("settings");
                        $model = new settingsmodel();
                        $model->queryactivesessions();
                        break;
                    case "logoutsession":
                        $this->model("settings");
                        $model = new settingsmodel();
                        $model->logoutsession();
                        break;
                    case "logouteverysession":
                        $this->model("settings");
                        $model = new settingsmodel();
                        $model->logouteverysession();
                        break;
                    case "getnewprofilepic":
                        $this->model("settings");
                        $model = new settingsmodel();
                        $model->getnewprofilepic();
                        break;
                }
            }
            else{
                header("Location: /");
            }
        }
    }
?>