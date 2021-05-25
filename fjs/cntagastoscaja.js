$(document).ready(function () {
    var id, opcion
    opcion = 4

    tablaVis = $('#tablaV').DataTable({
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
                exportOptions: { columns: [0,1, 2, 3, 4 ] },
            },
            {
                extend: 'pdfHtml5',
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: 'Exportar a PDF',
                title: 'Reporte de Egresos',
                className: 'btn bg-danger',
                exportOptions: { columns: [0,1, 2, 3, 4] },
            },
        ],

        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>",
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
                url: 'bd/buscargastoscaja.php',
                dataType: 'json',
                data: { inicio: inicio, final: final },
                success: function (data) {
                  
                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].folio_gto,
                                data[i].fecha,
                                data[i].referencia,
                                data[i].concepto,
                                data[i].total,

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

    $('#btnNuevo').click(function () {
        $('#formDatos').trigger('reset')
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");
        $('#modalN').modal('show')
        id = null
        opcion = 1 //alta
    })

    var fila //capturar la fila para editar o borrar el registro

    //botón EDITAR
    $(document).on('click', '.btnEditar', function () {
        fila = $(this).closest("tr");
        id =  parseInt($(this).closest("tr").find("td:eq(0)").text());
        fecha=$(this).closest("tr").find("td:eq(1)").text();
        referencia=$(this).closest("tr").find("td:eq(2)").text();
        concepto=$(this).closest("tr").find("td:eq(3)").text();
        total=$(this).closest("tr").find("td:eq(4)").text();
        $('#formDatos').trigger('reset')
        $('#fecha').val(fecha);
        $('#referencia').val(referencia);
        $('#concepto').val(concepto);
        $('#total').val(total);
        
        $('#modalN').modal('show')

        opcion = 2
    })

    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
        fila = $(this);
        id = parseInt($(this).closest('tr').find('td:eq(0)').text())
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        swal
        .fire({
            title: "Borrar",
            text: "¿Realmente desea borrar este Registro?",
            showCancelButton: true,
            icon: "warning",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        })
        .then(function (isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: 'bd/crudgastoscaja.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, opcion: opcion },
    
                    success: function (data) {
                        if (data == '1') {
                            tablaVis.row(fila.parents('tr')).remove().draw()
                        }
                    },
                })
            } else if (isConfirm.dismiss === swal.DismissReason.cancel) { }
        });

     
    })

    $("#formDatos").submit(function(e) {
        e.preventDefault();
        fecha = $('#fecha').val();
        referencia = $('#referencia').val();
        concepto = $('#concepto').val();
        total = $('#total').val();
        usuario=$('#nameuser').val();
     

        if (fecha.length == 0 || concepto.length == 0 || total.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos de la cuenta",
                icon: 'warning',
            })
            return false;
        } else {
         
            $.ajax({
                url: 'bd/crudgastoscaja.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    fecha: fecha,
                    referencia: referencia,
                    concepto: concepto,
                    total: total,
                    opcion: opcion,
                    id: id,
                    usuario: usuario
                },

                success: function (data) {
                   
                    id = data[0].folio_gto;
                    fecha = data[0].fecha;
                    referencia = data[0].referencia;
                    concepto = data[0].concepto;
                    total = data[0].total;

                    if (opcion == 1) {
                        tablaVis.row.add([id, fecha,referencia,concepto, total,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, fecha,referencia,concepto, total,]).draw();
                    }
                    $('#modalN').modal('hide')
                },
            })
        }
    })

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
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        'formatted-num-pre': function (a) {
            a = a === '-' || a === '' ? 0 : a.replace(/[^\d\-\.]/g, '')
            return parseFloat(a)
        },

        'formatted-num-asc': function (a, b) {
            return a - b
        },

        'formatted-num-desc': function (a, b) {
            return b - a
        },
    })
})
