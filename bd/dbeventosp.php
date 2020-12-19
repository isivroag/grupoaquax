<?php
header('Content-Type: application/json');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();




$consulta = "SELECT * FROM vcitap ORDER BY id";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



echo json_encode($data); //enviar el array final en formato json a JS
$conexion = NULL;
?>