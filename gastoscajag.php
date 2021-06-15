<?php
$pagina = "cxp";

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
    $consulta = "SELECT * FROM w_gastosg where folio_gastog='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_gastog'];
        $fecha = $dt['fecha'];
        $id_partida = $dt['id_partida'];
        $id_subpartida = $dt['id_subpartida'];
        $nom_partida = $dt['nom_partida'];
        $nom_subpartida = $dt['nom_subpartida'];
        $concepto = $dt['concepto'];
        $facturado = $dt['facturado'];
        $docuumento = $dt['documento'];
        $referencia = $dt['referencia'];
        $total = $dt['total'];;
        $idcaja= $dt['id_cuenta'];;
        $caja= $dt['nom_cuenta'];;
    }





    $message = "";
} else {
    $folio = "";
    $opcion = 1;
    $fecha =  date('Y-m-d');
    $id_partida = "";
    $id_subpartida = "";
    $nom_partida = "";
    $nom_subpartida = "";
    $concepto = "";
    $facturado = "";
    $documento = "";
    $referencia = "";
   

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



$consultacon = "SELECT * FROM w_partida order by id_partida";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



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
                <h1 class="card-title mx-auto">Egresos de Caja</h1>
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


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-blue " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Registro de Gastos</h1>
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

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="documento" class="col-form-label">Tipo de Comprobante:</label>
                                            <select class="form-control" name="documento" id="documento">

                                                <option id="vale" value="VALE">VALE</option>
                                                <option id="nota" value="NOTA">NOTA</option>
                                                <option id="ticket" value="TICKET">TICKET</option>
                                                <option id="factu" value="FACTURA">FACTURA</option>


                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="referencia" class="col-form-label"># Comp.:</label>
                                            <div class="input-group input-group-sm">




                                                <input type="text" class="form-control" name="referencia" id="referencia" value="<?php echo  $referencia; ?>">
                                            </div>

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
                                <div class="row justify-content-sm-center" style="padding:5px 0px;margin-bottom:5px">
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" name="id_partida" id="id_partida" value="<?php echo $id_partida; ?>">
                                            <label for="partida" class="col-form-label">Partida:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="partida" id="partida" value="<?php echo $nom_partida; ?>" disabled>
                                                <span class="input-group-append">
                                                    <button id="bpartida" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" name="id_subpartida" id="id_subpartida" value="<?php echo $id_subpartida; ?>">
                                            <label for="subpartida" class="col-form-label">Subpartida:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="subpartida" id="subpartida" value="<?php echo $nom_subpartida; ?>" disabled>
                                                <span class="input-group-append">
                                                    <button id="bsubpartida" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>

                                                </span>
                                            </div>
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


    <section>
        <div class="container">
            <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROSPECTO</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaC" id="tablaC" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>RFC</th>
                                        <th>Proveedor</th>

                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datac as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_prov'] ?></td>
                                            <td><?php echo $datc['rfc'] ?></td>
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



    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PARTIDA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Partida</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_partida'] ?></td>
                                            <td><?php echo $datc['nom_partida'] ?></td>
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

            <!-- Default box -->
            <div class="modal fade" id="modalSubpartida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR SUBPARTIDA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaSub" id="tablaSub" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Subartida</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/gastoscajag.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>