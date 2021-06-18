

$(document).ready(function () {
    var id, opcion
    opcion = 4

    

    $('#tablaV thead tr').clone(true).appendTo('#tablaV thead');
    $('#tablaV thead tr:eq(1) th').each(function (i) {


        var title = $(this).text();


        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="' + title + '" />');

        $('input', this).on('keyup change', function () {

            if (i == 3) {


                valbuscar = this.value;
            } else {
                valbuscar = this.value;

            }

            if (tablaVis.column(i).search() !== valbuscar) {
                tablaVis
                    .column(i)
                    .search(valbuscar, true, true)
                    .draw();
            }
        });
    });


    tablaVis = $('#tablaV').DataTable({
        dom:
            "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "columnDefs": [
           
            {
                "render": function(data, type, row) {
                    return commaSeparateNumber(data,1);
                },
                "targets": [5]
            },
            {
                "render": function(data, type, row) {
                    return commaSeparateNumber(data,1);
                },
                "targets": [6]
            },
            {
                "render": function(data, type, row) {
                    return commaSeparateNumber(data,1);
                },
                "targets": [7]
            }
           
            ],
            rowCallback: function (row, data) {
                $($(row).find('td')['0']).addClass('text-center')
                $($(row).find('td')['1']).addClass('text-center')
                $($(row).find('td')['2']).addClass('text-center')
                
                
                $($(row).find('td')['8']).addClass('text-center')
                
                $($(row).find('td')['5']).addClass('text-right')
                $($(row).find('td')['6']).addClass('text-right text-bold')
                $($(row).find('td')['7']).addClass('text-right ')
                $($(row).find('td')['8']).addClass('text-center')
                $($(row).find('td')['9']).addClass('text-center')
                
                if (data[3] == 'INGRESO') {
                    //$($(row).find("td")[6]).css("background-color", "warning");
                    $($(row).find('td')[3]).addClass('bg-gradient-success')
                    $($(row).find('td')[6]).addClass('bg-gradient-success text-light')
                    //$($(row).find('td')['9']).text('PENDIENTE')
                  } else if (data[3] == 'EGRESO') {
                    //$($(row).find("td")[3]).css("background-color", "blue");
                    $($(row).find('td')[3]).addClass('bg-gradient-purple')
                    $($(row).find('td')[6]).addClass('bg-gradient-purple text-light')
                    //$($(row).find('td')['7']).text('ENVIADO')
                  } else if (data[3] == 'DEPOSITO BANCO') {
                    //$($(row).find("td")[3]).css("background-color", "success");
                    $($(row).find('td')[3]).addClass('bg-lightblue')
                    $($(row).find('td')[6]).addClass('bg-lightblue text-light')
                    //$($(row).find('td')['7']).text('ACEPTADO')
                  }else if (data[3] == 'INICIAL') {
                    //$($(row).find("td")[3]).css("background-color", "success");
                    $($(row).find('td')[3]).addClass('bg-primary')
                    $($(row).find('td')[6]).addClass('bg-primary text-light')
                    //$($(row).find('td')['7']).text('ACEPTADO')
                  }
            
    
            },

        buttons: [
            {
                extend: 'excelHtml5',
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: 'Exportar a Excel',
                title: 'Reporte de Presupuestos',
                className: 'btn bg-success ',
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5,6,7,8],
                    /*format: {
                      body: function (data, row, column, node) {
                        if (column === 5) {
                          return data.replace(/[$,]/g, '')
                        } else if (column === 6) {
                          return data
                        } else {
                          return data
                        }
                      },
                    },*/
                },
            },
            {
                extend: 'pdfHtml5',
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: 'Exportar a PDF',
                title: 'Reporte de Presupuestos',
                className: 'btn bg-danger',
                exportOptions: { columns: [0, 1, 2, 3,4,5,6,7,8] },
                format: {
                    body: function (data, row, column, node) {
                        if (column === 3) {

                            return data
                        } else {
                            return data
                        }
                    },
                },
            },
        ],
        stateSave: false,
        orderCellsTop: true,
        fixedHeader: true,
        paging: false,
        order: [[ 0, "desc" ],],



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

      


    });

    function commaSeparateNumber(val,opc) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
        }
        if (opc==1){
            val = '$ ' + val
        }
        
        
        return val
    }

    var fila //capturar la fila para editar o borrar el registro




    buscarbanco()
    
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

    $('#btnBuscar').click(function () {
        buscarbanco()
    });

    function buscarbanco(){
        var banco = $('#tcuenta').val()
        
        tablaVis.clear()
        tablaVis.draw()


        if (banco != '' ) {
            $.ajax({
                type: 'POST',
                url: 'bd/buscarbanco.php',
                dataType: 'json',
                data: { banco:banco },
                success: function (data) {
                    $("#saldocuenta").val(commaSeparateNumber(data));
                    }
                },
            );

            $.ajax({
                type: 'POST',
                url: 'bd/buscarmovb.php',
                dataType: 'json',
                data: { banco:banco },
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                       
                        tablaVis.row
                            .add([
                                data[i].id_mov,
                                data[i].fecha_mov,
                                data[i].fecha_reg,
                                data[i].tipo_mov,
                                data[i].concepto_mov,
                                data[i].saldo_ini,
                                data[i].monto_mov,
                                data[i].saldo_fin,
                                data[i].folio_gastog,
                                data[i].folio_ingresog
                                
                            ])
                            .draw()

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });
        } else {
            alert('Selecciona una cuenta')
        }
    }

 

})


