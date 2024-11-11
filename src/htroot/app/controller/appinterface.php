<?php
    class appinterface extends controller{
        public function hsvizu(){
            $this->model("iflogic");
            $model = new iflogic();
            if($model->accessCheck()){
                switch($_POST['ifaction']){
                    case "apitest":
                        $response = Array(
                            "called" => "apitest",
                            "response" => "ok"
                        );
                        echo json_encode($response);
                    break;
                    case "explorepage":
                        $response = Array(
                            "called" => "explorepage",
                        );

                        if(isset($_POST["offset"])){
                            $this->model("postmanager");
                            $postsmodel = new postmanager();
                            $reply = $postsmodel->fillPosts_API();
                        }
                        
                        $response = $response + $reply;
                        echo json_encode($response);
                        break;

                }
            }
            else{
                $response = Array(
                    "called" => $_POST["ifaction"],
                    "response" => "denied"
                );
                echo json_encode($response);
                return;
            }
            
        }
    }
?>