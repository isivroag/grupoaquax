
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id_alumno = (isset($_POST['alumno'])) ? $_POST['alumno'] : '';
$id_nivel = (isset($_POST['nivel'])) ? $_POST['nivel'] : '';
$id_etapa = (isset($_POST['etapa'])) ? $_POST['etapa'] : '';


$consulta = "UPDATE datoseval SET id_nivel='$id_nivel',id_etapa='$id_etapa' WHERE id_alumno='$id_alumno'";
$resultado = $conexion->prepare($consulta);
$res = 0;
if ($resultado->execute()) {
    $res = 1;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
