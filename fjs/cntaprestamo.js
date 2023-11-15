$(document).ready(function () {
  var id, opcion
  opcion = 4
  var fila

  tablaVis = $('#tablaV').DataTable({

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fa-solid fa-magnifying-glass'></i></button>\
          <button class='btn btn-sm btn-success  btnDevolver'><i class='fa-solid fa-arrow-rotate-left'></i></button>\
            <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
              <button class='btn btn-sm btn-danger btnBorrar'><i class='fa-solid fa-ban'></i></button></div>",
      },
      { className: 'hide_column', targets: 5 }
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
  })


  tablaArticulo = $('#tablaArticulo').DataTable({
    info: false,
    paging: false,
    searching: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelArticulo'><i class='fas fa-hand-pointer'></i></button></div></div>",
      },
      { targets: [0, 1, 2], className: 'hide_column' }

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
  })

  $('#btnNuevo').click(function () {
    window.location.href = "prestamo.php";

  })


  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())


    window.location.href = "prestamo.php?folio=" + folio;

  })

  $(document).on('click', '.btnSelArticulo', function () {
    fila = $(this).closest('tr')
    idreg = parseInt(fila.find('td:eq(0)').text())
    foliopres = parseInt(fila.find('td:eq(1)').text())
    idart = parseInt(fila.find('td:eq(2)').text())
    clave = fila.find('td:eq(3)').text()
    articulo = fila.find('td:eq(4)').text()


    $('#idreg').val(idreg)
    $('#foliopres').val(foliopres)
    $('#idart').val(idart)
    $('#clave').val(clave)
    $('#articulo').val(articulo)


    $('#modalArticulo').modal('hide')
    $('#modalCRUD').modal('show')





  })


  $(document).on('click', '.btnDevolver', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    tablaArticulo.clear();
    tablaArticulo.draw();



    $.ajax({
      type: "POST",
      url: "bd/buscardetalle.php",
      dataType: "json",
      async: false,
      data: { folio: folio },

      success: function (data) {
        console.log(data)
        for (var i = 0; i < data.length; i++) {
          tablaArticulo.row.add(
            [data[i].id_reg,
            data[i].folio_pres,
            data[i].id_art,
            data[i].clave,
            data[i].nombre,
            ]
          ).draw();
        }
      },
    });

    $('#modalArticulo').modal('show')



  })
  $(document).on('change', '#estado', function () {
    console.log(this.value)
    if (this.value == 0) {
      // Si es 'inactivo', muestra el input de fecha baja
      $('#fecha_baja').val(new Date().toISOString().split('T')[0])
      $('#colfecha').show()
    } else {
      // Si es 'activo' u otro valor, oculta el input de fecha baja
      $('#colfecha').hide()

    }
  })


  $(document).on('click', '#btnGuardar', function () {

    idreg = $('#idreg').val()
    foliopres = $('#foliopres').val()

    idart = $('#idart').val()
    estado = $('#estado').val()
    fecha_baja = $('#fecha_baja').val()
    obs = $('#obs').val()


    console.log(idreg)
    console.log(foliopres)
    console.log(idart)
    console.log(estado)
    console.log(fecha_baja)
    console.log(obs)





    $.ajax({
      type: "POST",
      url: "bd/devolver.php",
      dataType: "json",
      async: false,
      data: {
        foliopres: foliopres,
        idreg: idreg,
        idart: idart,
        estado: estado,
        fecha_baja: fecha_baja,
        obs: obs
      },

      success: function (data) {
        console.log(data)
        if (data == 1) {
          mensaje()
        } else if (data==2){
          mensaje()
          buscar()
        } else
        {
          mensajeerror()
        }

      }

    });

    $('#modalCRUD').modal('hide')



  })

  function mensajeerror() {
    swal.fire({
      title: 'Operacion No exitosa',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function mensaje() {
    swal.fire({
      title: 'Operacion Exitosa',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }


  $(document).on('change', '#chtodos', function () {
   buscar()



  })
  function buscar(){
    if ($("#chtodos").prop("checked")) {
      valor = 1
    } else {
      valor = 0
    }

    tablaVis.clear();
    tablaVis.draw();



    $.ajax({
      type: "POST",
      url: "bd/buscarprestamo.php",
      dataType: "json",
      async: false,
      data: { valor: valor },

      success: function (data) {
        console.log(data)
        for (var i = 0; i < data.length; i++) {
          tablaVis.row.add(
            [data[i].folio_pres,
            data[i].fecha,
            data[i].responsable,
            data[i].evento,
            data[i].fecha_salida,
            data[i].fecha_entrada,
            data[i].estado,]
          ).draw();
        }
      },
    });
  }

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)

    folio = parseInt($(this).closest('tr').find('td:eq(0)').text())
    estado = $(this).closest('tr').find('td:eq(6)').text()
    opcion = 3 //borrar

    if (estado == 'ACTIVO') {
      swal
        .fire({
          title: 'ELIMINAR',
          text: '¿Desea eliminar el registro seleccionado?',
          showCancelButton: true,
          icon: 'question',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#28B463',
          cancelButtonColor: '#d33',
        })
        .then(function (isConfirm) {
          if (isConfirm.value) {
            $.ajax({
              url: 'bd/crudprestamo.php',
              type: 'POST',
              dataType: 'json',
              data: { folio: folio, opcion: opcion },
              success: function (data) {
                tablaVis.row(fila.parents('tr')).remove().draw()
              },
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          }
        })
    } else {
      swal.fire({
        title: 'Error',
        text: 'No es posible cancelar un prestamo que ya ha sido finalizado',
        icon: 'warning',
        confirmButtonText: 'Aceptar',

      })
    }



  })



  $(document).on("click", ".btnPdf", function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    var ancho = 1000;
    var alto = 800;
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    url = "formatos/pdfvale.php?folio=" + folio;

    window.open(url, "Vale", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

  });
})
