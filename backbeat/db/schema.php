<?php

namespace Backbeat;
 
// [ establish > connection ]
$conn_path = 'db_connect.php';
require_once($conn_path);


class Schema {

    // ---------- [ PRESETS ] ---------- 

    // [ SQL presets ]
    private const SQL_TYPES = [
        'select' => "SELECT",
        'delete' => "DELETE FROM",
        'update' => "UPDATE",
        'insert' => "INSERT INTO",
    ];
    private static $sql = '';           // store > SQL query
    private static $sql_type = '';      // store > SQL query type (SELECT, DELETE ...)
    
    // [ DB table presets ]
    private static $table = '';         // store > table name

    // [ selection presets ]
    private static $fields = [];        // store > fields names to select
    
    // [ update presets ]
    private static $vals = [];          // store > values to update in table
    private static $update_query = '';  // store > update query (field = value)

    // [ filtering presets ]
    private static $limit      = '';    // store > LIMIT filter
    private static $rec_amount = null;  // store > amount of records to request
    private static $src = [             // store > value to select a particular record (search)
        'field'      => null,
        'expression' => null,
        'value'      => null,
    ];           


    // ---------- [ METHODS ] ---------- 

    // [ DB table connection methods ]
     //@ set > DB table
    public static function table( string $table ) {
        self::$table = $table;
        return new static;
    }

    // [ selection methods ]
     //@ set > amount of records to request
    public static function all() {
        self::$sql_type = 'select';
        self::$fields = ['*'];
        return self::get();
    }
     //@ set > amount of records to request
    public static function select( ...$fields ) {
        self::$sql_type = 'select';
        self::$fields = $fields;
        return new static;
    }

    // [ update methods ]
     //@ add > records
    public static function add( $add_arr ) {
        self::$sql_type = 'insert';
        self::$fields = array_keys($add_arr);
        self::$vals = array_values($add_arr);
        array_walk(self::$vals, function(&$x) {$x = "'$x'";});
        
        self::buildSQL();
        $query = self::prepareSQL();
        $query->execute();
    }

     //@ update > record
    public static function set( $update_arr ) {
        self::$sql_type = 'update';
        self::$fields = array_keys($update_arr);
        self::$vals = array_values($update_arr);
        array_walk(self::$vals, function(&$x) {$x = "'$x'";});

        self::$update_query = '';
        for( $i = 0 ; $i < count($update_arr) ; $i++ ) {
            //? if > last iter (then) do not add comma at the end
            if( $i == count($update_arr) - 1 ) {
                self::$update_query .= self::$fields[$i] . '=' . self::$vals[$i];
            } else {
                self::$update_query .= self::$fields[$i] . '=' . self::$vals[$i] . ", ";
            }
        }
        
        self::buildSQL();
        $query = self::prepareSQL();
        $query->execute();
    }

    // [ update methods ]
     //@ set > amount of records to request
    public static function delete( $field , $expr , $value ) {
        self::$sql_type = 'delete';
        self::$src = [ 'field' => $field, 'expression' => $expr, 'value' => $value ];
        self::buildSQL();
        $query = self::prepareSQL();
        $query->execute();
    }

    // [ filtering methods ]
     //@ set > amount of records to request
    public static function take( int $n ) {

        //? if > selection method was not applied - consider we need * fields
        if( empty(self::$fields) || self::$fields[0] === '*' ) {
            self::$fields = ['*'];
        } 

        self::$sql_type = 'select';
        self::$rec_amount = $n;
        return new static;

    }
     //@ set > DB fields to select
    public static function columns( ...$fields ) {
        self::$fields = $fields;
        return new static;
    }
     //@ set > record filter
    public static function where( string $field , string $expr, $value ) {
        self::$src = [ 'field' => $field, 'expression' => $expr, 'value' => $value ];
        return new static;
    }

    // [ SQL request methods ]
     //@ return > results
    public static function get() {
        self::$sql_type = 'select';
        self::buildSQL();
        return $_POST['pdo']->query(self::$sql)->fetchAll(\PDO::FETCH_OBJ);
    }
     //@ prepare > SQL query
    public static function prepareSQL() {
        return $_POST['pdo']->prepare(self::$sql);
    }
     //@ prepare > SQL query
    public static function buildSQL() {

        // define > SQL query type
        $sql_cmd = self::SQL_TYPES[ self::$sql_type ];
        // define > fields
        $fields_str = implode(', ' , self::$fields);
        // define > values
        $values_str = implode(', ' , self::$vals);
        // define > filter query (if exists)
        if( self::$src['field'] !== null ) {
            $filter = "WHERE " . self::$src['field'] . " " . self::$src['expression'] . " " . self::$src['value'];
        } else {
            $filter = '';
        } 
        // define > LIMIT filter query (if exists)
        if( self::$rec_amount !== null ) {
            $filter .= ' LIMIT ' . self::$rec_amount;
        }

        // define > SQL query
        if( self::$sql_type == 'select' ) {
            self::$sql = "$sql_cmd $fields_str FROM " . self::$table . " $filter";
        } else if( self::$sql_type == 'insert' ) {
            self::$sql = $sql_cmd ." " . self::$table . " ($fields_str) " . $filter . "VALUES ($values_str)";
        } else if( self::$sql_type == 'delete' ) {
            self::$sql = $sql_cmd . " " . self::$table . " " . $filter;
        } else if( self::$sql_type == 'update' ) {
            self::$sql = $sql_cmd . " " . self::$table . " SET " . self::$update_query . " " . $filter;
        }

    }




}