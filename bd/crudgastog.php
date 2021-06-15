<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';
$id_subpartida = (isset($_POST['id_subpartida'])) ? $_POST['id_subpartida'] : '';
$id_caja = (isset($_POST['id_caja'])) ? $_POST['id_caja'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$documento = (isset($_POST['documento'])) ? $_POST['documento'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';

$total = (isset($_POST['total'])) ? $_POST['total'] : '';

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';




$data = 0;

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_gastosg (fecha,id_partida,id_subpartida,concepto,documento,referencia,total,usuario,id_cuenta) VALUES ('$fecha','$id_partida','$id_subpartida','$concepto','$documento','$referencia','$total','$usuario','$id_caja')";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
            //actualizar saldo de la cuenta
        } else {
            $data = 0;
        }


        break;
    case 2:
        $consulta = "UPDATE w_gastosg SET fecha='$fecha',id_partida='$id_partida',id_subpartida='$id_subpartida',concepto='$concepto',documento='$documento',referencia='$referencia',total='$total',usuario='$usuario' WHERE folio_gastog='$folio'";
        $resultado = $conexion->prepare($consulta);
       
        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 0;
        }


        break;
    case 3:
        $consulta = "UPDATE w_gastosg SET estado_gastog='0' WHERE folio_gastog='$folio'";
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
