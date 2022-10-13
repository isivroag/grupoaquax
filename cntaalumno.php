<?php
$pagina = "alumno";
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

$sqlc = "SELECT vauxlistas.id_alumno,vauxlistas.nombre,vauxlistas.id_tgpo,vauxlistas.id_sub,vauxlistas.id_nivel,vauxlistas.nacimiento,vauxlistas.edad,nivel.nivel,vauxlistas.id_objetivo as nomnivel 
        from vauxlistas join nivel on vauxlistas.id_nivel=nivel.id_nivel order by vauxlistas.id_alumno";

$sqlc = "SELECT * from vauxlistas2 order by id_alumno";

$consulta = $sqlc;
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>


<style>
    #tablavis tfoot input {
        width: 100% !important;
    }

    #tablavis tfoot {
        display: table-header-group !important;
    }
</style>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">



<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-blue ">
                <h1 class="card-title mx-auto">ALUMNOS</h1>
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
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>ID Nivel</th>
                                            <th>Nivel</th>
                                            <th>ID Etapa</th>
                                            <th>Etapa</th>
                                            <th>Obj Act</th>
                                            <th>Instructor Asignado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="invisible"></th>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_alumno'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['dataeval'] ?></td>
                                                <td><?php echo $dat['id_nivel'] ?></td>
                                                <td><?php echo $dat['ncorto'] ?></td>
                                                <td><?php echo $dat['id_etapa'] ?></td>
                                                <td><?php echo $dat['nom_etapa'] ?></td>
                                                <td><?php echo $dat['id_objetivo'] ?></td>
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


<script src="fjs/alumno.js?v=<?php echo (rand()); ?>" type="text/javascript"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>