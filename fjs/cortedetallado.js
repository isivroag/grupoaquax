$(document).ready(function () {
  var id, opcion
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    paging: false,

    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group 'l><'col-sm-12 col-md-4 form-group text-center'B><'col-sm-12 col-md-4 form-group 'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Reporte de Egresos',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Egresos',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4] },
      },
    ],

    columnDefs: [
      {
        targets: 4,
        render: function (data, type, row, meta) {
          mes = 0
          console.log(data)
          switch (parseInt(data)) {
            case 1:
              mes = 'ENERO'
              break
            case 2:
              mes = 'FEBRERO'
              break
            case 3:
              mes = 'MARZO'
              break
            case 4:
              mes = 'ABRIL'
              break
            case 5:
              mes = 'MAYO'
              break
            case 6:
              mes = 'JUNIO'
              break
            case 7:
              mes = 'JULIO'
              break
            case 8:
              mes = 'AGOSTO'
              break
            case 9:
              mes = 'SEPTIEMBRE'
              break
            case 10:
              mes = 'OCTUBRE'
              break
            case 11:
              mes = 'NOVIEMBRE'
              break
            case 12:
              mes = 'DICIEMBRE'
              break
            case 0:
              mes="";
              break;
          }

          return mes
        },
      },
    ],

    //Para cambiar el lenguaje a español
    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },

    rowCallback: function (row, data) {},
  })

  function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
    }
    val = '$ ' + val
    return val
  }

  $('#btnBuscar').click(function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()

    tablaVis.clear()
    tablaVis.draw()

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarcorte.php',
        dataType: 'json',
        data: { inicio: inicio, final: final },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].folio_cob,
                data[i].fecha,
                data[i].nombre,
                data[i].descripcion,
                data[i].mes,
                data[i].total,
                data[i].factura,
                data[i].metodo,
              ])
              .draw()

            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    } else {
      alert('Selecciona ambas fechas')
    }
  })
})