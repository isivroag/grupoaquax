<?php
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM warticulo WHERE estado_art=1 ORDER BY id_art";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigos</title>
</head>

<body>
    <?php
    foreach ($data as $row) {
    ?>
    <img src='barcode.php?text=<?php echo $row['clave']?>&size=30&type=Code39&print=true' />
    <br>
    <?php
    }
    ?>
</body>

</html>