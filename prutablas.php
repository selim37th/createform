<html>
    
    
    <body>
        
    
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$con = new mysqli('localhost','root','5665abril') or die('error conectando a la db');

echo "conectado";

$rs = $con->query('show tables from global');

while ($l=$rs->fetch_assoc()) {
    echo "<br>" . $l['Tables_in_global'];
}

$con->close();


?>
        
        
        
        
    </body>
    
    
    
</html>


