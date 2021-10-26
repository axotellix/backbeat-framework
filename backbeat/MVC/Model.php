<?php

namespace Backbeat\Models;
use Backbeat\Schema;


abstract class Model {


    // [ PRESETS ]

    protected static $_table = '';
    protected static $_schema = null;



    // [ METHODS: helpers ]

    //@ get > Model`s classname | turn > into table name
    public static function getTable() {
        self::$_table = strtolower( get_called_class() ) . 's';
        self::$_table = explode('\\' , self::$_table);
        self::$_table = array_pop(self::$_table);
    }

    //@ make > new instance of Schema class (to save applied methods` results)
    public static function makeInstance() {
        if( self::$_schema === null ) {
            self::$_schema = new Schema();
        }
    }


    // [ METHODS ]

    //@ select > all columns (of all records)
    public static function all() {
        self::makeInstance();
        self::getTable();
        return self::$_schema::table(self::$_table)->all();
    }

    //@ select > particular columns (of all records)
    public static function select( string ...$fields ) {
        self::makeInstance();
        self::getTable();
        return self::$_schema::table(self::$_table)->select( ...$fields );
    }

    //@ select > particular number of records
    public static function take( int $n ) {
        self::makeInstance();
        self::getTable();
        return self::$_schema::table(self::$_table)->take( $n );
    }

    //@ add > records to DB
    public static function add( array $arr ) {
        self::makeInstance();
        self::getTable();
        return self::$_schema::table(self::$_table)->add( $arr );
    }

    

}



?>