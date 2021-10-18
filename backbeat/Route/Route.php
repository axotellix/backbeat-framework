<?php

namespace Backbeat;


// ---------- [ GLOBAL METHODS: helpers ] ---------- 

//@ make > full path to View
function make_path( string $v, bool $extention = true ) {
    if( $extention ) {
        return __DIR__ . '/../../app/MVC/views/' . $v . '.php';
    } else {
        return __DIR__ . '/../../app/MVC/views/' . $v;
    }
}


// ---------- [ GLOBAL METHODS: View ] ---------- 

//@ check > if View exists
function check_404( string $v = null ) {

    //? if > no View passed - get route from URL
    $v = ($v === null) 
        //crutch: if > index pgae requested (set "/" to "index") 
        ? str_replace( '.php.php', '.php', str_replace( '/.php' , 'index.php' , make_path('pages/' . Route::getURI()) ) ) 
        : $v
    ;

    //? if > View NOT found
    if( !file_exists($v) ) {

        // return > View ( 404 page )
        $v = make_path('404');
        Bample::setStatic( $v );

        // set > Status code to 404
        Route::setStatus(404);
        return true;
    }

    //? if > View found
    Route::setStatus(200);
    return false;
}

//@ extract > View data | render > View
function view( string $view_name , array $view_data = [] ) {
        
    // prefix > view name with full path to Views
    $view_name = make_path($view_name);

    //? if > view NOT found ( 404 page )
    if( check_404($view_name) ) return;

    // prepare > View data
    $view = [ 
        'view' => $view_name,
        'data' => $view_data,
    ];

    // return > View (with data)
    Bample::setStatic( $view['view'] );

}



// ---------- [ "ROUTE" CLASS ] ---------- 

abstract class Route {

    // [ PRESETS ]

    protected static $uri  = '';        //: keep > URI requested
    protected static $status  = 200;    //: keep > Status code



    // [ METHODS: helpers ]

    //@ get > URI from URL
    public static function getURI() {

        // prefix > URI with backslash
        $uri = '/' . $_GET['route'];

        // set > URI (for home route)
        if( $uri === '/index.php') $uri = '/';

        // return > URI
        return $uri;

    }

    //@ get > URI from URL
    public static function setStatus( $code ) {
        self::$status = $code;
    }


    // [ METHODS: Requests ]

    //@ process > GET Request
    public static function get( string $route , $action ) {

        // get > URI
        self::$uri = self::getURI();

        // check > if route matches URI
        if( self::$uri === $route ) {

            //? if > Controller@action passed 
            if( gettype($action) === 'string' ) {

                // get > Controller name & Controller action
                [$controller_name , $action_name] = explode('@', $action);
                $controller_name = 'Backbeat\\' . $controller_name;

                // create > Controller instance
                $controller = new $controller_name;

                // execute > action
                $controller->$action_name();

            } 
            //? if > function passed 
            else {
                // execute > action
                $action();
            }

        }

    }


}


?>