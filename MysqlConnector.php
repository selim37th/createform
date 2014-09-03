<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MysqlConnector
 *
 * @author fran
 * conector mysql
 */

require_once './dic_mysql.php';

class MysqlConnector {
    //put your code here
    private static $host;
    private static $user;
    private static $pw;
    protected $dbname;
    protected $query;
    protected $rows = array();
    private $con;
    
    /* Crea conexion con DB */
    function __construct($h, $u, $p) {
        self::$host = $h;
        self::$user = $u;
        self::$pw = $p;
    }
    
    /* Prueba de conexion a la db */
    function testConexion() {
        try {
           $this->open_connection();
           $this->close_connection();
           return true;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return false;
        }
    }
    
    /* Conectar a la DB */
    public function open_connection() {
        try {
            $this->con = @new mysqli(self::$host, self::$user, self::$pw);
            if ($this->con->connect_error){
                //die ("Error de conexion");
                return false;
            }
            return true;
            
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
        return false;
}
    
/* Desconectar de la DB*/
private function close_connection() {
        try {
            @$this->con->close();
        } catch (Exception $ex) {
            error_log($ex);
        }
    }
    

public function query($tabla, $sql) {
        $this->open_connection();
        
        /* si tabla es blanco ... suponemos que es una consulta a mysql directamente */
        if ($tabla=="") {
            /* select a la DB */
            $rs = $this->con->query($sql);
            $resul=array();
            while ($f=$rs->fetch_array()){
                $resul[]=$f;
            }
            
            //error_log(json_encode($resul));
            return json_encode($resul);
            
        }
        else {
            /* Select a una tabla */
            $rs=$this->con->select_db($tabla);
            $rs = $this->con->query($sql);
            $resul=array();
            
            while ($f=$rs->fetch_array()){
                $resul[]=$f;
            }
            
            //error_log(json_encode($resul));
            return json_encode($resul);
            
        }
        
        
        
        $this->close_connection();
}
  


/* devuelve las bases de datos que hay en un json */
public function getDataBases() {
    $this->open_connection();
    $jsonDB= $this->query("", "show databases"); 
    $this->close_connection();
    return $jsonDB;
}

/* Devuelve json con las tablas de una DB */
/* param @db -> Base de datos
 * 
 */
public function getTables($db) {
    $this->open_connection();
    
    
    /* haz el query aki directamente */
    $arr_t = array();
    $rt = $this->con->query("show tables from " . $db);
    
    $colname = "Tables_in_" . $db;
    while ($t = $rt->fetch_assoc()) {
        //error_log($t[$colname]);
        $arr_t[]= $t[$colname];
    }
   
    $this->close_connection();
    return json_encode($arr_t);
}

/* Devuelve json con las columnas que tiene la tabla de DB
@$db: base de datos
@table: tabla
 *  */
public function getColumns($db, $table) {
    $this->open_connection();
    
    
    /* haz el query aki directamente */
    $arr_t = array();
    $rt = $this->con->query("SHOW COLUMNS FROM " . $table . " FROM " . $db);
    
    /*
    while ($t = $rt->fetch_assoc()) {
        //error_log($t[$colname]);
        $arr_t[]= $t[$colname];
    }
   */
    $this->close_connection();
    error_log(json_encode($arr_t));
    return json_encode($arr_t);
}

}


?>