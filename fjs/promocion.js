$(document).ready(function () {
  tablavis = $('#tablaobjetivos').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    /*<div class='btn-group'><button type='button' class='btn btn-success btnEditar'><i class='fas fa-edit'></i>Validar</button> */
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'>\
                <button type='button' class='btn btn-warning btnactivar '><i class='fas fa-edit'></i>Reactivar</button></div></div>",
      },
      { className: 'hide_column', targets: [3] },
      { className: 'text-center', targets: [2] },
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

  objetivos()

  $('#etapa').change(function () {
    objetivos()
  })
  /*
        $('#tbody').on('click', function() {

            fila = $(this).closest("tr");
            id = parseInt(fila.find('td:eq(0)').text());


            objetivo = fila.find('td:eq(1)').text();
            estado = fila.find('td:eq(2)').text();
            console.log(id);

          
            /*
                $.ajax({

                    url: "bd/evaluar.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, eval: eval },

                    success: function(data) {
                        console.log(data);
                        window.location.href = "bd/evaluar.php";
                    }
                });


}); */


$(document).on('click', '#btncancelarpromo', function () {
  id_reg = $('#id_reg').val();

  swal
  .fire({
    title: '¿Desea Cancelar el Registro?',

    showCancelButton: true,
    icon: 'question',
    focusConfirm: true,
    confirmButtonText: 'Aceptar',

    cancelButtonText: 'Cancelar',
  })
  .then(function (isConfirm) {
    if (isConfirm.value) {
      $.ajax({
        url: 'bd/cancelarpromo.php',
        type: 'POST',
        dataType: 'json',
        data: {
        
          id_reg: id_reg,
        },
        success: function (resp) {
          if (resp != 0) {
            Swal.fire({
              title: 'Promoción Cancelada',
              icon: 'success',
            })

            window.setTimeout(function () {
              window.location.reload()
            }, 1000)
          }
        },
      })
    } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
    }
  })

})

  $(document).on('click', '#btnpromover', function () {
    id_reg = $('#id_reg').val();
    id_nivel = $('#id_nivel').val();
    id_etapa = $('#etapa').val();
    id_alumno = $('#id').val();
    //id_objetivo = fila.find("td:eq(0)").text();
    fecha = $('#fecha').val();

    fila = $(this).closest('tr');
      swal
      .fire({
        title: '¿Desea Promover al Alumno?',

        showCancelButton: true,
        icon: 'question',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/cambionivel.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id_alumno: id_alumno,
              id_nivel: id_nivel,
              id_etapa: id_etapa,
              id_reg: id_reg,
            },
            success: function (resp) {
              if (resp != 0) {
                Swal.fire({
                  title: 'Alumno Actualizado',
                  icon: 'success',
                })

                window.setTimeout(function () {
                  window.location.reload()
                }, 1000)
              } else {
                console.log(resp)
                Swal.fire({
                  title: '<strong>Programa Terminado</strong>',
                  html:
                    '<b>El alumno ha terminado con exito el programa completo</b> ',

                  icon: 'success',
                })
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    swal
      .fire({
        title: 'Cambiar Objetivo a Logrado',
        html:
          '¿Desea Registrar que este objetivo ha sido logrado?<br><b> Si acepta, esta acción no podrá ser desecha<b>',

        showCancelButton: true,
        icon: 'question',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          id_nivel = $('#id_nivel').val()
          id_etapa = $('#etapa').val()
          id_alumno = $('#id').val()
          id_objetivo = fila.find('td:eq(0)').text()
          fecha = $('#fecha').val()
          $.ajax({
            url: 'bd/evaluar.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id_alumno: id_alumno,
              id_nivel: id_nivel,
              id_etapa: id_etapa,
              id_objetivo: id_objetivo,
              fecha: fecha,
            },

            success: function (data) {
              if (data == 1) {
                objetivos()
              } else if (data == 2) {
                swal
                  .fire({
                    title: '<strong>Objetivos Logrados</strong>',
                    html:
                      'El Alumno ha terminado exitosamente los objetivos de este programa.<br><b>¿Desea Comenzar el proceso de cambio de Etapa o Nivel</b>',

                    showCancelButton: true,
                    icon: 'question',
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',

                    cancelButtonText: 'Cancelar',
                  })
                  .then(function (isConfirm) {
                    if (isConfirm.value) {
                      id_reg = $('#id_reg').val()
                      $.ajax({
                        url: 'bd/cambionivel.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                          id_alumno: id_alumno,
                          id_nivel: id_nivel,
                          id_etapa: id_etapa,
                          id_objetivo: id_objetivo,
                          id_reg: id_reg,
                        },
                        success: function (resp) {
                          if (resp != 0) {
                            Swal.fire({
                              title: 'Alumno Actualizado',
                              icon: 'success',
                            })

                            window.setTimeout(function () {
                              window.location.reload()
                            }, 1000)
                          } else {
                            console.log(resp)
                            Swal.fire({
                              title: '<strong>Programa Terminado</strong>',
                              html:
                                '<b>El alumno ha terminado con exito el programa completo</b> ',

                              icon: 'success',
                            })
                          }
                        },
                      })
                    } else if (
                      isConfirm.dismiss === swal.DismissReason.cancel
                    ) {
                      objetivos()
                    }
                  })
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  $(document).on('click', '.btnactivar', function () {
    fila = $(this).closest('tr')
    swal
      .fire({
        title: 'Objetivo No logrado',
        html: '¿Desea reactivar este objetivo?<br><b> ',

        showCancelButton: true,
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          id_nivel = $('#id_nivel').val()
          id_etapa = $('#etapa').val()
          id_alumno = $('#id').val()
          id_objetivo = fila.find('td:eq(0)').text()
          id_reg = $('#id_reg').val()

          $.ajax({
            url: 'bd/reactivar.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id_alumno: id_alumno,
              id_nivel: id_nivel,
              id_etapa: id_etapa,
              id_objetivo: id_objetivo,
              id_reg: id_reg,
            },

            success: function (data) {
              location.reload()
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })
})

function objetivos() {
  id = $('#id').val()
  id_nivel = $('#id_nivel').val()
  id_etapa = $('#etapa').val()
  tablavis.clear()
  tablavis.draw()

  $.ajax({
    type: 'POST',
    url: 'bd/dbevalini.php',
    dataType: 'json',
    data: { id: id, id_nivel: id_nivel, id_etapa: id_etapa },
    success: function (res) {
      for (var i = 0; i < res.length; i++) {
        if (res[i].valor == 1) {
          icono =
            '<i class="fas fa-swimmer text-success text-center" value="1"></i>'
        } else if (res[i].activo == 1) {
          icono =
            '<i class="fas fa-swimmer text-warning text-center" value="0"></i>'
        } else {
          icono =
            '<i class="fas fa-swimmer text-grey text-center" value="2"></i>'
        }

        tablavis.row
          .add([res[i].id_objetivo, res[i].desc_objetivo, icono, res[i].valor])
          .draw()
      }
    },
  })

  function listar() {
    id = $('#id').val()
    id_nivel = $('#id_nivel').val()
    id_etapa = $('#etapa').val()

    $.ajax({
      type: 'POST',
      url: 'bd/dbevalini.php',
      dataType: 'json',
      data: { id: id, id_nivel: id_nivel, id_etapa: id_etapa },
      success: function (res) {
        var tabla
        for (var i = 0; i < res.length; i++) {
          if (res[i].valor == 1) {
            icono = '<i class="fas fa-swimmer text-success" value="1"></i>'
          } else if (res[i].activo == 1) {
            icono = '<i class="fas fa-swimmer text-warning" value="0"></i>'
          } else {
            icono = '<i class="fas fa-swimmer text-grey" value="2"></i>'
          }
          tabla.rows.addClass
          tabla +=
            '<tr><td>' +
            res[i].id_objetivo +
            '</td><td>' +
            res[i].desc_objetivo +
            '</td><td class="text-center">' +
            icono +
            '</td><td>' +
            res[i].valor +
            '</td><td class="text-center"><button type="button" class="btn btn-success btnEditar"><i class="fas fa-edit"></i>Cambiar</button></td></tr>'
          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
        $('#tbody').html(tabla)
      },
    })
  }
}
