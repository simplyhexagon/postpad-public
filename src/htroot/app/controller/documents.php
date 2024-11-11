<?php
    class documents extends controller{

        public function index(){
            define("ACTIVE_PAGE", "Documents");
            $this->view("basics/header");
            $this->view("documents/home");
            $this->view("basics/footer");
        }

        public function tos(){
            define("ACTIVE_PAGE", "Terms of Service");
            $this->view("basics/header");
            $this->view("documents/tos");
            $this->view("basics/footer");
        }

        public function privacy(){
            define("ACTIVE_PAGE", "Privacy Policy");
            $this->view("basics/header");
            $this->view("documents/privacy");
            $this->view("basics/footer");
        }

        public function guidelines(){
            define("ACTIVE_PAGE", "Community Guidelines");
            $this->view("basics/header");
            $this->view("documents/guidelines");
            $this->view("basics/footer");
        }

        public function whistleblower(){
            define("ACTIVE_PAGE", "Whistleblower's clause");
            $this->view("basics/header");
            $this->view("documents/whistleblower");
            $this->view("basics/footer");
        }
    }
?>