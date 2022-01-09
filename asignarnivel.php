<?php
$pagina = "alumno";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


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

if (!empty($_GET['id'])) {

    $id = $_GET['id'];


    $consulta1 = "SELECT alumno.id_alumno,alumno.nombre,alumno.id_tgpo,alumno.id_sub,alumno.id_nivel,alumno.nacimiento,alumno.edad,nivel.nivel as nomnivel ,alumno.sexo,alumno.obs,vdatosevaluacion.id_etapa,nivel.AGRUPADOR  
        from alumno join nivel on alumno.id_nivel=nivel.id_nivel join vdatosevaluacion on alumno.id_alumno=vdatosevaluacion.id_alumno where alumno.id_alumno='" . $id . "' order by alumno.id_alumno";

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
                            <div class="modal-body ">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="nombre" class="col-form-label">Nombre:</label>
                                        <input type="hidden" class="form-control" name="id_alumno" id="id_alumno" value="<?php echo $id; ?>">
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nom_alumno; ?>">

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
                                        <input type="text" class="form-control" name="etapa" id="etapa" value="<?php echo $id_etapa; ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="obs" class="col-form-label">Observaciones:</label>
                                        <input type="text" class="form-control" name="obs" id="obs" value="<?php echo $obs; ?>">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label for="nnivel" class="col-form-label">Nuevo Nivel:</label>

                                        <select class="form-control bg-success" name="nnivel" id="nnivel">
                                            <?php
                                            $cons = "SELECT * FROM nivel WHERE '$edad' BETWEEN edadmin AND edadmax AND AGRUPADOR='$agrupador'";
                                            $res = $conexion->prepare($cons);
                                            $res->execute();
                                            $datos = $res->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datos as $dtt) {
                                            ?>
                                                <option value="<?php echo $dtt['ID_NIVEL'] ?>" <?php echo ($dtt['ID_NIVEL']==$id_nivel ?"selected":"") ?> > <?php echo $dtt['NCORTO'] ?> </option>

                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                    <div class="col-sm-2">
                                        <label for="netapa" class="col-form-label">Nueva Etapa:</label>

                                        <select class="form-control" name="netapa" id="netapa">
                                        <?php
                                            $cons = "SELECT * FROM etapa WHERE id_nivel='$id_nivel' order by id_etapa";
                                            $res = $conexion->prepare($cons);
                                            $res->execute();
                                            $datos = $res->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datos as $dtt) {
                                            ?>
                                                <option value="<?php echo $dtt['id_etapa'] ?>" <?php echo ($dtt['id_etapa']==$id_etapa ?"selected":"") ?> > <?php echo $dtt['id_etapa']. " " .$dtt['nom_etapa'] ?> </option>

                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-center">
                                <div class="row ">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-success" id="btnGuardar" name="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
                                        <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-warning text-light"><i class="fas fa-ban  text-light"></i> Cancelar</button>
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




</div>




<?php require_once('templates/footer.php') ?>
<script src="fjs/asignarnivel.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>