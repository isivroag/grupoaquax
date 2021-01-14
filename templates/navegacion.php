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
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p >
              Inicio
            </p>
          </a>
        </li>

        <li class="nav-item  has-treeview <?php echo ($pagina == 'grupo' || $pagina == 'alumno' || $pagina == 'evaluacion' || $pagina == 'promocion' ) ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link  <?php echo ($pagina == 'grupo' || $pagina == 'alumno' || $pagina == 'evaluacion' || $pagina == 'promocion' ) ? "active" : ""; ?>">
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
              <a href="regevaluacion.php" class="nav-link <?php echo ($pagina == 'evaluacion') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-pen-square nav-icon"></i>
                <p>Registros Eval.</p>
              </a>
            </li>
            <?php if ($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2') {
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