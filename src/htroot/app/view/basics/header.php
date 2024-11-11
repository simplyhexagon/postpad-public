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
    <link rel="stylesheet" href="/public/dist/bootstrap/css/bootstrap.min.css">
    <script src="/public/dist/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- FontAwesome 6.4.2 -->
    <link rel="stylesheet" href="/public/dist/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/public/dist/fontawesome/css/solid.min.css">
    <script src="/public/dist/fontawesome/js/fontawesome.min.js"></script>

    <link rel="stylesheet" href="/public/res/style.css">

    <title><?php echo APP_NAME . ' - ' . ACTIVE_PAGE; ?></title>
    <link rel="icon" type="image/x-icon" href="/public/res/img/favicon.ico">
</head>
<body class="text-white">
    <!-- Add this code to your HTML body -->
    <nav class="navbar customnavbar fixed-bottom navbar-expand-sm navbar-dark d-md-none">
        <!-- Navbar content for mobile devices goes here -->
        <ul class="navbar-nav flex-row justify-content-around w-100">
            <li class="nav-item">
                <a class="nav-link flex-fill" href="/"><i class="fa-solid fa-house"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link flex-fill" href="/outside/explore"><i class="fa-solid fa-comments"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link flex-fill" href="/documents"><i class="fa-solid fa-file"></i></a>
            </li>
        </ul>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark customnavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img class="brandicon" src="/public/res/img/appicon.png" alt="" srcset="">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/outside/explore">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a href="/documents" class="nav-link">Documents</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <section class="content">
        <div class="container">
            <div class="row justify-content-center">







    
    