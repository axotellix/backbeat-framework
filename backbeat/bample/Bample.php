<?php

namespace Backbeat;



// ---------- [ "BAMPLE" CLASS ] ---------- 

abstract class Bample {

    // [ PRESETS ]

    protected static $static = __DIR__ . '/bample.static.php';      //: keep > static file path
    protected static $ctx    = '';                                  //: keep > static file content



    // [ METHODS: helpers ]

    //@ replace > Bample syntax
    protected static function processSyntax( $ctx ) {

    }



    // [ METHODS ]

    //@ set > active page ( replace content of bample.static.php )
    public static function setStatic( $view ) {

        // get > requested page content
        self::$ctx = file_get_contents( $view );

        // get > requested page full path
        $path = explode('/', $view);
        array_pop($path);                       // remove > filename from URL
        $path = implode('/', $path);
        $path = str_replace('\\', '/', $path);
        $path = '"' . $path . '"';

        // replace > DIR constants ( change static file location to requested page`s one )
        self::$ctx = preg_replace( '/__DIR__/' , $path , self::$ctx );

        // save > new content to static file
        file_put_contents( self::$static , self::$ctx );
    }


    //@ require > static file
    public static function requireStatic() {
        require_once( self::$static );
    }

}



    // function Bample() {

    //     $caller = debug_backtrace()[0]['file'];
    //     $ctx = file_get_contents( $caller );

    //     $caller = str_replace( 'index.php' , 'app\MVC\views\pages\about.php' , $caller );
    //     str_replace( 'simple' , 'cool' , $ctx );

    //     ob_start();
    //     //require_once $caller;
    //     echo ob_get_clean();

    // }

?>