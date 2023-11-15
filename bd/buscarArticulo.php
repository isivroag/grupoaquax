<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();;
$data = 0;

$consulta = "SELECT * FROM warticulo WHERE estado_art=1 and prestado=0 ORDER BY id_art";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
