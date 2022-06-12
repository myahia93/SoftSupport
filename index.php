<?php
define('CONST_INCLUDE', NULL);
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>

    <link rel='stylesheet' type='text/css' media='screen' href='Css/style.css'>
    <link rel="icon" type="image/png" href="Resources/logo_transparent_notext.png">
    <!-- Bootstrap Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Jquery Script -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Chart Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

    <title>SoftSupport</title>
</head>

<body>

    <?php
    // Module initialization
    $module = isset($_GET['module']) ? $_GET['module'] : "home";
    ?>

    <!-- Navbar -->
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php?module=home">
                <img class="img-fluid" src="Resources/logo_transparent.png" alt="Logo du site" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav" id="navMenu">
                    <a class="nav-item nav-link <?php if ($module == "home") { ?>active<?php } ?>" href="index.php?module=home">Home</a>
                    <a class="nav-item nav-link <?php if ($module == "tickets") { ?> active <?php } ?>" href="index.php?module=tickets">Tickets</a>
                    <a class="nav-item nav-link <?php if ($module == "projects") { ?> active <?php } ?>" href="index.php?module=projects">Projects</a>
                    <a class="nav-item nav-link <?php if ($module == "customers") { ?> active <?php } ?>" href="index.php?module=customers">Customers</a>
                    <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) { ?>
                        <a class="nav-item nav-link <?php if ($module == "users") { ?> active <?php } ?>" href="index.php?module=users">Users</a>
                    <?php }  ?>
                    <a class="nav-item nav-link <?php if ($module == "stats") { ?> active <?php } ?>" href="index.php?module=stats">Statistics</a>
                </div>
                <div class="navbar-nav" id="navlogin">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <!-- Logged in -->
                        <a class="nav-item nav-link active" href="#"><?php echo $_SESSION['first_name']; ?> <span id="lastName"><?php echo $_SESSION['last_name']; ?></span></a>
                        <a class="nav-item nav-link" href="logoutModal" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    <?php } else { ?>
                        <!-- Logged out -->
                        <a class="nav-item nav-link active" href="index.php?module=connection&action=form_login">Login</a>
                    <?php }  ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to log out?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger"><a id="logoutLink" href="index.php?module=connection&action=logout">Log out</a></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container main">
        <?php

        // redirection to the current module

        switch ($module) {
            case 'home':
            case 'connection':
            case 'users':
            case 'customers':
            case 'projects':
            case 'tickets':
            case 'stats':
                include_once "Modules/mod_$module/Mod$module.php";
                include_once "conf_database/authDatabase.php";
                break;
            default:
                die("unauthorized access");
        }

        $class = "Mod" . $module;
        $mod = new $class();
        ?>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4">
                    <h5 class="footerTitle text-uppercase">Contact</h5>
                    <ul class="list-unstyled">
                        <li>
                            <p>Email : mohcine.yahia@efrei.net</p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footerTitle text-uppercase">Helpful Links</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="index.php?module=tickets">Tickets</a>
                        </li>
                        <li>
                            <a href="index.php?module=projects">Projects</a>
                        </li>
                        <li>
                            <a href="index.php?module=customers">Customers</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footerTitle text-uppercase">About us</h5>
                    <ul class="list-unstyled">
                        <li>
                            <p>A web site by Efrei Paris</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="copyright">
            <div class="content mx-auto">
                <h6>© SoftSupport <?php echo date('Y'); ?></h6>
                <a href="index.php?module=home"><img class="img-fluid" src="Resources/logo_transparent.png" alt="SoftSupport Logo without text" /></a>
            </div>
        </div>
    </footer>

</body>


</html>