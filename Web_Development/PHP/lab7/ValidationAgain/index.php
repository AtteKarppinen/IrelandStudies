<?php
    require_once 'Model/model.php';
    require_once 'Controller/controller.php';
    
    $model      = new Model();
    $controller = new Controller($model);
    
    if (isset($_POST)) {
        $controller->insertUserInfo();
    }
    else {
        $controller->showForm();
    }
    
?>