
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id_alumno = (isset($_POST['alumno'])) ? $_POST['alumno'] : '';

$instructor = (isset($_POST['instructor'])) ? $_POST['instructor'] : '';


$consulta = "UPDATE datoseval SET id_instructor='$instructor' WHERE id_alumno='$id_alumno'";
$resultado = $conexion->prepare($consulta);
$res = 0;
if ($resultado->execute()) {
    $res = 1;
}



print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
