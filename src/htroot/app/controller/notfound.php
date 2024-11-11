<?php 
    class notfound extends controller{
        public function index(){
            session_start();
            $this->model("accesschecker");
            $ac = new accesschecker();
            if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
                //Logic if user is logged in
                define("ACTIVE_PAGE", "Oops");
                $this->view("inside/basics/header");
                $this->view("basics/404");
                $this->view("inside/basics/footer");
            }
            else{
                //Logic if user is not logged in
                define("ACTIVE_PAGE", "Oops");
                $this->view("basics/header");
                $this->view("basics/404");
                $this->view("basics/footer");
            }
        }
    }
?>