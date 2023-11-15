<?php
//if (isset($_GET['folio'])) {

//  echo getPlantilla($_GET['folio']);

//}


function getPlantilla($folio)
{
  include_once '../bd/conexion.php';

  $plantilla = "";
  if ($folio != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();

    $consulta = "SELECT * FROM Wprestamo WHERE folio_pres='$folio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {

      $fecha = $dt['fecha'];
      $fecha_salida = $dt['fecha_salida'];
      $evento = $dt['evento'];
      $resposable = $dt['responsable'];
      $estado = $dt['estado'];
    }

    $consultadet = "SELECT * FROM vprestamo_det where folio_pres='$folio' order by id_reg";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="../cntaprestamo.php";';
    echo '</script>';
  }

  $plantilla .= '

  

  <body>
    <header class="clearfix">

      <div id="logo">
        <img src="../img/logoa.png">
      </div>

      <div id="espacio" >
        <h3 class="name"></h3>
      </div>
     
      <div id="company" >
        <h3 class="name">VALE DE SALIDA</h3>
      </div>

      <div id="folio">
        <table style="border:0">
            <tbody style="border:0">
            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Folio Vale<strong></td>
            <td style="border:0"><strong style="text-align:right">' . $folio . '</strong></td>

            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Fecha</strong></td>
            <td style="border:0"><p style="text-align:right"> ' . $fecha . '</p></td>
            </tr>
           
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Salida</strong></td>
            <td style="border:2"><p style="text-align:right"> ' . $fecha_salida . '</p></td>
            </tr>

            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Estado</strong></td>
            <td style="border:2"><p style="text-align:right"> ' . $estado . '</p></td>
            </tr>

            </tbody>
        </table>
      
      </div>

     
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <p style="text-align:justify">RESPONSABLE: <strong>' . $resposable . '</strong></p>
          <p style="text-align:justify">EVENTO: <strong>' . $evento . '</strong></p>
        
        </div>
        
      </div>
    
   

    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead style:"background-color:#9B9B9B">
            <tr>
        
                <th class="total"><strong>ID ART</strong></th>
                <th class="total"><strong>CLAVE</strong></th>
                <th class="total"><strong>DESCRIPCION</strong></th>
                <th class="total"><strong>REFERENCIA</strong></th>
                
            </tr>
        </thead>
        <tbody>';

  foreach ($datadet as $row) {

    $plantilla .= '
            <tr>
                <td class="desc">' . $row['id_art'] . '</td>
                <td class="desc">' . $row['clave'] . '</td>
                <td class="medida">' . $row['nombre'] . '</td>
                <td class="medida">' . $row['referencia'] . '</td>
            </tr>
            ';
  }
  $plantilla .= '
        </tbody>
    </table>

<div style="padding-top:100px">
            <table class="tabla" style="border:0px">
           
                <tbody style="border: 0px" >
                    <tr >
                    <td style="border: 0px;max-width:10% !important"></td>
                      <td style="border: 0px; border-bottom:1px solid #000000; width 35% !important;"></td>
                      <td style="border: 0px;max-width:10% !important"></td>
                      <td style="border: 0px;border-bottom:1px solid #000000;width:35% !important"></td>
                      <td style="border: 0px;max-width:10% !important"></td>
                    </tr>
                    <tr>
                    <td style="border: 0px;max-width:10% !important"></td>
                    <td class="desc" style="border: 0px; text-align:center;width:35% !important">AUTORIZADO POR:</td>
                    <td style="border: 0px;width:10% !important"></td>
                    <td class="desc" style="border: 0px; text-align:center;width:35% !important">RECIBIDO POR:   </td>
                    <td style="border: 0px;max-width:10% !important"></td>
                    </tr>
                   
                  </tbody>
                 
            </table>
</div>

    </main>
    <footer>
    </footer>
  </body>';

  return $plantilla;
}
