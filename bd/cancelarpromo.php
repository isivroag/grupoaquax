<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id_reg = (isset($_POST['id_reg'])) ? $_POST['id_reg'] : '';

$resp=0;







    $consulta = "UPDATE w_promocion SET estado_prom='0' WHERE id_reg='$id_reg'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $resp += 1;




print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;











