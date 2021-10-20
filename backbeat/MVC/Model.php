<?php

namespace Backbeat\Models;
use Backbeat\Schema;


abstract class Model {


    // [ PRESETS ]

    protected static $_table = '';



    // [ METHODS: helpers ]

    public static function getTable() {
        self::$_table = strtolower( get_called_class() ) . 's';
        self::$_table = explode('\\' , self::$_table);
        self::$_table = array_pop(self::$_table);
    }


    // [ METHODS ]

    //@ select > all columns (of all records)
    public static function all() {
        self::getTable();
        return Schema::table(self::$_table)->all();
    }

    //@ select > particular columns (of all records)
    public static function select( string ...$fields ) {
        self::getTable();
        return Schema::table(self::$_table)->select( ...$fields );
    }

    //@ select > particular number of records
    public static function take( int $n ) {
        self::getTable();
        return Schema::table(self::$_table)->take( $n );
    }

    

}



?>