<?php
$pagina = "gastoscajag";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$idcaja = (isset($_GET['idcaja'])) ? $_GET['idcaja'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);



if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM w_ingresog where folio_ingresog='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_ingresog'];
        $fecha = $dt['fecha'];
        $concepto = $dt['concepto'];
        $total = $dt['total'];;
        $idcaja= $dt['id_cuenta'];;
        $caja= $dt['nom_cuenta'];;
    }





    $message = "";
} else {
    $folio = "";
    $opcion = 1;
    $fecha =  date('Y-m-d');


    $concepto = "";



   

    $total = 0;

    if ($idcaja != "") {
        $cntacuenta = "SELECT * FROM w_cuenta where id_cuenta='$idcaja' order by id_cuenta";
        $resultacnta = $conexion->prepare($cntacuenta);
        $resultacnta->execute();
        $datacnta = $resultacnta->fetchAll(PDO::FETCH_ASSOC);
        foreach ($datacnta as $rowdata) {
            $caja=$rowdata['nom_cuenta'];
        }

    }
}







?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-blue text-light">
                <h1 class="card-title mx-auto">Ingresos de Caja</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">

                        <button id="btnNuevo" type="button" class="btn bg-gradient-blue btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content" >

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-blue " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Registro de Ingresos</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center p-3">

                                <div class="col-lg-2">
                                    <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                                    <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">
                                    <input type="hidden" class="form-control" name="id_caja" id="id_caja" value="<?php echo $idcaja; ?>">
                                    <div class="form-group input-group-sm">
                                    <label for="caja" class="col-form-label">Caja:</label>
                                    <input type="text" class="form-control" name="caja" id="caja" value="<?php echo  $caja; ?>" disabled>
                                    </div>

                                </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>

                                   
                                   



                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folior" class="col-form-label">Folio:</label>
                                            <input type="hidden" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                                            <input type="text" class="form-control" name="folior" id="folior" value="<?php echo $folio; ?>">
                                        </div>
                                    </div>


                                </div>

                             

                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <label for="concepto" class="col-form-label">Concepto:</label>
                                            <textarea rows="2" class="form-control" name="concepto" id="concepto"><?php echo $concepto; ?></textarea>
                                        </div>

                                    </div>



                                </div>

                                <div class="row justify-content-sm-center" style="padding:5px 0px;margin-bottom:5px">





                                    <div class="col-lg-3 offset-lg-6">
                                        <label for="total" class="col-form-label ">Total:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo $total; ?>">
                                        </div>


                                    </div>

                                </div>

                            </div>


                        </div>
                        <!-- Formulario Agrear Item -->


                    </div>


                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>

        </div>

        <!-- /.card -->

    </section>








    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/ingresoscajag.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>