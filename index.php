<?php

    namespace Backbeat;
    use Backbeat\Bample;

    // autoload > dependencies (classes)
    // spl_autoload_register(function ($class) {
    //     $path = str_replace( '\\', '/', $class . '/Route.php');
    //     echo "path: $path <br>";
    //     include $path;
    // });

    require_once('backbeat/bample/Bample.php');
    require_once('app/MVC/controllers/HomeController.php');
    require_once('backbeat/Route/Route.php');
    require_once('app/routes.php');
    
    // check > if requested View NOT found
    check_404();

    // require > static file ( page container )
    Bample::requireStatic();


?>