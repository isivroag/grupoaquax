<?php
$pagina = "cortedetallado";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$consulta = "SELECT * FROM w_gastocaja where estado_gto='1' and fecha='$fecha' order by folio_gto";


$consulta = "SELECT cobranza.folio_cob,alumno.nombre,cobranza.fecha,detallecob.id_concepto,detallecob.descripcion,detallecob.mes,detallecob.total,detallecob.totalfiscal,if(cobranza.factura=1,'FACTURADO','PENDIENTE') as factura,cobranza.metodo
            FROM cobranza join detallecob on cobranza.folio_cob=detallecob.folio_cob join alumno on cobranza.id_cliente=alumno.id_alumno 
            where cobranza.estado=1 and cobranza.fecha='$fecha'";

$totaling = 0;

$totaltransferencia = 0;
$totalefectivofact = 0;
$totalfacturado = 0;
$totalefectivo = 0;
$totalefectivono = 0;
$totalfiscal=0;

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultag = "SELECT * FROM w_gastocaja where estado_gto='1' and fecha='$fecha' order by folio_gto";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();
$datag = $resultadog->fetchAll(PDO::FETCH_ASSOC);



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
                    <div class="row justify-content-center">
                        <h2 class="my-2">INGRESOS</h2>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto table-sm" style="width:100%">
                                    <thead class="text-center bg-gradient-blue">
                                        <tr>
                                            <th>FOLIO</th>
                                            <th>FECHA</th>
                                            <th>ALUMNO</th>
                                            <th>CONCEPTO</th>
                                            <th>MES</th>
                                            <th>TOTAL</th>
                                            <th>FACTURADO</th>
                                            <th>METODO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                            $totaling += $dat['total'];
                                            
                                            if ($dat['factura'] == 'FACTURADO') {
                                                $totalfacturado += $dat['total'];

                                                if ($dat['metodo'] == 'EFECTIVO') {
                                                    $totalefectivofact += $dat['total'];
                                                    $totalefectivo += $dat['total'];
                                                } else {
                                                    $totaltransferencia += $dat['total'];
                                                }
                                            } else {

                                                if ($dat['metodo'] == 'EFECTIVO') {
                                                    $totalefectivono += $dat['total'];
                                                    $totalefectivo += $dat['total'];
                                                    $totalfiscal += $dat['totalfiscal'];
                                                } else {
                                                    $totaltransferencia += $dat['total'];
                                                }
                                            }


                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_cob'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['descripcion'] ?></td>
                                                <td><?php echo $dat['mes'] ?></td>
                                                <td class="text-right"><?php echo  number_format($dat['total'], 2) ?></td>
                                                <td><?php echo $dat['factura'] ?></td>
                                                <td><?php echo $dat['metodo'] ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <h2 class="my-2">EGRESOS CAJA</h2>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive ">
                                <table name="tablaG" id="tablaG" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-secondary">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Referencia</th>
                                            <th>Concepto</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($datag as $datg) {
                                        ?>
                                            <tr>
                                                <td><?php echo $datg['folio_gto'] ?></td>
                                                <td><?php echo $datg['fecha'] ?></td>
                                                <td><?php echo $datg['referencia'] ?></td>
                                                <td><?php echo $datg['concepto'] ?></td>
                                                <td class="text-right"><?php echo  number_format($datg['total'], 2) ?></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-header  bg-gradient-blue text-light">
                                    <h4 class="card-title text-center">Resultado</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="transferencia" class="col-form-label">Transferencias:</label>
                                                <input type="text" class="form-control" name="transferencia" id="transferencia" autocomplete="off" value='<?php echo $totaltransferencia; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="efectivofact" class="col-form-label">Efectivo Facturado:</label>
                                                <input type="text" class="form-control" name="efectivofact" id="efectivofact" autocomplete="off" value='<?php echo $totalefectivofact; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="totalfact" class="col-form-label">Total Facturado:</label>
                                                <input type="text" class="form-control" name="totalfact" id="totalfact" autocomplete="off" value='<?php echo $totalfacturado; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="efectivofact2" class="col-form-label">Efectivo Facturado:</label>
                                                <input type="text" class="form-control" name="efectivofact2" id="efectivofact2" autocomplete="off" value='<?php echo $totalefectivofact; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="efectivono" class="col-form-label">Efectivo Pendiente Fact:</label>
                                                <input type="text" class="form-control" name="efectivono" id="efectivono" autocomplete="off" value='<?php echo $totalefectivono; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="efectivo" class="col-form-label">Total Efectivo:</label>
                                                <input type="text" class="form-control" name="efectivo" id="efectivo" autocomplete="off" value='<?php echo $totalefectivo; ?>'>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-sm-2" >
                                            <div class="form-group input-group-sm">
                                                <label for="totaling" class="col-form-label">Total Ingresos:</label>
                                                <input type="text" class="form-control" name="totaling" id="totaling" autocomplete="off" value='<?php echo $totaling; ?>'>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">

                                    <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="totalfact2" class="col-form-label">Total Facturado:</label>
                                                <input type="text" class="form-control" name="totalfact2" id="totalfact2" autocomplete="off" value='<?php echo $totalefectivofact; ?>'>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" >
                                            <div class="form-group input-group-sm">
                                                <label for="efectivodep" class="col-form-label">% Efectivo:</label>
                                                <input type="text" class="form-control" name="efectivodep" id="efectivodep" autocomplete="off" value='<?php echo $totalfiscal; ?>'>
                                            </div>
                                        </div>

                                        <div class="col-sm-2" >
                                            <div class="form-group input-group-sm">
                                                <label for="deposito" class="col-form-label">Sugerencia Deposito:</label>
                                                <input type="text" class="form-control" name="deposito" id="deposito" autocomplete="off" value='<?php echo $totalfiscal+$totalefectivofact; ?>'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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


    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cortedetallado.js"></script>
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