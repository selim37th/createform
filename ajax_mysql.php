<?php

/* 
 * Interfaz ajax para mysql
 */
require_once './MysqlConnector.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'prudb':
            prudb();
            break;
        case 'verdbs':
            verdbs();
            break;
        case 'genera':
            genera();
            break;
        default:
            break;
    }
    
}
else {
    error_log("Llamada ajax incorrecta ...............");
}

/* Debuelve json nxm con las bases de datos que hay y las tablas 

 * formato:
 * [
 *  {
 *      "dbname" : "nombre tabla1",
 *      "tablas" : ["table1", "table2", ... , "tablen"],
 * }
 * {
 *      "dbnameX" : "nombre tabla2",
 *      "tablasX" : ["table1", "table2", ... , "tablen"],
 * }
 * ]
 * 
 */
function verdbs() {
    /* conectar a la db*/
    
    /* query para ver todas las bases de datos y sus respectivas tablas */
    /* $sql="show databases";
     *
     * 
     */
    if (isset($_POST['h']) && isset($_POST['u']) && isset($_POST['p'])) {
        
        $m = new MysqlConnector($_POST['h'],$_POST['u'],$_POST['p']);
        
        if ($m->open_connection()) {
            /* Ok hemos conectado */
            /* vemos bases de datos y tablas */
            $jsonDB= $m->getDataBases();
            $arr_db = json_decode($jsonDB);

            $arr_final = array();
            
            /* Por cada DB miramos tablas */
            foreach ($arr_db as $db) {                       
                $jsonTables = $m->getTables($db->Database);
                $arr_tablas = json_decode($jsonTables);
                
                /* construir multi arr xa json */
                array_push($arr_final, array("db" => $db->Database, "tablas" => $arr_tablas));
 
            }
            //error_log(json_encode($arr_final));
            echo json_encode($arr_final);
        }
        else {
            $msn = array(
                "nerr" => "1",
                "msn" => "Fallo conexion.&nbsp;"
            );
            echo json_encode($msn, JSON_PRETTY_PRINT);
           
        }    
    }
    else {
        error_log("Faltan parametros en la llamda ajax.");
    }
    
    
    
    /* Desconectar de la DB*/
    return false;
}



/* Prueba conexion */
/*
    Devuelve json con informacion de la conexion. Formato:
 * [
 *  {
 *      "nerr": numeroError,
 *      "msn" : "mensaje error"
 *  }
 * ]
 * 
 *  */
function prudb() {
    /* Recogemos parametros */
    // error_log("llamda ajax: ". $_POST['h'] . "/" . $_POST['u'] .  "/" . $_POST['p']);
    if (isset($_POST['h']) && isset($_POST['u']) && isset($_POST['p'])) {
        //error_log("llego");
        $m = new MysqlConnector($_POST['h'],$_POST['u'],$_POST['p']);
        //error_log("error:".$co);
        if ($m->open_connection()) {
            /* construimos json con numero mensaje y txt mensaje */
            $msn = array(
                "nerr" => "0",
                "msn" => "Ok conexion.&nbsp;"
            ); 
            echo json_encode($msn, JSON_PRETTY_PRINT);
        }
        else {
            $msn = array(
                "nerr" => "1",
                "msn" => "Fallo conexion.&nbsp;"
            );
            echo json_encode($msn, JSON_PRETTY_PRINT);
           
        }    
    }
    else {
        error_log("Faltan parametros en la llamda ajax.");
    }
}

function genera() {
    /* Recogemos parametros */
    // error_log("llamda ajax: ". $_POST['h'] . "/" . $_POST['u'] .  "/" . $_POST['p']);
    if (isset($_POST['h']) && isset($_POST['u']) && isset($_POST['p'])) {
        $m = new MysqlConnector($_POST['h'],$_POST['u'],$_POST['p']);
        //error_log("error:".$co);
        if ($m->open_connection()) {
            /* construimos json con datos */
            $json_columns =  $m->getColumns($_POST['d'], $_POST['t']);
            
            
            
            echo $json_columns;
        }
        else {
            $msn = array(
                "nerr" => "1",
                "msn" => "Fallo conexion.&nbsp;"
            );
            echo json_encode($msn, JSON_PRETTY_PRINT);
           
        }    
    }
    else {
        error_log("Faltan parametros en la llamda ajax.");
    }
    
}
?>
