<?php
$pagina = "gtocaja";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha=date('Y-m-d');
$consulta = "SELECT * FROM w_gastocaja where estado_gto='1' and fecha='$fecha' order by folio_gto";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultag = "SET lc_time_names = 'es_ES'";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-blue text-light">
                <h4 class="card-title text-center">Gastos de Caja</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">

                        <button id="btnNuevo" type="button" class="btn bg-gradient-blue btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-gradient-blue">
                            Filtro por rango de Fecha
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Desde:</label>
                                        <input type="date" class="form-control" name="inicio" id="inicio" value='<?php echo date('Y-m-d'); ?>'>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Hasta:</label>
                                        <input type="date" class="form-control" name="final" id="final" value='<?php echo date('Y-m-d'); ?>'>
                                    </div>
                                </div>

                                <div class="col-lg-1 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-blue">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Referencia</th>
                                            <th>Concepto</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_gto'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['referencia'] ?></td>
                                                <td><?php echo $dat['concepto'] ?></td>
                                                <td class="text-right"><?php echo  number_format($dat['total'], 2) ?></td>
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
                <br>



            </div>


            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <section>
        <div class="modal fade" id="modalN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE GATOS</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" autocomplete="off" placeholder="Nota, Factura o fecha" value='<?php echo date('Y-m-d'); ?>'>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="referencia" class="col-form-label">Nota/Fact/Ref:</label>
                                        <input type="text" class="form-control" name="referencia" id="referencia" autocomplete="off" placeholder="Nota, Factura o Referencia">
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="concepto" class="col-form-label">Concepto:</label>
                                        <textarea row='2' class="form-control" name="concepto" id="concepto" autocomplete="off" placeholder="Concepto"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                </div>
                                <div class="col-lg-4 ">
                                    <label for="total" class="col-form-label ">Total:</label>

                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>

                                        <input type="text" class="form-control text-right" name="total" id="total" >
                                    </div>


                                </div>

                            </div>
                    </div>


                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>

                        </div>

                    <?php
                    }
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntagastoscaja.js"></script>
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
<script src="plugins/chart.js/Chart.min.js"></script>