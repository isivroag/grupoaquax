<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';



$consulta = "SELECT cobranza.folio_cob,alumno.nombre,cobranza.fecha,detallecob.id_concepto,detallecob.descripcion,detallecob.mes,detallecob.total,if(cobranza.factura=1,'FACTURADO','PENDIENTE') AS factura,cobranza.metodo
FROM cobranza join detallecob on cobranza.folio_cob=detallecob.folio_cob join alumno on cobranza.id_cliente=alumno.id_alumno 
where cobranza.estado=1 and cobranza.fecha BETWEEN '$inicio' and '$final'";

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
