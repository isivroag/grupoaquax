<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$fecha_alta = (isset($_POST['fecha_alta'])) ? $_POST['fecha_alta'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO warticulo (clave,nombre,cantidad,categoria,referencia,fecha_alta) 
        VALUES('$clave','$nombre','$cantidad','$categoria','$referencia','$fecha_alta') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM warticulo ORDER BY id_art DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;
    case 2: //modificación
        $consulta = "UPDATE warticulo SET clave='$clave',nombre='$nombre',cantidad='$cantidad',
        categoria='$categoria', referencia='$referencia', fecha_alta='$fecha_alta' WHERE id_art='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM warticulo WHERE id_art='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE warticulo SET estado_art=0 WHERE id_art='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;