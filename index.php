<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './MysqlConnector.php';

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Create FORM</title>
        <style type="text/css">
            body {
                font-family: sans-serif;
                color: black;
                margin: 0px;
            }
            #msn {
                background-color: #333333;
                width: 99%;
                height: 35px;
                border-radius: 3px;
                margin: 3px;
                color: aliceblue;
                padding: 3px;
                font-size: 0.7em;
                overflow-style: auto;
                overflow: auto;
            }
            
            #content {
                background-color: red;
                border-color: activeborder;
                width: 99%;
                height: 200px;
                border-radius: 3px;
                margin: 3px;
                color: aliceblue;
                padding: 3px;
                font-size: 0.9em;
                
            }
            
            #code {
                background-color: gainsboro;
                border-color: activeborder;
                border-radius: 3px;
                width: 99%;
                color: black;
                padding: 3px;
                float: left;
                margin: 3px;
            }  
        
        </style>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        
    </head>
    <script type="text/javascript">
        
    
    /* @ok se ha conectado y todo va bien con la mysql */
    var ok=0;
    
    /* @arr multiarray con db y tables */
    var arr=Array;
    
    $("document").ready(function(){
        
        /* Al inicio */
        $("#dbtablas").hide();
        
        $("#probar").click(function (){
            
            /* clear all select */
            
            $("#db").find("option").remove().end();
            $("#table").find("option").remove().end();
            
            /* Probar conexion */
            var ho = $("#host").val();
            var us = $("#user").val();
            var pw = $("#pw").val();
            $.ajax({
                    type: "POST",
                    url: "./ajax_mysql.php",
                    data: {accion: 'prudb',h:ho,u:us,p:pw},
                    async: false,
                    success: function(data, textStatus, xhr) {
                        //alert(data); 
                        var j = JSON.parse(data);
                        if (j.nerr == 0 ) {
                            /* todo ok */
                            $("#dbtablas").show();
                            $('#msn').append(j.msn);
                            
                            /* Conexion correcta ponemos datos de DB y tablas */
                            $.ajax({
                                type: "POST",
                                url: "./ajax_mysql.php",
                                data: {accion: 'verdbs',h:ho,u:us,p:pw},
                                async: true,
                                success: function(data,textStatus,xhr){
                                     /*alert(data);
                                    recorren json y añadir 
                                     */
                                    ok=1;
                                    arr = JSON.parse(data);
                                    
                                    for (i=0;i<arr.length;i++) {
                                        /* add db to select */
                                        /* alert("DB:" + arr[i].db); */
                                        $('#db').append("<option value=\"" + i + "\">"+ arr[i].db +"</option>")
                                        for (j=0;j<arr[i].tablas.length;j++){
                                            /* add tablename to select */
                                            /* alert("tabla: "+ arr[i].tablas[j]); */
                                            /* add solo las tables de la primera db */
                                            if (i==0) {
                                                $('#table').append("<option value=\"" + arr[i].tablas[j] + "\">" + arr[i].tablas[j] + "</option>");
                                            }
                                        }
                                    }
                                },
                                dataType: 'html'
                            });
                            
                            
                            
                        }
                        else {
                            /* errror y mostramos y escondemos tablas */
                            $('#msn').append(j.msn); 
                            
                            $("#dbtablas").hide();
                        }
                    },
                    error: function(jqXHR, status, error) {
                        alert('Error en llamada ajax');
                    },
                    dataType: 'html'
                });
           
        return false;    
        });
        
        /************    change database -> change tables  ****************/
        $("#db").change(function(){
            if (ok) {
                /* del  #tables */
                $("#table").find("option").remove().end();
               
                /* add tables from db */
                var db = $("#db").val();
                
                for (j=0;j<arr[db].tablas.length;j++){
                    $('#table').append("<option value=\"" + arr[db].tablas[j] + "\">" + arr[db].tablas[j] + "</option>");                      
                }
            }
        
        });
        
        /* Create php code */
        $("#genera").click(function() {
            /* get db an table */
            var ndb = $("#db").val();
            var table = $("#table").val();
            var db = arr[ndb].db;
            var ho = $("#host").val();
            var us = $("#user").val();
            var pw = $("#pw").val();
            //if (confirm("Selected DB " + db + ", Table: " + table + ". Confirm?")) {
            //    alert("ok making");
                
                $.ajax({
                    type: "POST",
                    url: "./ajax_mysql.php",
                    data: {accion: 'genera',d:db,t:table,h:ho,u:us,p:pw},
                    async: false,
                    success: function(data, textStatus, xhr) {
                        /* alert(data); */
                        $("#code").html(data);
                        
                    },
                    error: function(jqXHR, status, error) {
                        alert('Error en llamada ajax');
                    },
                    dataType: 'html'
                });
                
                
            //}
        });
        
    });
    
    </script>    
    <body>
        <div id="msn">
            <span>MSN:</span>
            <span>
           
            </span>
        </div>
        
        <div id="content">
            <h2>Crear formulario autom&aacute;ticamente desde una tabla de la base de datos.</h2>    
            <div><strong>Conexi&oacute;n a  MySql</strong>
                <form name="frmDB" id="frmDB" action="" method="POST">
                    <label>Host</label>
                    <input type="text" name="host" id="host" value="localhost">
                    <label>User</label>
                    <input type="text" name="user" id="user" value="root">
                    <label>Password</label>
                    <input type="text" name="pw" id="pw" value="5665abril">
                    <button name="probar" id="probar">Probar</button>
                </form>
            </div> 
            <div id="dbtablas">
                <div><strong>Seleccionar Base de Datos y tabla</strong></div>
                <div>
                    <label>DB</label>
                    <select id="db">      
                    </select>
                    <label>Tables</label>
                    <select id="table">    
                    </select>
                    <!-- multiselect columns  next -->
                    <button name="genera" id="genera">Create Code</button>
                </div>
            </div>
            
            </div>
        
            <pre id="code">
               OUTPUT.PHP
            </pre>
           
        
        
       
        
    </body>    
</html>