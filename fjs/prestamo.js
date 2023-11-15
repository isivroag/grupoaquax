$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
  
    var id, opcion
    var operacion = $('#opcion').val()
  
    var textopermiso = permisos()
  
  function permisos() {
      if (operacion == 1) {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      } else {
        columnas = 
        "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }

  
    tablaArticulo = $('#tablaArticulo').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    })
  
    //TABLA DETALLE DE desechables
    tablaDet = $('#tablaDet').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textopermiso,
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
  

  
    $(document).on('click', '#btnGuardar', function () {
      folio = $('#folio').val()
      fecha = $('#fecha').val()
      fecha_salida = $('#fecha_salida').val()
  
      responsable = $('#responsable').val()
      evento = $('#evento').val()
      obs = $('#obs').val()
  
      usuario = $('#nameuser').val()
  
      //tokenid = $('#tokenid').val()
      opcion = $('#opcion').val()
  
     if (
        folio.length != 0 &&
        fecha.length != 0 &&
        responsable.length != 0 &&
        evento.lenght != 0
        
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/crudprestamo.php',
          dataType: 'json',
          data: {
            folio: folio,

            fecha: fecha,
            fecha_salida: fecha_salida,
            
            responsable: responsable,
            evento: evento,
            obs: obs,
       
            usuario: usuario,
            //tokenid: tokenid,
            opcion: opcion,
          },
          success: function (res) {
            if (res == 0) {
              Swal.fire({
                title: 'Error al Guardar',
                text: 'No se pudo guardar los datos del vale de salida',
                icon: 'error',
              })
            } else {
              Swal.fire({
                title: 'Operación Exitosa',
                text: 'Vale de salida registrado',
                icon: 'success',
              })
  
              window.setTimeout(function () {
                window.location.href = 'cntaprestamo.php'
              }, 1500)
            }
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del articulo',
          icon: 'warning',
        })
        return false
      }
    })


    

    $(document).on('click', '#bntAgregar', function () {
        tablaArticulo.clear();
        tablaArticulo.draw();
        
        $('#modalArticulo').modal('show')

        $.ajax({
          type: "POST",
          url: "bd/buscarArticulo.php",
          dataType: "json",
          async:false,
          data: {  },

          success: function(data) {
              for (var i = 0; i < data.length; i++) {
                tablaArticulo.row.add([data[i].id_art,data[i].clave, data[i].nombre,data[i].referencia,]).draw();
              }
          },
      });

        
      })
    
  
    $(document).on('click', '.btnSelConcepto', function () {
      fila = $(this).closest('tr')
      id_art = fila.find('td:eq(0)').text()
      folio=$('#folio').val()
      opcion=1
            

      $.ajax({
        type: 'POST',
        url: 'bd/detalleprestamo.php',
        dataType: 'json',
        data: {
       
          folio: folio,
          id_art: id_art,
          opcion: opcion,
        },
        success: function (data) {

          if(data != 0){

            id_reg = data[0].id_reg
            id_art= data[0].id_art
            clave = data[0].clave
            nombre=data[0].nombre
            referencia=data[0].referencia
            

                tablaDet.row
                    .add([
                        id_reg,
                        id_art,
                        clave,
                        nombre,
                        referencia,
                       ])
                    .draw()
                  
            }
            else{
              swal.fire({
                title: 'Articulo duplicado',
                icon: 'error',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
            }
            $('#modalArticulo').modal('hide')
                                      
        },
        
      })
      
      
    })
   
        //BOTON LIMPIAR DESECHABLE
    $(document).on('click', '#btnLimpiar', function () {
      limpiardes()
    })
  

  
    function limpiar() {
      var today = new Date()
      var dd = today.getDate()
  
      var mm = today.getMonth() + 1
      var yyyy = today.getFullYear()
      if (dd < 10) {
        dd = '0' + dd
      }
  
      if (mm < 10) {
        mm = '0' + mm
      }
  
      today = yyyy + '-' + mm + '-' + dd
  
      $('#id_prov').val('')
      $('#nombre').val('')
      $('#fecha').val(today)
      $('#folio').val('')
      $('#folior').val('')
      $('#id_partida').val('')
      $('#partida').val('')
      $('#ccredito').val(false)
      $('#fechal').val(today)
      $('#cfactura').val(false)
      $('#referencia').val('')
      $('#proyecto').val('')
      $('#subtotal').val('')
      $('#iva').val('')
      $('#total').val('')
      $('#cinverso').val(false)
    }
  
    function limpiardes() {
      $('#iditem').val('')
      $('#cantidaditem').val('')
      $('#nomitem').val('')
      $('#costoitem').val('')
      $('#importeitem').val('')
      $('#descuentoitem').val('')
      $('#gimporteitem').val('')
  
      $('#costoitem').prop('disabled', true)
      $('#cantidaditem').prop('disabled', true)
      $('#descuentoitem').prop('disabled', true)
  
    }
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  
    // BORRAR MATERIAL
    $(document).on('click', '.btnBorrar', function (e) {
      e.preventDefault()
      fila = $(this)
      id_art = parseInt($(this).closest('tr').find('td:eq(1)').text())
      folio=$('#folio').val()
      opcion=2
            

      $.ajax({
        type: 'POST',
        url: 'bd/detalleprestamo.php',
        dataType: 'json',
        data: {
       
          folio: folio,
          id_art: id_art,
          opcion: opcion,
        },
        success: function (data) {
          console.log(data)
          if(data == 1){

            tablaDet.row(fila.parents('tr')).remove().draw()
            tablaDet.row(fila.parents('tr')).remove().draw()

                  
            }
            else{
              swal.fire({
                title: 'Error Al Eliminar',
                icon: 'error',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
            }
                                      
        },
        
      })


    })
  
 
    
  

  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
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
  
  function addCommas(nStr) {
    nStr += ''
    x = nStr.split('.')
    x1 = x[0]
    x2 = x.length > 1 ? '.' + x[1] : ''
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2')
    }
    return x1 + x2
  }
  