$(document).ready(function () {
    var id, opcion
    opcion = 4
  

  
  
    tablavis = $(".tablad1").DataTable({
  
      "ordering": false,
      info: false,
      orderCellsTop: false,
      
  fixedHeader: true,
  paging:false,
  "searching":false,

        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btnVer'><i class='fas fa-info-circle'></i> Info</button><button class='btn btn-primary  btnEval'><i class='fas fa-tasks'></i> Plan</button><button class='btn bg-purple  btnVerHist'><i class='fas fa-clock'></i> Historia</button><button class='btn bg-success text-light btnPromover'><i class='fas fa-award'></i> Promover</button></div></div>"
        },
        { "width": "25%", "targets": 6 }
    ],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },

       
    });
    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "viewalumno.php?id=" + id;


    });

    $(document).on("click", ".btnPromover", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "promo.php?id=" + id;


    });


    $(document).on("click", ".btnVerHist", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "verevaluaciones.php?id=" + id;


    });

    $(document).on("click", ".btnEval", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "regevaluacion.php?id=" + id;


    });
  
  
  
  
    tablaobra = $('#tablaObra').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObra' data-toggle='tooltip' data-placement='top' title='Seleccionar Obra'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      ],
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
    })
  

  
   

  
    //BOTON BUSCAR OBRA
    $(document).on('click', '#binstructor', function () {
      $('#modalBuscar').modal('show')
    })
    //BOTON SELECCIONAR OBRA
    //BOTON SELECCIONAR OBRA
    $(document).on('click', '.btnSelObra', function () {
      fila = $(this)
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      
      window.location.href = 'cntalista.php?id=' + id
  
    })
  
    
  
    function facturaexitosa() {
      swal.fire({
        title: 'Registro Guardado',
        icon: 'success',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
    function facturaerror() {
      swal.fire({
        title: 'Registro No Guardado',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
    function operacionexitosa() {
      swal.fire({
        title: 'Pago Registrado',
        icon: 'success',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
    function mensaje() {
      swal.fire({
        title: 'Registro Cancelado',
        icon: 'success',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
    function mensajeerror() {
      swal.fire({
        title: 'Error al Cancelar el Registro',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
  
    //BUSQUEDA GENERAL
    $(document).on('click', '#btnBuscar', function () {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
      var obra = $('#id_obra').val()
      var opcion = 1
  
      tablaVis.clear()
      tablaVis.draw()
  
      if (inicio != '' && final != '' && obra!='') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarnomina.php',
          dataType: 'json',
          data: { inicio: inicio, final: final, obra: obra, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              tablaVis.row
                .add([
                  data[i].id_nom,
                  data[i].id_obra,
                  data[i].corto_obra,
                  data[i].fecha_ini,
                  data[i].fecha_fin,
                  data[i].desc_nom,
                  Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(data[i].monto_nom).toFixed(2),
                  ),
                ])
                .draw()
            }
          },
        })
      } else {
        alert('Selecciona ambas fechas')
      }
    })
  
    var fila //capturar la fila para editar o borrar el registro
  
    function startTime() {
      var today = new Date()
      var hr = today.getHours()
      var min = today.getMinutes()
      var sec = today.getSeconds()
      //Add a zero in front of numbers<10
      min = checkTime(min)
      sec = checkTime(sec)
      document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
      var time = setTimeout(function () {
        startTime()
      }, 500)
    }
  
    function checkTime(i) {
      if (i < 10) {
        i = '0' + i
      }
      return i
    }
  })
  
  function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode
    var chark = String.fromCharCode(key)
    var tempValue = input.value + chark
    var isNumber = key >= 48 && key <= 57
    var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
    if (isNumber || isSpecial) {
      return filter(tempValue)
    }
  
    return false
  }
  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/
    return preg.te
    st(__val__) === true
  }
  
  $('.modal-header').on('mousedown', function (mousedownEvt) {
    var $draggable = $(this)
    var x = mousedownEvt.pageX - $draggable.offset().left,
      y = mousedownEvt.pageY - $draggable.offset().top
    $('body').on('mousemove.draggable', function (mousemoveEvt) {
      $draggable.closest('.modal-dialog').offset({
        left: mousemoveEvt.pageX - x,
        top: mousemoveEvt.pageY - y,
      })
    })
    $('body').one('mouseup', function () {
      $('body').off('mousemove.draggable')
    })
    $draggable.closest('.modal').one('bs.modal.hide', function () {
      $('body').off('mousemove.draggable')
    })
  })
  