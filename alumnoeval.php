<?php $pagina = "evaluacion";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
include_once 'bd/conexion.php';


$objeto = new conn();
$conexion = $objeto->connect();

if (isset($_GET['id_alumno'])) {

    $id_alumno = $_GET['id_alumno'];
    $alumno = "";
    $id_nivel = "";
    $nivel = "";
    $agrupador = "";
    $id_etapa = "";
    $fechaactual = date('Y-m-d');


    $cntavinculo = "SELECT id_alumno,nombre,edad,correo,inscripcion,id_tgpo,id_sub
    FROM alumno where id_alumno='$id_alumno'";
    $resvinculo = $conexion->prepare($cntavinculo);
    $resvinculo->execute();
    $datavinculo = $resvinculo->fetchAll(PDO::FETCH_ASSOC);
    if ($resvinculo->rowCount() >= 1) {
        foreach ($datavinculo as $dtvin) {

            $alumno = $dtvin['nombre'];
            $edad = $dtvin['edad'];
            $correo = $dtvin['correo'];
            $fechaing = $dtvin['inscripcion'];
            $gpo = $dtvin['id_tgpo'];
            $subgpo = $dtvin['id_sub'];
        }
    }

    //BUSCAR EL NIVEL Y LOS OBJETIVOS DEL ALUMNO EN LA TABLA EVALUACION DATOSEVAL


    $consulta = "SELECT datoseval.id_alumno,datoseval.id_instructor,
                datoseval.id_nivel,datoseval.id_etapa ,nivel.nivel,nivel.agrupador 
                FROM datoseval join nivel on datoseval.id_nivel =nivel.ID_NIVEL where datoseval.id_alumno='$id_alumno' and datoseval.estado_datos=1";
    $resdatoseval = $conexion->prepare($consulta);
    $resdatoseval->execute();
    $datadatoseval = $resdatoseval->fetchAll(PDO::FETCH_ASSOC);
    if ($resdatoseval->rowCount() >= 1) {
        foreach ($datadatoseval as $dteval) {
            $id_alumno = $dteval['id_alumno'];
            $id_nivel = $dteval['id_nivel'];
            $nivel = $dteval['nivel'];
            $agrupador = $dteval['agrupador'];
            $id_etapa = $dteval['id_etapa'];
            $id_instructor = $dteval['id_instructor'];
        }
    }

    $cntains = "SELECT * FROM instructor where id_instructor='$id_instructor'";
    $resins = $conexion->prepare($cntains);
    $resins->execute();
    $datains = $resins->fetchAll(PDO::FETCH_ASSOC);
    if ($resins->rowCount() >= 1) {
        foreach ($datains as $dtvin) {

            $instructor = $dtvin['nombre'];
        }
    }


    //BUSCAR DE CUANTOS NIVELES ESTA CONFORMADO EL PROGRAMA DEL ALUMNO ACTUAL EN BASE
    // AL NIVEL DE DATOS EVAL

    //$consulta = "SELECT * from nivel where agrupador='" . $agrupador . "' order by id_nivel";
    $consulta = "SELECT * from nivel where agrupador='" . $agrupador . "' order by id_nivel";
    $resnivel = $conexion->prepare($consulta);
    $resnivel->execute();
    $datanivel = $resnivel->fetchAll(PDO::FETCH_ASSOC);

    if ($resnivel->rowCount() >= 1) {
        $nniveles = $resnivel->rowCount();
    } else {
        $nniveles = 0;
    }

    //BUSCAR LA ESTADISTICA DE OBJETIVOS LOGRADOS POR MES


/*
    $mesarreglo = array(
        "", "ENE",
        "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"
    );
    $nmesactual = $mesarreglo[date('n')];
    // fecha de inicio
    $cnta = "SELECT id_alumno, min(logro) as inicio FROM evalgeneral WHERE estado=1 AND valor=1 and id_alumno='$id_alumno' group by id_alumno";
    $res = $conexion->prepare($cnta);
    $res->execute();
    $dini = $res->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dini as $r) {
        $fechainicio = $r['inicio'];
        $fechauno = $r['inicio'];
    }

    $ejercicio_actual = date('Y');
    $mesactual = date('m');
    $informacion = array();


    do {

        $ejerciciouno = date("Y", strtotime($fechainicio));
        $mesuno = date("m", strtotime($fechainicio));

        $cnta = "SELECT id_alumno,MONTH(logro) as mes,YEAR(logro) as ejercicio,COUNT(valor) AS numlogrados FROM evalgeneral
        WHERE estado=1 AND valor=1 and id_alumno='$id_alumno' and month(logro)='$mesuno' and year(logro)='$ejerciciouno'
        GROUP BY id_alumno,MONTH(logro),YEAR(logro)";
        $res = $conexion->prepare($cnta);
        $res->execute();
        $destat = $res->fetchAll(PDO::FETCH_ASSOC);

        $logros = 0;
        foreach ($destat as $r) {
            $logros = $r['numlogrados'];
        }

        $nuevoregistro = array("ejercicio" => date("Y", strtotime($fechainicio)), "mes" => $mesarreglo[date("n", strtotime($fechainicio))], "logros" => $logros);
        $registro = (object) $nuevoregistro;
        array_push($informacion, $registro);
        $fechainicio = strtotime($fechainicio . "+ 1 month");
        $fechainicio = date("Y-m-d", $fechainicio);
    } while (strtotime($fechainicio) < strtotime($fechaactual));

    array_shift($informacion);
    $totalmeses = 0;
    $totalobjetivos = 0;
    $promediologros=0;

    foreach ($informacion as $info => $p) {
        $totalmeses++;
        $totalobjetivos += $p->logros;
    }
    if ($totalmeses > 0) {
        $promediologros = round($totalobjetivos / $totalmeses, 0, PHP_ROUND_HALF_UP);


        $sqlestadisticas = "SELECT valor, COUNT(valor) as suma FROM evalgeneral WHERE estado=1 and id_alumno='$id_alumno' GROUP BY valor";
        $resestat = $conexion->prepare($sqlestadisticas);
        $resestat->execute();
        $dataestat = $resestat->fetchAll(PDO::FETCH_ASSOC);
        $llogrados = 0;
        $lnologrados = 0;
        foreach ($dataestat as $rowestat) {
            if ($rowestat['valor'] == 1) {
                $llogrados = $rowestat['suma'];
            } else {
                $lnologrados = $rowestat['suma'];
            }
        }

        $mesrestantes = round(($lnologrados / $promediologros), 0, PHP_ROUND_HALF_UP);

        // proyeccion siguientes meses


        $informacion2 = array();
        $logrosactuales = 0;

        do {

            $ejerciciouno = date("Y", strtotime($fechainicio));
            $mesuno = date("m", strtotime($fechainicio));



            $nuevoregistro = array("ejercicio" => date("Y", strtotime($fechainicio)), "mes" => $mesarreglo[date("n", strtotime($fechainicio))], "logros" => $promediologros);
            $logrosactuales += $promediologros;

            $registro = (object) $nuevoregistro;
            array_push($informacion2, $registro);
            $fechainicio = strtotime($fechainicio . "+ 1 month");
            $fechainicio = date("Y-m-d", $fechainicio);
        } while ($logrosactuales < $lnologrados);
    }
*/

    //termina proyeccion







} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="cntaalumno.php";';
    echo '</script>';
}
//BUSCAR AL ALUMNO POR MEDIO DE LA TABLA VINCULACION



?>





<div class="content-wrapper">


    <section class="content">
        <div class="card">
            <div class="card-header bg-gradient-blue">
                <div class="row justify-content-center">
                    <h4 class="card-title text-center"><span>EVALUACION </span>
                        <!--    
                    <button type="button" class="btn btn-success" id="print"><i class="fas fa-file-pdf"></i> PDF</button>
-->
                    </h4>
                </div>
            </div>
            <div class="card-body" id="tarjeta">
                <!-- TARJETA DE EVALUACION -->
                <div class="card color-palette-box">
                    <!--ENCABEZADO NOMBRE DEL ALUMNO Y NIVEL -->
                    <div class="card-header ">
                        <div class="row justify-content-between ">
                            <h3 class="card-title text-primary font-weight-bold">
                                <i class="fas fa-medal"></i>
                                DETALLE DE EVALUACION
                            </h3>


                        </div>
                    </div>
                    <!--FIN DE ENCABEZADO -->

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header bg-gradient-blue">
                                        <div class="row justify-content-between ">
                                            <h3 class="card-title font-weight-bold">
                                                INFORMACION GENERAL
                                            </h3>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content">
                                            <div class="col-sm-2">
                                                <div class="form-group input-group-sm">
                                                    <label for="id" class="col-form-label">ID ALUMNO:</label>
                                                    <input type="text" class="form-control" name="id" id="id" autocomplete="off" placeholder="ID" value="<?php echo $id_alumno ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group input-group-sm">
                                                    <label for="alumno" class="col-form-label">NOMBRE:</label>
                                                    <input type="text" class="form-control" name="alumno" id="alumno" autocomplete="off" placeholder="ID" value="<?php echo $alumno ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group input-group-sm">
                                                    <label for="edad" class="col-form-label">EDAD:</label>
                                                    <input type="text" class="form-control" name="edad" id="edad" autocomplete="off" placeholder="ID" value="<?php echo $edad ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group input-group-sm">
                                                    <label for="correo" class="col-form-label">CORREO:</label>
                                                    <input type="text" class="form-control" name="correo" id="correo" autocomplete="off" placeholder="ID" value="<?php echo $correo ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group input-group-sm">
                                                    <label for="fechaing" class="col-form-label">INGRESO:</label>
                                                    <input type="text" class="form-control" name="fechaing" id="fechaing" autocomplete="off" placeholder="ID" value="<?php echo $fechaing ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header bg-gradient-blue">
                                        <div class="row justify-content-between ">
                                            <h3 class="card-title font-weight-bold">
                                                HORARIO
                                            </h3>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-sm-4">
                                                <div class="form-group input-group-sm">
                                                    <label for="instructor" class="col-form-label">INSTRUCTOR TITULAR:</label>
                                                    <input type="text" class="form-control" name="instructor" id="instructor" autocomplete="off" placeholder="ID" value="<?php echo $instructor ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group input-group-sm">
                                                    <label for="grupo" class="col-form-label">GRUPO:</label>
                                                    <input type="text" class="form-control" name="grupo" id="grupo" autocomplete="off" placeholder="ID" value="<?php echo $gpo ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group input-group-sm">
                                                    <label for="subgrupo" class="col-form-label">SUB GRUPO:</label>
                                                    <input type="text" class="form-control" name="subgrupo" id="subgrupo" autocomplete="off" placeholder="ID" value="<?php echo $subgpo ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12">
                                                <div class="card card-outline ">
                                                    <div class="card-header ">
                                                        <div class="row justify-content-between ">
                                                            <h3 class="card-title font-weight-bold">
                                                                DETALLE DE HORARIO
                                                            </h3>

                                                        </div>
                                                    </div>
                                                    <div class="card-body">

                                                        <table class="table table-sm table-striped table-bordered table-condensed text-nowrap  mx-auto" style="width:100%">
                                                            <thead class="text-center text-bold">
                                                                <th>LUNES</th>
                                                                <th>MARTES</th>
                                                                <th>MIERCOLES</th>
                                                                <th>JUEVES</th>
                                                                <th>VIERNES</th>
                                                                <th>SABADO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $cnta = "SELECT * from vlistas where id_alumno='$id_alumno' and estado='1'";
                                                                $res = $conexion->prepare($cnta);
                                                                $res->execute();
                                                                $destat = $res->fetchAll(PDO::FETCH_ASSOC);


                                                                ?>
                                                                <tr>

                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "LUNES") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>

                                                                    </td>
                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "MARTES") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "MIERCOLES") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "JUEVES") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "VIERNES") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center text-bold">
                                                                        <?php
                                                                        $hora = "";
                                                                        $ins = "";
                                                                        foreach ($destat as $r) {
                                                                            $dia = $r['dia'];
                                                                            if ($dia == "SABADO") {
                                                                                $hora = $r['hora'];
                                                                                $ins = $r['instructor'];
                                                                            }
                                                                        }
                                                                        echo $ins . "<br>" . $hora;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header bg-gradient-blue">
                                        <div class="row justify-content-between ">
                                            <h3 class="card-title font-weight-bold">
                                                <i class="fas fa-medal"></i>
                                                PROGRAMA
                                            </h3>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-12">
                                            <!-- CODIGO PARA DIBUJAR LA TARJETA NIVEL-->
                                            <?php
                                            //codigo para dibujar las tarjetas de los niveles
                                            foreach ($datanivel as $dtnivel) {
                                                $nactual = $dtnivel['ID_NIVEL'];

                                                $sqletapa = "SELECT * FROM etapa where id_nivel='" . $nactual . "'";
                                                $resetapa = $conexion->prepare($sqletapa);
                                                $resetapa->execute();
                                                $dataetapa = $resetapa->fetchAll(PDO::FETCH_ASSOC);
                                                $niv = preg_replace('/[^0-9]/', '', $dtnivel['NCORTO']);




                                                $sqltotal = "SELECT * FROM evalgeneral where id_alumno='" . $id_alumno . "' and id_nivel='" . $nactual . "' and valor='1'";
                                                $restotal = $conexion->prepare($sqltotal);
                                                $restotal->execute();
                                                $totalpasados = $restotal->rowCount();

                                                $sqltot = "SELECT * FROM objetivo where id_nivel='" . $nactual . "'";
                                                $restot = $conexion->prepare($sqltot);
                                                $restot->execute();
                                                $totaletapa = $restot->rowCount();





                                                if ($niv <> 0) {
                                                    $proporcion = round(($totalpasados / $totaletapa) * 100, 0);
                                                    $textocolor = "";
                                                    $bgcolor = "";
                                                    switch ($niv) {
                                                        case 1:
                                                            $textocolor = "text-danger";
                                                            $bgcolor = "bg-gradient-danger";
                                                            break;
                                                        case 2:
                                                            $textocolor = "text-orange";
                                                            $bgcolor = "bg-gradient-orange";
                                                            break;
                                                        case 3:
                                                            $textocolor = "text-success";
                                                            $bgcolor = "bg-gradient-success";
                                                            break;
                                                        case 4;
                                                            $textocolor = "text-primary";
                                                            $bgcolor = "bg-gradient-primary";
                                                        default:

                                                            break;
                                                    }
                                            ?>
                                                    <div class="card shadow mb-0 ">
                                                        <!-- TITULO DE TARJETA DE NIVEL Y CODIGO PARA DESPLEGAR -->
                                                        <a href="#<?php echo $dtnivel['NCORTO']; ?>" class="d-block card-header py-3 <?php echo $bgcolor; ?> " data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                                            <h5 class="m-0 font-weight-bold text-light "><?php echo $dtnivel['NIVEL']; ?> <?php echo ($id_nivel == $nactual) ? '(ACTUAL)' : '' ?></h5>
                                                        </a>
                                                        <!-- CONTENIDO DE LA TARJETA DE NIVEL -->
                                                        <div class="<?php echo ($id_nivel == $nactual) ? 'collapsed' : 'collapse'; ?>" id="<?php echo $dtnivel['NCORTO']; ?>">

                                                            <div class="card-body">
                                                                <?php

                                                                //empieza el if de contar las etapas
                                                                if ($resetapa->rowCount() >= 1) {
                                                                    //si tiene etapas dibuja la progress bar

                                                                ?>
                                                                    <!-- BARRA DE PROGRESO DEL NIVEL -->
                                                                    <div class="progress rounded  progress-bar-striped  " style="height: 30px;">
                                                                        <div class="progress-bar <?php echo $bgcolor; ?> " role="progressbar" aria-valuenow="<?php echo $proporcion; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $proporcion . '%'; ?>">
                                                                            <span class="center"><?php echo $proporcion . '% COMPLETADO'; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <!-- FIN DE LA BARRA DE PROGRESO -->
                                                                    <?php
                                                                    foreach ($dataetapa as $dtetaoa) {
                                                                        //CODIGO PARA BUSCAR LOS OBJETIVOS
                                                                        $eactual = $dtetaoa['id_etapa'];


                                                                    ?>
                                                                        <!-- TITULO Y ENCABEZADO DE LA TARJETA DE ETAPA -->
                                                                        <a href="#<?php echo $dtnivel['NCORTO'] . str_replace(' ', '', $dtetaoa['nom_etapa']); ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                                                            <h6 class="m-0 font-weight-bold <?php echo $textocolor; ?>"><?php echo 'ETAPA ' . $dtetaoa['id_etapa']; ?></h6>
                                                                        </a>

                                                                        <!-- CONTENIDO DE LA TARJETA DE ETAPA -->
                                                                        <div class="<?php echo (($id_nivel == $nactual) && ($id_etapa == $eactual)) ? 'collapsed' : 'collapse'; ?>" id="<?php echo $dtnivel['NCORTO'] . str_replace(' ', '', $dtetaoa['nom_etapa']); ?>">
                                                                            <!-- INICIA LA TABLA DE OBJETIVOS DE LA ETAPA -->
                                                                            <?php
                                                                            $sqlobj = "SELECT * FROM evalgeneral where id_alumno='" . $id_alumno . "' and id_nivel='" . $nactual . "' and id_etapa='" . $eactual . "'";
                                                                            $resobj = $conexion->prepare($sqlobj);
                                                                            $resobj->execute();
                                                                            $dataobj = $resobj->fetchAll(PDO::FETCH_ASSOC);
                                                                            if ($resobj->rowCount() >= 1) {
                                                                            ?>
                                                                                <div class="table-responsive table-striped table-bordered">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="text-center"><strong>OBJETIVO</strong></th>
                                                                                                <th class="text-center" style="width:10%"><strong>ESTADO</strong></th>
                                                                                                <th class="text-center" style="width:10%"><strong>LOGRADO</strong></th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($dataobj as $dtobj) {
                                                                                            ?>

                                                                                                <tr>
                                                                                                    <th style="color:#858796"><?php echo $dtobj['desc_objetivo']; ?></th>
                                                                                                    <?php
                                                                                                    if ($dtobj['valor'] == 1) {
                                                                                                    ?>
                                                                                                        <th class="text-center"><i class="fas fa-swimmer text-success"></i></th>
                                                                                                    <?php
                                                                                                    } else if ($dtobj['activo'] == 1) {
                                                                                                    ?>
                                                                                                        <th class="text-center"><i class="fas fa-swimmer text-warning"></i></th>
                                                                                                    <?php
                                                                                                    } else {
                                                                                                    ?>
                                                                                                        <th class="text-center"><i class="fas fa-swimmer text-grey"></i></th>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                    <th class="text-center" style="color:#858796"><?php echo ($dtobj['logro'] == "1900-01-01" ? "" : $dtobj['logro']); ?></th>
                                                                                                </tr>
                                                                                            <?php
                                                                                            }
                                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>

                                                                            <?php

                                                                            }
                                                                            ?>
                                                                        </div>
                                                                <?php
                                                                    }   // termina el foreach de las etapas
                                                                } // termina el if de contar las etapas
                                                                ?>
                                                                <!-- TERMINA LA TABLA -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- TERMINALA TARJETA -->
                                            <?php

                                                }
                                                //termina codigo de dibujar las tarjetas de niveles foreach
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header bg-gradient-blue">
                                        <div class="row justify-content-between ">
                                            <h3 class="card-title font-weight-bold">
                                                <i class="fas fa-medal"></i>
                                                DETALLE DE PROGRESO
                                            </h3>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content">
                                            <div class="col-sm-12">
                                            </div>
                                            <div class="col-sm-12">
                                                <canvas class="chart " id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                                        -->


                    </div>
                    <!-- /.card-body -->
                </div>

            </div>


        </div><!-- /.container-fluid -->
    </section>
</div>

<?php require_once('templates/footer.php') ?>

<script src="fjs/cards.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<!--
<script>
    $(function() {
                window.html2canvas = html2canvas;
                window.jsPDF = window.jspdf.jsPDF;


                $('#print').click(function() {
                            var w = document.getElementById("tarjeta").offsetWidth;
                            var h = document.getElementById("tarjeta").offsetHeight;
                            html2canvas(document.querySelector('#tarjeta'), {
                                    allowTaint: true,
                                    //userCORS: true,
                                    dpi: 50, // Set to 300 DPI
                                    scale: 3, // Adjusts your resolution
                                }).then(canvas => {
                                        /*
                                           var img = canvas.toDataURL("image/png");
                                           var doc =new jsPDF('p','mm');
                                           doc.addImage(img,'PNG',0,0,w,h)
                                           doc.save("evaluacion");
                                           */
                                        var imgData = canvas.toDataURL('image/png');
                                        var imgWidth = 210;
                                        var pageHeight = 295;
                                        var imgHeight = canvas.height * imgWidth / canvas.width;
                                        var heightLeft = imgHeight;
                                        var doc = new jsPDF('p', 'mm');
                                        var position = 0;

                                        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                                        heightLeft -= pageHeight;

                                        while (heightLeft >= 0) {
                                            position = heightLeft - imgHeight;
                                            doc.addPage();
                                            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                                            heightLeft -= pageHeight;
                                        }
                                        doc.save('file.pdf');
                                        
            })
                  
                   
                   
                   
                })

        /* 
        $('#print').click(function() {

            var w = document.getElementById("tarjeta").offsetWidth;
            var h = document.getElementById("tarjeta").offsetHeight;
            html2canvas(document.getElementById("tarjeta"), {
                dpi: 300, // Set to 300 DPI
                scale: 3, // Adjusts your resolution
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/jpeg", 1);
                    var doc = new jsPDF('L', 'px', [w, h]);
                    doc.addImage(img, 'JPEG', 0, 0, w, h);
                    doc.save('sample-file.pdf');
                }
            });
        });
*/


        /*GRAFICA 1*/
        var barChartCanvas = $('#line-chart').get(0).getContext('2d')
        var barChartData = {
            labels: [<?php foreach ($informacion as $info => $p) : ?> "<?php echo $p->mes . " - " . $p->ejercicio   ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'OBJETIVOS LOGRADOS ',
                data: [
                    <?php foreach ($informacion as $info => $p) : ?>
                        <?php echo $p->logros; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [


                    'rgba(17, 116, 241, 0.5)',

                ],
                borderColor: [


                    'rgb(17, 116, 241)',

                ],
                borderWidth: 1
            }]
        }


        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true

                        }
                    }

                ]

            }
        }

        var barChart = new Chart(barChartCanvas, {
            type: 'line',
            data: barChartData,
            options: barChartOptions
        })
        /*TERMINA GRAFICA 1*/

        /*GRAFICA 1*/
        var barChartCanvas2 = $('#line-chart2').get(0).getContext('2d')
        var barChartData2 = {
            labels: [<?php foreach ($informacion2 as $info => $p) : ?> "<?php echo $p->mes . " - " . $p->ejercicio   ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'PROYECCION DE OBJETIVOS ',
                data: [
                    <?php foreach ($informacion2 as $info => $p) : ?>
                        <?php echo $p->logros; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [


                    'rgba(17, 116, 241, 0.5)',

                ],
                borderColor: [


                    'rgb(17, 116, 241)',

                ],
                borderWidth: 1
            }]
        }


        var barChartOptions2 = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true

                        }
                    }

                ]

            }
        }

        var barChart2 = new Chart(barChartCanvas2, {
            type: 'line',
            data: barChartData2,
            options: barChartOptions2
        })
        /*TERMINA GRAFICA 1*/






    });
</script>
-->