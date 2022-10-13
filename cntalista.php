<?php
$pagina = "listas";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$datanom = 0;
$fecha = date('Y-m-d');

$resultado = 0;


$id = null;
$instructor = "";
$consultacon = "SELECT * FROM instructor WHERE status=1 ORDER BY nombre";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //BUSCAR NOMBRE DE OBRA
    $consultaobra = "SELECT * from instructor where id_instructor='$id'";
    $resultadoobra = $conexion->prepare($consultaobra);
    $resultadoobra->execute();
    $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dataobra as $rowobra) {
        $instructor = $rowobra['nombre'];
    }

    $dsemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");


    $hoy = $dsemana[date('w')];
    $dia = strtoupper($dsemana[date('w')]);

    $consulta = "SELECT * from w_vgrupo where status=1 and id_act=0 and id_instructor='$id' order by id_dia,hora";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}




$message = "";



?>

<style>
    .abs-center {
        display: flex;
        align-items: center;
        justify-content: center;

    }
</style>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-primary text-light">
                <h1 class="card-title mx-auto">LISTA DE ALUMNOS</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-gradient-primary">
                                SELECCIONAR INSTRUCTOR
                            </div>

                            <div class="card-body ">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-sm-5">
                                        <div class="input-group input-group-sm">
                                            <label for="instructor" class="col-form-label">INSTRUCTOR:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_instructor" id="id_instructor" value="<?php echo $id; ?>">
                                                <input type="text" class="form-control" name="instructor" id="instructor" disabled placeholder="SELECCIONAR INSTRUCTOR" value="<?php echo $instructor; ?>">
                                                <?php if ($id == null) { ?>
                                                    <span class="input-group-append">
                                                        <button id="binstructor" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <?php

                        if ($id != null) { ?>


                            <section class="content">

                                <!-- Default box -->
                                <div class="card">
                                    <div class="card-header bg-gradient-primary text-light">
                                        <h1 class="card-title mx-auto">LISTA DE ALUMNOS ASIGNADA</h1>
                                    </div>

                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="card card-widget">
                                                    <div class="card-header bg-gradient-primary">
                                                        <h3 class="text-center"><?php echo 'Horarios' ?></h3>

                                                    </div>
                                                    <div class="card-body">

                                                        <?php
                                                        if ($resultado->rowCount() >= 1) {
                                                            foreach ($data as $row) {
                                                                $id_grupo = $row['id_grupo'];
                                                                $hora = $row['hora'];
                                                                $grupo = $row['nombre'];
                                                                $subgpo = $row['id_subgpo'];
                                                                $dia = $row['dia'];


                                                                $sql = "SELECT * FROM vauxlistas WHERE estado =1 AND id_act=0 AND id_grupo='$id_grupo' order by orden,orden_sub";

                                                                $consultalista = $sql;
                                                                $resultadolista = $conexion->prepare($consultalista);
                                                                if ($resultadolista->execute()) {
                                                                    $datalista = $resultadolista->fetchAll(PDO::FETCH_ASSOC);
                                                                }


                                                                if ($resultadolista->rowCount() >= 1) {

                                                        ?>



                                                                    <div class="card card-primary p-2" style=" border: 3px solid #007bff;">
                                                                        <div class="row justify-content-center">

                                                                            <div class="col-sm-2">
                                                                                <div class="form-group">
                                                                                    <label for="hora<?php echo $dia ?>" class="col-form-label">DIA</label>
                                                                                    <input type="text" class="form-control form-control-sm bg-gradient-primary text-center" style="font-size: 25px;" id="hora<?php echo $dia ?>" name='hora<?php echo $dia ?>' value="<?php echo $dia ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-group">
                                                                                    <label for="hora<?php echo $id_grupo ?>" class="col-form-label">HORA</label>
                                                                                    <input type="text" class="form-control form-control-sm bg-gradient-primary text-center" style="font-size: 25px;" id="hora<?php echo $id_grupo ?>" name='hora<?php echo $id_grupo ?>' value="<?php echo $hora ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-2 " colspan="2">
                                                                                <div class="form-group">
                                                                                    <label for="id_subgpo<?php echo $id_grupo ?>" class="col-form-label">SUBGPO</label>
                                                                                    <input type="text" class="form-control form-control-sm" id="id_subgpo<?php echo $id_grupo ?>" name='id_subgpo<?php echo $id_grupo ?>' value="<?php echo $subgpo ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label for="grupo<?php echo $id_grupo ?>" class="col-form-label">INSTRUCTOR</label>
                                                                                    <input type="text" class="form-control form-control-sm" id="grupo<?php echo $id_grupo ?>" name='grupo<?php echo $id_grupo ?>' value="<?php echo $grupo ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <div class="form-group">

                                                                                    <input type="hidden" class="form-control form-control-sm" id="idgpo<?php echo $id_grupo ?>" name='idgpo<?php echo $id_grupo ?>' value="<?php echo $id_grupo ?>">
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                        <div class="row justify-content-center">
                                                                            <div class="col-sm-11">
                                                                                <div class="table-responsive">
                                                                                    <table name="" id="" class="tablad1 display table table-sm table-striped table-bordered table-condensed mx-auto " style="width:100%">
                                                                                        <thead class="text-center bg-blue">
                                                                                            <tr>
                                                                                                <th>ID </th>
                                                                                                <th>Alumno</th>
                                                                                                <th>SubGpo</th>
                                                                                                <th>Nivel</th>
                                                                                                <th>Etapa</th>
                                                                                                <th>Obj Act</th>
                                                                                                <th>Descripcion</th>
                                                                                                <th>Acciones</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                      
                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($datalista as $dat) {
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td><?php echo $dat['id_alumno'] ?></td>
                                                                                                    <td><?php echo $dat['nombre'] ?></td>
                                                                                                    <td><?php echo $dat['id_sub'] ?></td>
                                                                                                    <td><?php echo $dat['ncorto'] ?></td>
                                                                                                    <td><?php echo $dat['id_etapa'] ?></td>
                                                                                                    <td><?php echo $dat['id_objetivo'] ?></td>
                                                                                                    <td><?php echo $dat['nom_objetivo'] ?></td>
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

                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.card-body -->

                                    <!-- /.card-footer-->
                                </div>
                                <!-- /.card -->

                            </section>




                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>




    </section>

    <!-- INICIA OBRA -->
    <section>
        <div class="container-fluid">

            <!-- Default box -->
            <div class="modal fade" id="modalBuscar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR INSTRUCTOR</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaObra" id="tablaObra" class="table table-sm  table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_instructor'] ?></td>
                                            <td><?php echo $datc['nombre'] ?></td>

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
    </section>
    <!-- TERMINA OBRA -->





</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntalista.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>