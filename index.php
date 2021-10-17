<?php

    namespace Backbeat;

    // autoload > dependencies (classes)
    // spl_autoload_register(function ($class) {
    //     $path = str_replace( '\\', '/', $class . '/Route.php');
    //     echo "path: $path <br>";
    //     include $path;
    // });

    require_once('app/MVC/controllers/HomeController.php');
    require_once('backbeat/Route/Route.php');
    require_once('app/routes.php');

    // check > if requested View NOT found
    check_404();


?>