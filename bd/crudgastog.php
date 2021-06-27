<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fechareg = (isset($_POST['fechareg'])) ? $_POST['fechareg'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
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
$saldo_ini = 0;
$saldo_fin = 0;
switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * FROM w_cuenta where id_cuenta='$id_caja'";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                $saldo_ini = $row['saldo_cuenta'];
            }
            $saldo_fin = $saldo_ini - $total;

            $consulta = "INSERT INTO w_gastosg (fecha,fechareg,id_partida,id_subpartida,concepto,documento,referencia,total,usuario,id_cuenta,saldo_ini,saldo_fin,id_prov) VALUES ('$fecha','$fechareg','$id_partida','$id_subpartida','$concepto','$documento','$referencia','$total','$usuario','$id_caja','$saldo_ini','$saldo_fin','$id_prov')";
            $resultado = $conexion->prepare($consulta);

            if ($resultado->execute()) {

                $consulta = "SELECT * from w_gastosg order by folio_gastog DESC LIMIT 1";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $folioegreso = 0;
                foreach ($data as $row) {
                    $folioegreso = $row['folio_gastog'];
                }


                $consulta = "UPDATE w_cuenta SET saldo_cuenta='$saldo_fin' where id_cuenta='$id_caja'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $consulta = "INSERT INTO w_movcajag (tipo_mov,fecha_mov,fecha_reg,id_cuenta,concepto_mov,saldo_ini,monto_mov,saldo_fin,metodo_mov,folio_gastog,folio_ingresog,usuario) VALUES ('EGRESO','$fecha','$fechareg','$id_caja','$concepto','$saldo_ini','$total','$saldo_fin','EFECTIVO','$folioegreso','','$usuario')";
                    $resultado = $conexion->prepare($consulta);

                    if ($resultado->execute()) {

                        $data = 1;
                    } else {
                        $data = 0;
                    }
                } else {
                    $data = 0;
                }



                //actualizar saldo de la cuenta
            } else {
                $data = 0;
            }
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
