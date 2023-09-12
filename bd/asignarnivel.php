
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id_alumno = (isset($_POST['alumno'])) ? $_POST['alumno'] : '';
$id_nivel = (isset($_POST['nivel'])) ? $_POST['nivel'] : '';
$id_etapa = (isset($_POST['etapa'])) ? $_POST['etapa'] : '';


$consulta = "SELECT * FROM datoseval WHERE id_alumno='$id_alumno' and estado_datos='1'";
$resultado = $conexion->prepare($consulta);
$res=0;
$resultado->execute();
$fecha=date('Y-m-d');
$iddatosviejo=0;

if ( $resultado->rowCount() > 0 )
 {
/*
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $iddatosviejo = $rowdata['id_datos'];
    }
*/

     //cancelo el registo actual de datos eval
    $consulta = "UPDATE datoseval SET estado_datos='0', fecha_baja='$fecha' WHERE id_alumno='$id_alumno' and estado_datos='1'";
    $resultado = $conexion->prepare($consulta); 
    $resultado->execute();
  
 }
  // creo el nuevo registro con una fecha de alta actual
  $consulta = "INSERT INTO datoseval (id_alumno,id_nivel,id_etapa,id_instructor,fecha_alta,estado_datos) VALUES ('$id_alumno','$id_nivel','$id_etapa','0','$fecha','1')";
  $resultado = $conexion->prepare($consulta); 
//$consulta = "UPDATE datoseval SET id_nivel='$id_nivel',id_etapa='$id_etapa' WHERE id_alumno='$id_alumno'";
//$resultado = $conexion->prepare($consulta);

$resultado->execute();

//consulta los datoseval activos actuales

$consulta = "SELECT * from datoseval WHERE id_alumno='$id_alumno' and estado_datos='1'";
$resultado = $conexion->prepare($consulta); 
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $rowdata) {
    $iddatos = $rowdata['id_datos'];
}

//actualizar la tabla alumnos
$consulta = "UPDATE alumno SET id_nivel='$id_nivel' WHERE id_alumno='$id_alumno'";
$resultado = $conexion->prepare($consulta);
$res = 0;
if ($resultado->execute()) {


    //cancerlar los registros de evaluacion
    $cons = "UPDATE evalregistro SET estado='2' WHERE id_alumno='$id_alumno'";
    $resultado = $conexion->prepare($cons);

    
    if ($resultado->execute()) {
        // eliminar los datos de objetivos actuales
        $cons = "UPDATE evalgeneral SET estado='0' WHERE id_alumno='$id_alumno'";
        $resultado = $conexion->prepare($cons);
        $resultado->execute();

        //asingar los nuevos objetivos
        //buscar el agrupador de nivel
        $cons = "SELECT agrupador from nivel WHERE id_nivel='$id_nivel'";
        $resultado = $conexion->prepare($cons);
        $agrupador = 0;
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {
                $agrupador = $rowdata['agrupador'];
            }
        }

        //buscar el primero obejtivo y el ultimo
        $cons = "SELECT MIN(numerador) AS primero, MAX(numerador) AS ultimo from objetivo WHERE agrupador='$agrupador' and id_etapa='$id_etapa' order by numerador";
        $resultado = $conexion->prepare($cons);
        $primero = 0;
        $ultimo = 0;
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {
                $primero = $rowdata['primero'];
                $ultimo = $rowdata['ultimo'];
            }
        }

        // buscar todos los objetivos y clonarlos a evaluaciongeneral
        $cons = "SELECT * FROM objetivo WHERE agrupador='$agrupador' order by numerador";
        $resultado = $conexion->prepare($cons);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {

                // agregar los objetivos a la plantilla del alumno

                $nnivel = $rowdata['id_nivel'];
                $netapa = $rowdata['id_etapa'];
                $nobjetivo = $rowdata['id_objetivo'];
                $ndesc = $rowdata['desc_objetivo'];
                $numerador = $rowdata['numerador'];
                $valor = 0;
                $activo = 0;
                $logro = "1900-01-01";

                if ($numerador < $primero) {
                    $valor = 1;
                    $activo = 0;
                    $logro = date('Y-m-d');
                } else if ($numerador >= $primero && $numerador <= $ultimo) {
                    $valor = 0;
                    $activo = 1;
                    $logro = "1900-01-01";
                } else {
                    $valor = 0;
                    $activo = 0;
                    $logro = "1900-01-01";
                }

                $consultanuevo = "INSERT INTO evalgeneral (id_alumno,id_nivel,id_etapa,id_objetivo,desc_objetivo,valor,activo,logro,id_datos) 
                            values ('$id_alumno','$nnivel','$netapa','$nobjetivo','$ndesc','$valor','$activo','$logro','$iddatos')";
                $resultado = $conexion->prepare($consultanuevo);
                $resultado->execute();
            }
        }



        $res = 1;
    }
}


// resetear nivel, evaluaciones y objetivos logrados



print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
