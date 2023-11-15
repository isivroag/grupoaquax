<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();;
$data = 0;
$valor = (isset($_POST['valor'])) ? $_POST['valor'] : false;

if ($valor == 1){
    $consulta = "SELECT * FROM wprestamo where activo=1 ORDER BY folio_pres";
}else{
    $consulta = "SELECT * FROM wprestamo where activo=1 and estado='ACTIVO' ORDER BY folio_pres";
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
