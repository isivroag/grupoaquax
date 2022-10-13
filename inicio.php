<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";

$dsemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
$me = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

$hoy = $dsemana[date('w')] . " " . date('d') . " de " . $me[date('n') - 1] . " de " . date('Y');
$dia = strtoupper($dsemana[date('w')]);
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$consulta = "SELECT * from w_vgrupo where dia='$dia' and status=1 and id_act=0 order by hora";

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);




?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-gradient-primary">
          <h3>GRUPO AQUAX: BIENVENIDO</h3>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-lg-12">
              <div class="card card-widget">
                <div class="card-header bg-gradient-primary">
                  <h3 class="text-center"><?php echo 'Horario ' . $hoy ?></h3>

                </div>
                <div class="card-body">

                  <?php
                  if ($resultado->rowCount() >= 1) {
                    foreach ($data as $row) {
                      $id_grupo = $row['id_grupo'];
                      $hora = $row['hora'];
                      $grupo = $row['nombre'];
                      $subgpo = $row['id_subgpo'];


                      $sql = "SELECT * FROM vauxlistas WHERE estado =1 AND id_act=0 AND id_grupo='$id_grupo' order by orden,orden_sub";

                      $consultalista = $sql;
                      $resultadolista = $conexion->prepare($consultalista);
                      if ($resultadolista->execute()) {
                        $datalista = $resultadolista->fetchAll(PDO::FETCH_ASSOC);
                      }


                      if($resultadolista->rowCount() >= 1){

                  ?>
                  <div class="card card-primary p-2" style=" border: 3px solid #007bff;">
                      <div class="row justify-content-center">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="hora<?php echo $id_grupo?>" class="col-form-label">HORA</label>
                            <input type="text" class="form-control form-control-sm bg-gradient-primary text-center" style="font-size: 25px;" id="hora<?php echo $id_grupo?>" name='hora<?php echo $id_grupo?>' value="<?php echo $hora ?>">
                          </div>
                        </div>

                        <div class="col-sm-2 " colspan="2"  >
                          <div class="form-group">
                            <label for="id_subgpo<?php echo $id_grupo?>" class="col-form-label">SUBGPO</label>
                            <input type="text" class="form-control form-control-sm" id="id_subgpo<?php echo $id_grupo?>" name='id_subgpo<?php echo $id_grupo?>' value="<?php echo $subgpo ?>">
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="grupo<?php echo $id_grupo?>" class="col-form-label">INSTRUCTOR</label>
                            <input type="text" class="form-control form-control-sm" id="grupo<?php echo $id_grupo?>" name='grupo<?php echo $id_grupo?>' value="<?php echo $grupo ?>">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">

                            <input type="hidden" class="form-control form-control-sm" id="idgpo<?php echo $id_grupo?>" name='idgpo<?php echo $id_grupo?>' value="<?php echo $id_grupo ?>">
                          </div>
                        </div>


                      </div>

                      <div class="row justify-content-center">
                        <div class="col-sm-11">
                          <div class="table-responsive">
                            <table name="" id="" class="tablad1 display table table-sm table-striped table-bordered table-condensed text-nowrap  mx-auto " style="width:100%">
                              <thead class="text-center bg-blue">
                                <tr>
                                  <th>ID </th>
                                  <th>Alumno</th>
                                  <th>SubGpo</th>
                                  <th>Nivel</th>
                                  <th>Etapa</th>
                                  <th>Obj Act</th>
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

      </div>
    </div>
  </section>
  <!-- /.content -->
</div>


<?php
include_once 'templates/footer.php';
?>
<script src="fjs/cards.js"></script>
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