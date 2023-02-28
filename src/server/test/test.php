<?php

require_once('../dbconnect.php');

function test_connection()
{
    $con = DBConnect();

    if ($con->connectado) {
        echo 'Conectado a base de datos<br>';
    }
    else {
        echo $con->error;
    }

    $con->cerrar_conexion();
}

?>
