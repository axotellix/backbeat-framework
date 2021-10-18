<?php

namespace Backbeat;



// ---------- [ "BAMPLE" CLASS ] ---------- 

abstract class Bample {

    // [ PRESETS ]

    protected static $static = __DIR__ . '/bample.static.php';      //: static file path
    protected static $ctx    = '';                                  //: static file content

    // [ paths to files ]
    protected static $components = 'components/';   //: full path to components for prefixing includes



    // [ METHODS: helpers ]

    //@ init > constants
    protected static function initConst() {
        self::$components = make_path(self::$components, false);
    }



    // [ METHODS: Syntax processing ]

    //@ process > includes
    protected static function processIncludes( $ctx ) {

        while( strpos($ctx, '@component') > -1 ) {

            $param_start = strpos( $ctx , '@component(' ) + 12;
            $param_end   = strpos( $ctx , ')' , $param_start) - $param_start - 1;
            $param = substr( $ctx , $param_start, $param_end );
            $param = self::$components . $param . '.php';
            $param = '"' . $param . '"';
            $param = str_replace('\\', '/', $param);
            $ctx = preg_replace( "/@component(.*)/" , "<? require_once($param) ?>" , $ctx , 1);

        }

        return $ctx;
    }

    //@ replace > Bample syntax
    public static function processSyntax( $ctx ) {
        self::initConst();
        $ctx = self::processIncludes( $ctx );

        return $ctx;
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

        // replace > Bample syntax
        self::$ctx = self::processSyntax( self::$ctx );

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