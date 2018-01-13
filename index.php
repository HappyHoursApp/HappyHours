<?php
    session_start();
    //referencing my autoloader and retrieving our router
    require_once 'vendor/autoload.php';
    $f3 = require_once 'vendor/bcosca/fatfree-core/base.php';

    //error handling
    $f3->set('DEBUG', 3);

    //define our routes
    //route for index
    $f3->route('GET /', function($f3) {
        $controller = new Controller($f3);
        $controller->home();
    });

    //route for home
    $f3->route('GET /home', function($f3) {
        $controller = new Controller($f3);
        $controller->home();
    });

    //route for dashboard
    $f3->route('GET|POST /dashboard', function($f3) {
        $controller = new Controller($f3);
        $controller->dashboard();
    });

    //route for about
    $f3->route('GET /about', function($f3) {
        $controller = new Controller($f3);
        $controller->about();
    });

    //route for the login page
    $f3->route('GET|POST /login', function($f3) {
        $controller = new Controller($f3);
        $controller->login();
    });

    //route to logout
    $f3->route('GET /logout', function($f3) {
        $controller = new Controller($f3);
        $controller->logout();
    });

    //route for the sign up page
    $f3->route('GET|POST /signup', function($f3) {
        $controller = new Controller($f3);
        $controller->signup();
    });    

    //route for the confirmation page
    $f3->route('GET /confirmation', function($f3) {
        $controller = new Controller($f3);
        $controller->confirmation();
    });

    //route for profile page
    $f3->route('GET /meet/@id', function($f3, $params) {
        $controller = new Controller($f3);
        $controller->page($params['id']);
    });

    //route for hiding a profile (Only logged in admin should be able to click this)
    $f3->route('GET /hide/@id', function($f3, $params) {
        $controller = new Controller($f3);
        $controller->hide($params['id']);
    });

    //route for approving a profile (Only logged in admin should be able to click this)
    $f3->route('GET /show/@id', function($f3, $params) {
        $controller = new Controller($f3);
        $controller->show($params['id']);
    });
    
    //route for wiping a user (Only logged in admin should be able to click this)
    $f3->route('GET /eliminate/@id', function($f3, $params) {
        $controller = new Controller($f3);
        $controller->eliminate($params['id']);
    });

    //route for archiving a profile (Only logged in admin should be able to click this)
    $f3->route('GET /archive/@id', function($f3, $params) {
        $controller = new Controller($f3);
        $controller->archive($params['id']);
    });

    $f3->run();
?>
