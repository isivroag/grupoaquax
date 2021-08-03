<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$dia = (isset($_POST['dia'])) ? $_POST['dia'] : '';
$transferencia = (isset($_POST['transferencia'])) ? $_POST['transferencia'] : '';
$efectivofact = (isset($_POST['efectivofact'])) ? $_POST['efectivofact'] : '';
$efectivo = (isset($_POST['efectivo'])) ? $_POST['efectivo'] : '';
$totaling = (isset($_POST['totaling'])) ? $_POST['totaling'] : '';
$efectivodep = (isset($_POST['efectivodep'])) ? $_POST['efectivodep'] : '';
$totalgastos = (isset($_POST['totalgastos'])) ? $_POST['totalgastos'] : '';
$deposito = (isset($_POST['deposito'])) ? $_POST['deposito'] : '';


$consulta = "SELECT * FROM w_corte where fecha_corte='$dia' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount() == 0) {
    $consulta = "INSERT INTO w_corte (fecha_corte,total_corte,fact_efectivo,fact_trans,total_efectivo,total_fiscal,total_deposito,total_gastos) VALUES ('$dia','$totaling','$efectivofact','$transferencia','$efectivo','$efectivodep','$deposito','$totalgastos') ";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $data = 1;
    } else {
        $data = 0;
    }
} else {
    $data=0;
}




print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
