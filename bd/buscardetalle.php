<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();;
$data = 0;
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : false;


$consulta = "SELECT * FROM vprestamo_det where folio_pres='$folio' and prestado=1 ORDER BY id_reg";


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
