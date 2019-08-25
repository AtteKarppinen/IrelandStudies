<?php
    class Controller {
        private $model;

        public function __construct($model) {
            $this->model = $model;
        }

        public function showForm() {
            include_once 'view.php';    // Show when page loads the first time
        }

        public function insertUserInfo() {
            $result = $this->model->insertUserInfo();

            if ($result) {
                echo 'USER INSERTED SUCCESSFULLY!';
            }
            else {
                // Everything declared here before include will get passed to included file
                $formError  = $this->model->formError;
                $name       = $this->model->name;
                $email      = $this->model->email;
                $dob        = $this->model->dob;
                $addr1      = $this->model->addr1;
                $city       = $this->model->city;
                $zip        = $this->model->zip;
                include_once 'view.php';
            }
        }
    }
?>