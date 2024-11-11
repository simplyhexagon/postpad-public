<?php
    class logout extends controller{
        public function index(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                define("ACTIVE_PAGE", "Signing out...");
                $this->model('usermanager');
                $model = new usermanager();
                $model->signout();
            }
            else{
                header("Location: /");
            }
        }
    }
?>