<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery -->
    <script src="/public/res/script/jquery.min.js"></script>

    <!-- Popper -->
    <script src="/public/res/script/popper.min.js"></script>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="/public/dist/bootstrap/css/bootstrap.css">
    <script src="/public/dist/bootstrap/js/bootstrap.min.js"></script>

    <!-- FontAwesome 6.4.2 -->
    <link rel="stylesheet" href="/public/dist/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/public/dist/fontawesome/css/solid.min.css">
    <script src="/public/dist/fontawesome/js/fontawesome.min.js"></script>

    <link rel="stylesheet" href="/public/res/style.css">
    
    <title><?php echo APP_NAME . ' - ' . ACTIVE_PAGE; ?></title>
    <link rel="icon" type="image/x-icon" href="/public/res/img/favicon.ico">
</head>

<?php
    error_reporting(E_ALL & ~E_NOTICE);
    //Page compositor model comes here
    //Function that returns an array to fill certain elements comes here
    $this->model("userdetailfactory");
    $factory = new userdetailfactory();
    $factory->setuserdata();
    session_start();
?>

<body class="text-white" id="topOfPage">
    <!-- Add this code to your HTML body -->
    <nav class="navbar customnavbar fixed-bottom navbar-expand-sm navbar-dark d-md-none">
    <!-- Navbar content for mobile devices goes here -->
    <ul class="navbar-nav flex-row justify-content-around w-100 text-center">
        <li class="nav-item">
            <?php
                if($_SERVER["REQUEST_URI"] == "/home"){
                
            ?>
                <a class="nav-link flex-fill" href="#topOfPage" onclick="resetPosts()"><i class="fa-solid fa-house"></i></a>
            <?php 
                }
                else{
            ?>
                <a class="nav-link flex-fill" href="/home" ><i class="fa-solid fa-house"></i></a>
            <?php
                }
            ?>
        </li>
        <li class="nav-item">
            <a class="nav-link flex-fill" href="/settings"><i class="fa-solid fa-user-gear"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </li>
    </ul>
    </nav>
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">