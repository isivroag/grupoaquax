<?php
$pagina = "cntaprestamo";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM wprestamo where activo=1 and estado='ACTIVO' ORDER BY folio_pres";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

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
    <div class="card">
      <div class="card-header bg-gradient-primary text-light">
        <h1 class="card-title mx-auto">VALES DE SALIDA</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">
            <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
          </div>
        </div>
        <br>
        <div class="container-fluid">

          <div class="row justify-content-center">
            <div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="chtodos">
                <label for="chtodos" class="custom-control-label">Mostrar todos los Vales</label>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-primary">
                    <tr>
                      <th>FOLIO</th>
                      <th>FECHA</th>
                      <th>RESPOSABLE</th>
                      <th>EVENTO</th>

                      <th>FECHA DE SALIDA</th>
                      <th>FECHA DE ENTRADA</th>
                      <th>ESTADO</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_pres'] ?></td>
                        <td><?php echo $dat['fecha'] ?></td>
                        <td><?php echo $dat['responsable'] ?></td>
                        <td><?php echo $dat['evento'] ?></td>
                        <td><?php echo $dat['fecha_salida'] ?></td>
                        <td><?php echo $dat['fecha_entrada'] ?></td>
                        <td><?php echo $dat['estado'] ?></td>
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
      <!-- /.card-body -->

      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTOS</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto" style="padding:15px">
              <table name="tablaArticulo" id="tablaArticulo" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center bg-gradient-primary">
                  <tr>

                    <th>Id_Reg</th>
                    <th>Folio Pres</th>
                    <th>Id Art</th>
                    <th>Clave</th>
                    <th>Descripción</th>
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
  
  <section>
  <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">DEVOLUCIÓN</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body ">

                                <div class="row justify-content">
                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">CLAVE:</label>
                                            <input type="hidden" class="form-control" name="idreg" id="idreg" >
                                            <input type="hidden" class="form-control" name="foliopres" id="foliopres" >
                                            <input type="hidden" class="form-control" name="idart" id="idart" >
                                            <input type="text" class="form-control" name="clave" id="clave" autocomplete="off" placeholder="CLAVE">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="estado" class="col-form-label">ESTADO:</label>
                                            <select class="form-control" name="estado" id="estado" autocomplete="off" placeholder="categoria">
                                              
                                              <option value="1">DEVUELTO</option>
                                              <option value="2">DAÑADO</option>
                                              <option value="0">BAJA</option>
                                              

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" id='colfecha' style="display: none;">

                                        <div class="form-group input-group-sm">
                                            <label for="fecha_baja" class="col-form-label">Fecha Baja:</label>
                                            <input type="date" class="form-control" name="fecha_baja" id="fecha_baja" autocomplete="off" placeholder="fecha_alta">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="articulo" class="col-form-label">DESCRIPCION:</label>
                                            <input type="text" class="form-control" name="articulo" id="articulo" autocomplete="off" placeholder="DESCRIPCION">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="obs" class="col-form-label">OBSERVACIONES:</label>
                                            <textarea name="obs" class="form-control" id="obs" cols="1" rows="2"></textarea>
                                            
                                        </div>
                                    </div>

                                   


                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row justify-content-end">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                    <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                                </div>

                            </div>

                        </form>

                    </div>





                </div>
            </div>
        </div>
  </section>



  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>

<script src="fjs/cntaprestamo.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>