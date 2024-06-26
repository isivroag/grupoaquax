<aside class="main-sidebar sidebar-light-primary elevation-3 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/logo.png" alt="Gallery Stone Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">Grupo Aquax</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
        <input type="hidden" id="rolusuario" name="rolusuario" value="<?php echo $_SESSION['s_rol']; ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Inicio
            </p>
          </a>
        </li>
        <?php if ($_SESSION['s_rol'] != '7' && $_SESSION['s_rol'] != '6') { ?>
          <li class="nav-item  has-treeview <?php echo ($pagina == 'grupo' || $pagina == 'alumno' || $pagina == 'evaluacion' || $pagina == 'promocion' || $pagina == 'listas') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link  <?php echo ($pagina == 'grupo' || $pagina == 'alumno' || $pagina == 'evaluacion' || $pagina == 'promocion' || $pagina == 'listas') ? "active" : ""; ?>">
              <i class="nav-icon fas fa-award nav-icon"></i>
              <p>
                Evaluaciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>


            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cntagpo.php" class="nav-link <?php echo ($pagina == 'grupo') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-swimming-pool nav-icon"></i>
                  <p>Grupos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaalumno.php" class="nav-link <?php echo ($pagina == 'alumno') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-swimmer nav-icon"></i>
                  <p>Alumnos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntalista.php" class="nav-link <?php echo ($pagina == 'listas') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Listas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="regevaluacion.php" class="nav-link <?php echo ($pagina == 'evaluacion') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-pen-square nav-icon"></i>
                  <p>Registros Eval.</p>
                </a>
              </li>



              <?php if ($_SESSION['s_rol'] == '5' || $_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2') {
              ?>
                <li class="nav-item">
                  <a href="cntapromociones.php" class="nav-link <?php echo ($pagina == 'promocion') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-medal nav-icon"></i>
                    <p>Promoción</p>
                  </a>
                </li>
              <?php
              }
              ?>


            </ul>

          </li>

        <?php } ?>
        <?php if ($_SESSION['s_rol'] == '2') {
        ?>
          <li class="nav-item has-treeview <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'subpartida' || $pagina == 'cuentas') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'subpartida' ||  $pagina == 'cuentas') ? "active" : ""; ?>">
              <span class="fa-stack">

                <i class="fas fa-cog nav-icon"></i>
              </span>
              <p>
                Control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="cntacuenta.php" class="nav-link <?php echo ($pagina == 'cuentas') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-money-check-alt nav-icon"></i>
                  <p>Cuentas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'partida') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-list-alt nav-icon"></i>
                  <p>Partidas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'subpartida') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-list-alt nav-icon"></i>
                  <p>Subpartidas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaproveedor.php" class="nav-link <?php echo ($pagina == 'proveedor') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-people-carry nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntacxp.php" class="nav-link <?php echo ($pagina == 'cxp') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-file-invoice-dollar nav-icon"></i>
                  <p>Cuentas por Pagar</p>
                </a>
              </li>




            </ul>
          </li>
        <?php } ?>
        <?php if ($_SESSION['s_rol'] == '6' || $_SESSION['s_rol'] == '2') {
        ?>
          <li class="nav-item has-treeview <?php echo ($pagina == 'gtocaja' || $pagina == 'caja' || $pagina == 'gastoscajag' || $pagina == 'cortedetallado') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'gtocaja' || $pagina == 'caja' || $pagina == 'gastoscajag' || $pagina == 'cortedetallado') ? "active" : ""; ?>">
              <span class="fa-stack">
                <i class="fas fa-cash-register nav-icon"></i>


              </span>
              <p>
                Caja
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="cntacajag.php" class="nav-link <?php echo ($pagina == 'gastoscajag') ? "active seleccionado" : ""; ?>  ">
                  <i class="nav-icon fas fa-donate "></i>
                  <p>Caja Grande</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntagastoscaja.php" class="nav-link <?php echo ($pagina == 'gtocaja') ? "active seleccionado" : ""; ?>  ">
                  <i class="nav-icon fas fa-dollar-sign "></i>
                  <p>Gastos Caja Chica</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cortedetallado.php" class="nav-link <?php echo ($pagina == 'cortedetallado') ? "active seleccionado" : ""; ?>  ">
                  <i class="nav-icon fas fa-book "></i>
                  <p>Corte Detallado</p>
                </a>
              </li>




            </ul>
          </li>

        <?php
        }
        ?>
        <?php if ($_SESSION['s_rol'] == 2 || $_SESSION['s_rol'] == 7) { ?>
          <li class="nav-item has-treeview <?php echo ($pagina == 'cntacategoria' || $pagina == 'cntaprestamo' || $pagina == 'cntaarticulo') ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link <?php echo ($pagina == 'cntacategoria' || $pagina == 'cntaprestamo' || $pagina == 'cntaarticulo') ? "active" : ""; ?>">


              <i class="fa-solid fa-boxes-stacked nav-icon"></i>
              <p>
                Inventario

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


              <li class="nav-item">
                <a href="cntacategoria.php" class="nav-link <?php echo ($pagina == 'cntacategoria') ? "active seleccionado" : ""; ?>  ">

                  <i class="fa-solid fa-pen-to-square text-green  nav-icon"></i>
                  <p>Categoria</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaarticulo.php" class="nav-link <?php echo ($pagina == 'cntaarticulo') ? "active seleccionado" : ""; ?>  ">

                  <i class="fa-solid fa-stopwatch text-green  nav-icon"></i>
                  <p>Articulos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaprestamo.php" class="nav-link <?php echo ($pagina == 'cntaprestamo') ? "active seleccionado" : ""; ?>  ">

                  <i class="fa-solid fa-dolly  text-green  nav-icon"></i>
                  <p>Vales de Salida</p>
                </a>
              </li>



            </ul>
          </li>

        <?php } ?>




        <?php if ($_SESSION['s_rol'] == '2') {
        ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php
        }
        ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->