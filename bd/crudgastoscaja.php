<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';




$data = 0;

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_gastocaja (fecha,concepto,referencia,total,usuario) VALUES ('$fecha','$concepto','$referencia','$total','$usuario')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_gastocaja ORDER BY folio_gto DESC limit 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);




        break;
    case 2:
        $consulta = "UPDATE w_gastocaja SET fecha='$fecha',concepto='$concepto',referencia='$referencia',total='$total',usuario='$usuario' WHERE folio_gto='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_gastocaja WHERE folio_gto='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



        break;
    case 3:
        $consulta = "UPDATE w_gastocaja SET estado_gto='0' WHERE folio_gto='$id'";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 0;
        }
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
