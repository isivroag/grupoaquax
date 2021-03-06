<?php
$pagina = "promocion";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";

?>


<style>
    #tablaRpt tfoot input {
        width: 100% !important;
    }

    #tablaRpt tfoot {
        display: table-header-group !important;
    }
</style>


<!-- Inicio del contenido principal -->
<?php
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$sqlc = "SELECT w_promocion.id_reg,w_promocion.fecha,w_promocion.id_alumno,vdatosevaluacion.nombre,vdatosevaluacion.nominstructor 
        from w_promocion join vdatosevaluacion on w_promocion.id_alumno=vdatosevaluacion.id_alumno where w_promocion.estado_prom='1' order by w_promocion.fecha";



$consulta = $sqlc;
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">



<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-blue ">
                <h1 class="card-title mx-auto">ALUMNOS EVALUADOS</h1>
            </div>

            <div class="card-body">


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablavis" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-blue">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>ID Alumno</th>
                                            <th>Alumno</th>
                                            <th>Evaluador</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_reg'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['id_alumno'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['nominstructor'] ?></td>

                                                <td></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>





<?php require_once('templates/footer.php') ?>


<script src="fjs/cntapromo.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>