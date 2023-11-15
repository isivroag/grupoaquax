<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_art = (isset($_POST['id_art'])) ? $_POST['id_art'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * FROM wprestamo_det where folio_pres=$folio and id_art='$id_art'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        if ($resultado->rowCount() == 0) {
            $consulta = "INSERT INTO wprestamo_det (folio_pres,id_art) 
            values ('$folio','$id_art')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "UPDATE warticulo set prestado = 1 where id_art='$id_art'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vprestamo_det where folio_pres='$folio' and id_art='$id_art'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }


        break;

    case 2:
        $consulta = "UPDATE warticulo set prestado = 0 where id_art='$id_art'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "DELETE FROM wprestamo_det WHERE folio_pres='$folio' and id_art='$id_art'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;
        }

       
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
