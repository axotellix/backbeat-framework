<?php

namespace Backbeat;



// ---------- [ "BAMPLE" CLASS ] ---------- 

abstract class Bample {

    // [ PRESETS ]

    protected static $static = __DIR__ . '/bample.static.php';      //: static file path
    protected static $ctx    = '';                                  //: static file content

    // [ paths to files ]
    protected static $path_components = 'components/';   //: full path to components for prefixing includes
    protected static $path_views      = '';              //: full path to views for prefixing includes



    // [ METHODS: helpers ]

    //@ init > constants
    protected static function initConst() {
        self::$path_views      = make_path(self::$path_views, false);
        self::$path_components = make_path(self::$path_components, false);
    }



    // [ METHODS: Syntax processing ]

    //@ process > Includes
    protected static function processIncludes( $ctx ) {

        // process > components includes
        while( strpos($ctx, '@component') > -1 ) {

            // get > param ( Component )
            $param_start = strpos( $ctx , '@component(' ) + 12;
            $param_end   = strpos( $ctx , ')' , $param_start) - $param_start - 1;
            $param       = substr( $ctx , $param_start, $param_end );
            $param       = self::$path_components . $param . '.php';
            $param       = '"' . $param . '"';
            $param       = str_replace('\\', '/', $param);

            // replace > Bample syntax
            $ctx = preg_replace( "/@component(.*)/" , "<? require_once($param) ?>" , $ctx , 1);

        }

        // process > simple includes
        while( strpos($ctx, '@include') > -1 ) {

            // get > param ( View )
            $param_start = strpos( $ctx , '@include(' ) + 10;
            $param_end   = strpos( $ctx , ')' , $param_start) - $param_start - 1;
            $param       = substr( $ctx , $param_start, $param_end );
            $param       = self::$path_views . $param . '.php';
            $param       = '"' . $param . '"';
            $param       = str_replace('\\', '/', $param);

            // replace > Bample syntax
            $ctx = preg_replace( "/@include(.*)/" , "<? require_once($param) ?>" , $ctx , 1);

        }

        // return > normalised syntax
        return $ctx;
    }

    //@ process > Loops
    protected static function processLoops( $ctx ) {

        // process > foreach loops
        while( strpos($ctx, '@foreach') > -1 ) {

            // get > params ( Array & Value )
            $params_start   = strpos( $ctx , '@foreach(' ) + 9;
            $params_end     = strpos( $ctx , ')' , $params_start) - $params_start;
            $params         = substr( $ctx , $params_start, $params_end );
            [ $arr , $val ] = explode( 'as' , $params);

            // replace > Bample syntax
            $ctx = preg_replace( "/@foreach(.*)/" , "<? foreach($params): ?>" , $ctx , 1);
            $ctx = preg_replace( "/@endforeach/" , "<? endforeach; ?>" , $ctx , 1);

        }

        // return > normalised syntax
        return $ctx;
    }

    //@ process > Dynamic outputs
    protected static function processOutputs( $ctx ) {

        // keep > copy of $ctx ( to replace irrelevant matches without modifying original content )
        $ctx_cache = $ctx;

        // process > dynamic outputs
        while( strpos($ctx_cache, '{') > -1 ) {

            // get > params ( Array & Value )
            $expr_start = strpos( $ctx_cache , '{' ) + 1;
            $expr_end   = strpos( $ctx , '}' , $expr_start) - $expr_start;
            $expr       = substr( $ctx , $expr_start, $expr_end );
            

            // define > RegExp ( what Dynamic output should look like ) 
            $reg_exp = '/(((\$\w+))\s*[\+\-\:\*\.]?\s*((\$\w*)|\d*))|(\d+\s*[\+\-\:\*]+\s*((\$\w*)|\d*))/';

            // check > if expression is a Dynamic output
            if( preg_match( $reg_exp , $expr ) ) {
                // replace > Bample syntax
                $ctx = preg_replace( "/{.*}/" , "<?= $expr ?>" , $ctx , 1);
            }
            //? if > NOT a Dynamic output (css declarations, etc.)  
            else {
                // skip > irrelevant match on next iterations
                $ctx_cache = preg_replace( "/{/" , "~" , $ctx_cache , 1);
            }

        }

        // return > normalised syntax
        return $ctx;
    }

    //@ replace > Bample syntax
    public static function processSyntax( $ctx ) {

        // init > path constants
        self::initConst();

        // process > includes
        $ctx = self::processIncludes( $ctx );

        // process > loops
        $ctx = self::processLoops( $ctx );

        // process > dynamic outputs
        $ctx = self::processOutputs( $ctx );

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