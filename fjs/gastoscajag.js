$(document).ready(function() {
    var id, opcion;


    tablaVis = $("#tablaV").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


        buttons: [{
                extend: 'excelHtml5',
                "text": "<i class='fas fa-file-excel'> Excel</i>",
                "titleAttr": "Exportar a Excel",
                "title": 'Reporte de Egresos',
                "className": 'btn bg-success ',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Reporte de Egresos',
                "className": 'btn bg-danger',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            }



        ],


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success  btnIngreso'><i class='fas fa-arrow-up'></i> <i class='fas fa-dollar-sign'></i></button>\
            <button class='btn btn-sm bg-purple btnEgreso'><i class='fas fa-arrow-down'></i> <i class='fas fa-dollar-sign'></i></button>\
            <button class='btn btn-sm bg-primary btnMov'><i class='fas fa-bars'></i></button></div></div>"
            
        },{
            "render": function(data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [3]
        }],

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
        }
    });

 
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }



    tablaC = $("#tablaC").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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
        }
    });

    tablaCon = $("#tablaCon").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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
        }
    });

    tablaSub = $("#tablaSub").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelSubpartida'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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
        }
    });


    tablaProv = $("#tablaProv").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelProveedor'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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
        }
    });

    $(document).on("click", "#bproveedor", function() {

        

        $("#modalProveedor").modal("show");

    });
    $(document).on("click", ".btnSelProveedor", function() {
        fila = $(this).closest("tr");

        idprov = fila.find('td:eq(0)').text();
        nomprov = fila.find('td:eq(2)').text();

        opcion = 1;

        $("#id_prov").val(idprov);
        $("#nombre").val(nomprov);
        $("#modalProveedor").modal("hide");

    });


    $(document).on("click", "#bpartida", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalConcepto").modal("show");






    });

    $(document).on("click", "#bsubpartida", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalSubpartida").modal("show");






    });

    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");

        id_partida = fila.find('td:eq(0)').text();
        nompartida = fila.find('td:eq(2)').text();

        opcion = 1;

        $("#id_partida").val(id_partida);
        $("#partida").val(nompartida);
        $("#id_subpartida").val("");
        $("#subpartida").val("");
        $("#modalConcepto").modal("hide");
        listarsubpartida(id_partida);

    });

    $(document).on("click", ".btnSelSubpartida", function() {
        fila = $(this).closest("tr");

        id_subpartida = fila.find('td:eq(0)').text();
        nomsubpartida = fila.find('td:eq(1)').text();

        opcion = 1;

        $("#id_subpartida").val(id_subpartida);
        $("#subpartida").val(nomsubpartida);
        $("#modalSubpartida").modal("hide");


    });



    $(document).on("click", "#btnGuardar", function() {
        folio = $("#folio").val();
        fecha = $("#fecha").val();
        fechareg = $("#fechasys").val();

        id_caja = $("#id_caja").val();
        id_prov = $("#id_prov").val();
        id_partida = $("#id_partida").val();
        id_subpartida = $("#id_subpartida").val();
        concepto = $("#concepto").val();
        documento = $("#documento").val();
        
        referencia = $("#referencia").val();
        
        total = $("#total").val();
        usuario = $("#nameuser").val();
        opcion = $("#opcion").val();;




        if (total.length != 0 && id_prov.length != 0 && concepto.length != 0 && id_partida.length != 0 && id_caja != 0
            && id_subpartida.length != 0 && documento.length!=0) {
            $.ajax({

                type: "POST",
                url: "bd/crudgastog.php",
                dataType: "json",
                data: { fecha: fecha,fechareg: fechareg,  id_partida: id_partida, id_subpartida: id_subpartida, concepto: concepto, id_caja: id_caja,
                    id_prov: id_prov, documento: documento, referencia: referencia,  total: total, usuario: usuario, folio: folio, opcion: opcion },
                success: function(res) {
                    
                    if (res == 0) {
                        Swal.fire({
                            title: 'Error al Guardar',
                            text: "No fue poisible guardar el registro",
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: 'Operación Exitosa',
                            text: "Cuenta por pagar guardada",
                            icon: 'success',
                        })

                        window.setTimeout(function() {
                            window.location.href = "cntacajag.php";
                        }, 1500);

                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Item",
                icon: 'warning',
            })
            return false;
        }
    });




    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");
        idpartida = fila.find('td:eq(0)').text();
        partida = fila.find('td:eq(1)').text();
        $("#id_partida").val(idpartida);
        $("#partida").val(partida);
        $("#modalConcepto").modal("hide");

    });

    $(document).on("click", "#btnNuevo", function() {
        limpiar();
    });






  



    function limpiar() {

        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        today = yyyy + '-' + mm + '-' + dd;


        $("#id_prov").val('');
        $("#nombre").val('');
        $("#fecha").val(today);
        $("#folio").val('');
        $("#folior").val('');
        $("#id_partida").val('');
        $("#id_subpartida").val('');
        $("#partida").val('');
        $("#subpartida").val('');
        $("#ccredito").val(false);
        $("#fechal").val(today);
        $("#cfactura").val(false);
        $("#referencia").val('');
        $("#proyecto").val('');
        $("#subtotal").val('');
        $("#iva").val('');
        $("#total").val('');
        $("#cinverso").val(false);
    };


   

    function round(value, decimals) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }


    function listarsubpartida(id_partida) {
        tablaSub.clear();
        tablaSub.draw();


        $.ajax({
            type: "POST",
            url: "bd/buscarsubpartida.php",
            dataType: "json",
            data: { id_partida: id_partida },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaSub.row
                        .add([res[i].id_subpartida, res[i].nom_subpartida])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }



})