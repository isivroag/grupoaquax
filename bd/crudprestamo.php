<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_salida = (isset($_POST['fecha_salida'])) ? $_POST['fecha_salida'] : '';

$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
$evento = (isset($_POST['evento'])) ? $_POST['evento'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE wprestamo set fecha='$fecha',fecha_salida='$fecha_salida',responsable='$responsable',
        evento='$evento',obs='$obs',
        usuario='$usuario',
        activo='1' WHERE folio_pres='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        /*$fecha = date('Y-m-d');
        $consultag = "INSERT INTO cxp (fecha,id_prov,descripcion,subtotal,iva,total,descuento,gtotal,saldo,tipo,usuario,folio_tmp) 
                    values ('$fecha','$id_prov','$descripcion','$subtotal','$iva','$total','$descuento','$gtotal','$gtotal','$tipo','$usuario','$folio')";

        $resultadog = $conexion->prepare($consultag);
        $resultadog->execute();

        $consultan = "SELECT * FROM cxp WHERE folio_tmp= '$folio'";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);
        $folion="";

        foreach ($data as $row) {

            $folion =  $row['folio_cxp'];
        
        }

        $consultadet = "SELECT * from cxp_detalletmp where folio_cxp='$folio' order by id_reg";

        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datadet as $dt) {

            $id_item = $dt['id_item'];
            $cantidad = $dt['cantidad'];
            $costo =  $dt['costo'];
            $importe =  $dt['importe'];
            $descuento2 =  $dt['descuento'];
            $gimporte =  $dt['gimporte'];
        

        $consultadd = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte) 
        values('$folion','$id_item','$cantidad','$costo','$importe','$descuento2','$gimporte')";
        $resultadodd = $conexion->prepare($consultadd);
        $resultadodd->execute();

    }*/


        break;
    case 2:

        $consulta = "UPDATE wprestamo set fecha='$fecha',fecha_salida='$fecha_salida',responsable='$responsable',
        evento='$evento',obs='$obs', usuario='$usuario',
        activo='1' WHERE folio_pres='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        /*$consultag = "UPDATE cxp set fecha='$fecha',id_prov='$id_prov',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario'
        WHERE folio_tmp='$folio'";

        $resultadog = $conexion->prepare($consultag);
        $resultadog->execute();

        $consultan = "SELECT * FROM cxp WHERE folio_tmp= '$folio'";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);
        $folion="";

        foreach ($data as $row) {

            $folion =  $row['folio_cxp'];
        
        }

        $consultabr = "DELETE * from prestamo_det where folio_pres='$folio'";
        $resultadobr = $conexion->prepare($consultabr);
        $resultadobr->execute();
                
        $consultadet = "SELECT * from prestamo_det where folio_pres='$folio' order by id_reg";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datadet as $dt) {

            $id_art = $dt['id_art'];
            $devuelto = $dt['devuelto'];
            $obs =  $dt['obs'];
          
        $consultadd = "INSERT INTO prestamo_det (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte) 
        values('$folion','$id_item','$cantidad','$costo','$importe','$descuento2','$gimporte')";
        $resultadodd = $conexion->prepare($consultadd);
        $resultadodd->execute();

        }
*/
        break;

    case 3:
        $consulta = "UPDATE wprestamo SET estado_pres='0', estado='CANCELADO' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM wprestamo_det WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            // EMPIEZA EL INCREMENTO EN INVENTARIO
            $id = $row['id_art'];

            $consultam = "UPDATE warticulo SET prestado=0 WHERE id_art='$id'";
            $resultadom = $conexion->prepare($consultam);
            $resultadom->execute();

        }

        $consultam = "UPDATE wprestamo_det SET prestado=0, devuelto=1 WHERE  folio_pres='$folio'";
        $resultadom = $conexion->prepare($consultam);
        $resultadom->execute();



        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
