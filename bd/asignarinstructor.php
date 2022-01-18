
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id_alumno = (isset($_POST['alumno'])) ? $_POST['alumno'] : '';

$instructor = (isset($_POST['instructor'])) ? $_POST['instructor'] : '';

//$consulta = "REPLACE INTO datoseval(id_instructor,id_alumno) values ('$instructor','$id_alumno') WHERE id_alumno='$id_alumno'";
$consulta = "SELECT * FROM datoseval WHERE id_alumno='$id_alumno'";
$resultado = $conexion->prepare($consulta);
$res=0;
$resultado->execute();
if ( $resultado->rowCount() > 0 )
 {

    $consulta = "UPDATE datoseval SET id_instructor='$instructor' WHERE id_alumno='$id_alumno'";
    $resultado = $conexion->prepare($consulta);
    $res = 0;
    if ($resultado->execute()) {
        $res = 1;
    }
    
}else{


    $consulta = "INSERT INTO datoseval (id_instructor,id_alumno,id_nivel,id_etapa) VALUES ('$instructor','$id_alumno','0','0')";
    $resultado = $conexion->prepare($consulta);
    $res = 0;
    if ($resultado->execute()) {
        $res = 1;
    }
  
}






print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
