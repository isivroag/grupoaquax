<?php
$pagina = "alumno";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$rol= $_SESSION['s_rol'];

$id = "";
$id_nivel = "";
$nom_nivel = "";
$nom_alumno = "";
$nacimiento = "";
$edad = "";
$sexo = "";
$obs = "";
$id_sub = "";
$id_etapa = "";
$agrupador = "";
$etapa = "";
$id_instructor = "";
$instructor = "";

if (!empty($_GET['id'])) {

    $id = $_GET['id'];


    $consulta1 = "SELECT alumno.id_alumno,alumno.nombre,alumno.id_tgpo,alumno.id_sub,alumno.id_nivel,alumno.nacimiento,alumno.edad,nivel.nivel as nomnivel ,
    alumno.sexo,alumno.obs,vdatosevaluacion.id_etapa,nivel.AGRUPADOR,vdatosevaluacion.nom_etapa ,id_instructor,cortoinstructor
    from alumno join nivel on alumno.id_nivel=nivel.id_nivel join vdatosevaluacion on alumno.id_alumno=vdatosevaluacion.id_alumno 
    where alumno.id_alumno='$id' order by alumno.id_alumno";


    $resultado1 = $conexion->prepare($consulta1);
    $resultado1->execute();
    $data = $resultado1->fetchAll(PDO::FETCH_ASSOC);
    if ($resultado1->rowCount() >= 1) {
        foreach ($data as $dtvin) {

            $nom_alumno = $dtvin['nombre'];
            $id_nivel = $dtvin['id_nivel'];
            $nom_nivel = $dtvin['nomnivel'];
            $nacimiento = $dtvin['nacimiento'];
            $edad = $dtvin['edad'];;
            $sexo = $dtvin['sexo'];
            $obs = $dtvin['obs'];
            $id_sub = $dtvin['id_sub'];
            $id_etapa = $dtvin['id_etapa'];
            $agrupador = $dtvin['AGRUPADOR'];
            $etapa = $dtvin['nom_etapa'];
            $id_instructor = $dtvin['id_instructor'];
            $instructor = $dtvin['cortoinstructor'];
        }
    }


    $consulta3 = "SELECT id_grupo,id_dia,dia,hora,instructor FROM wvlistas WHERE id_alumno='" . $id . "' and status=1";
    $resultado3 = $conexion->prepare($consulta3);
    $resultado3->execute();
    $data2 = $resultado3->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "<script> window.location='cntaalumno.php'; </script>";
}



?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">





<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>
<div class="content-wrapper">




    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-blue">
                <h1 class="card-title mx-auto">Información del Alumno</h1>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <form id="formPersonas" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-9">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="hidden" class="form-control" name="id_alumno" id="id_alumno" value="<?php echo $id; ?>">
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nom_alumno; ?>">

                                </div>
                                <div class="col-sm-3">
                                    <label for="dinstructor" class="col-form-label">Instructor Asignado:</label>
                                    <input type="hidden" class="form-control" name="id_instructor" id="id_instructor" value="<?php echo $id_instructor; ?>">
                                    <input type="text" class="form-control" name="dinstructor" id="dinstructor" value="<?php echo $instructor; ?>">
                                </div>
                                <div class="col-sm-4">

                                    <label for="edad" class="col-form-label">Edad:</label>
                                    <input type="text" class="form-control" name="edad" id="edad" value="<?php echo $edad; ?>">

                                    <label for="idgpo" class="col-form-label">Id Gpo:</label>
                                    <input type="text" class="form-control" name="idgpo" id="idgpo" value="<?php echo $id_sub; ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label for="nac" class="col-form-label">Fecha de Nacimiento:</label>
                                    <input type="text" class="form-control" name="nac" id="nac" value="<?php echo $nacimiento; ?>">

                                    <label for="nivel" class="col-form-label">Nivel:</label>
                                    <input type="text" class="form-control" name="nivel" id="nivel" value="<?php echo $nom_nivel; ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label for="sexo" class="col-form-label">Género:</label>
                                    <input type="text" class="form-control" name="sexo" id="sexo" value="<?php echo $sexo; ?>">

                                    <label for="etapa" class="col-form-label">Etapa:</label>
                                    <input type="text" class="form-control" name="etapa" id="etapa" value="<?php echo $id_etapa . " " . $etapa; ?>">
                                </div>
                                <div class="col-sm-12">
                                    <label for="obs" class="col-form-label">Observaciones:</label>
                                    <input type="text" class="form-control" name="obs" id="obs" value="<?php echo $obs; ?>">

                                </div>

                            </div>

                            <div class="modal-footer justify-content-center">
                                <div class="row ">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-primary" onclick="window.location.href='cntaalumno.php'"><i class="fas fa-backward"></i> Regresar</button>
                                        <button type="button" id="btnAsignar" name="btnAsignar" class="btn bg-purple"  <?php //if ($rol != '5' && $rol != '2' ) {echo 'disabled'; } ?>><i class="fas fa-level-up-alt"  ></i> Asignar Nivel</button>
                                        <button type="button" id="btnCambio" name="btnCambio" class="btn btn-secondary"  <?php //if ($rol != '5' && $rol != '2' ) {echo 'disabled'; } ?>><i class="fas fa-chalkboard-teacher" ></i> Asignar Instructor</button>
                                        <button type="button" id="btnVergpo" name="btnVergpo" class="btn btn-success"><i class="fas fa-info-circle"></i> Info Grupos</button>
                                        <button type="button" id="btnVerEval" name="btnVerEval" onclick="window.location.href='vereval.php?id_alumno=<?php echo $id ?>'" class="btn bg-info text-light"><i class="fas fa-book-open"></i> Resumen Eval</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <!-- /.card-body -->
                    </div>
                </div>


                <!-- Formulario Datos de Cliente -->


                <!-- /.card-footer-->
            </div>

        </div>

        <!-- /.card -->

    </section>

    <section>
        <div class="container">
            <div class="modal fade" id="modalgpo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalle de Grupos</h5>
                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Id Día</th>
                                        <th>Día</th>
                                        <th>Hora</th>
                                        <th>Instructor</th>
                                        <th>Info</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data2 as $dat) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dat['id_grupo'] ?></td>
                                            <td><?php echo $dat['id_dia'] ?></td>
                                            <td><?php echo $dat['dia'] ?></td>
                                            <td><?php echo $dat['hora'] ?></td>
                                            <td><?php echo $dat['instructor'] ?></td>
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

    <section>
        <div class="container">
            <div class="modal fade" id="modalnivel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">Asignar Nivel</h5>
                        </div>
                        <br>

                        <div id="div_carga">

                            <img id="cargador" src="img/loader.gif" />
                            <span class=" " id="textoc"><strong>Cargando...</strong></span>

                        </div>
                        <form id="formNivel" action="" method="POST">
                            <div class="modal-body">
                                <div class="row  my-auto">




                                    <div class="col-sm-6 my-auto">
                                        <div class="form-group input-group-sm">
                                            <label for="nivel" class="col-form-label">Nivel Actual:</label>
                                            <input type="text" class="form-control" name="nivelact" id="nivelact" value="<?php echo $nom_nivel; ?>">

                                        </div>
                                    </div>




                                    <div class="col-sm-6 my-auto">
                                        <div class="form-group input-group-sm">
                                            <label for="etapa" class="col-form-label">Etapa Actual:</label>
                                            <input type="text" class="form-control" name="etapaact" id="etapaact" value="<?php echo $id_etapa . " " . $etapa; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6 my-auto">
                                        <label for="nnivel" class="col-form-label">Nuevo Nivel:</label>

                                        <select class="form-control bg-success" name="nnivel" id="nnivel">
                                            <?php
                                            $cons = "SELECT * FROM nivel WHERE '$edad' BETWEEN edadmin AND edadmax AND AGRUPADOR='$agrupador'";
                                            $res = $conexion->prepare($cons);
                                            $res->execute();
                                            $datos = $res->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datos as $dtt) {
                                            ?>
                                                <option value="<?php echo $dtt['ID_NIVEL'] ?>" <?php echo ($dtt['ID_NIVEL'] == $id_nivel ? "selected" : "") ?>> <?php echo $dtt['NCORTO'] ?> </option>

                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                    <div class="col-sm-6 my-auto">
                                        <label for="netapa" class="col-form-label">Nueva Etapa:</label>

                                        <select class="form-control  bg-success" name="netapa" id="netapa">
                                            <?php
                                            $cons = "SELECT * FROM etapa WHERE id_nivel='$id_nivel' order by id_etapa";
                                            $res = $conexion->prepare($cons);
                                            $res->execute();
                                            $datos = $res->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datos as $dtt) {
                                            ?>
                                                <option value="<?php echo $dtt['id_etapa'] ?>" <?php echo ($dtt['id_etapa'] == $id_etapa ? "selected" : "") ?>> <?php echo $dtt['id_etapa'] . " " . $dtt['nom_etapa'] ?> </option>

                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                </div>




                            </div>





                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section>
        <div class="container">
            <div class="modal fade" id="modalinstructor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">Asignar Instructor</h5>
                        </div>
                        <br>
                        <form id="forminstructor" action="" method="POST">
                            <div class="modal-body">
                                <div class="row  my-auto">




                                    <div class="col-sm-12 my-auto">
                                        <div class="form-group input-group-sm">
                                            <label for="instructoract" class="col-form-label">Instructor Actual:</label>
                                            <input type="text" class="form-control" name="instructoract" id="instructoract" value="<?php echo $instructor; ?>">

                                        </div>
                                    </div>






                                </div>

                                <div class="row">
                                    <div class="col-sm-12 my-auto">
                                        <label for="ninstructor" class="col-form-label">Instructores Posibles:</label>

                                        <select class="form-control bg-success" name="ninstructor" id="ninstructor">
                                            <?php

                                            $cons = "SELECT id_instructor,instructor FROM vlistas WHERE id_alumno='$id' and status='1' and estado='1' GROUP BY id_instructor";

                                            $res = $conexion->prepare($cons);
                                            $res->execute();
                                            $datos = $res->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datos as $dtt) {
                                            ?>
                                                <option value="<?php echo $dtt['id_instructor'] ?>" <?php echo ($dtt['id_instructor'] == $id_instructor ? "selected" : "") ?>> <?php echo $dtt['instructor'] ?> </option>

                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>

                                </div>

                            </div>





                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarins" name="btnGuardarins" class="btn btn-success" value="btnGuardarins"><i class="far fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>




<?php require_once('templates/footer.php') ?>
<script src="fjs/viewalumno.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>