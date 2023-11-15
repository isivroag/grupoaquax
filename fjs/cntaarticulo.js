$(document).ready(function () {
    var id, opcion
    opcion = 4
    $('[data-toggle="tooltip"]').tooltip()


    tabla1 = $('#tabla1').DataTable({
        dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
        {
            extend: 'excelHtml5',
            text: "<i class='fas fa-file-excel'> Excel</i>",
            titleAttr: 'Exportar a Excel',
            title: 'Listado de Clientes',
            className: 'btn bg-success ',
            exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7,8] },
        },
        {
            extend: 'pdfHtml5',
            text: "<i class='far fa-file-pdf'> PDF</i>",
            titleAttr: 'Exportar a PDF',
            title: 'Listado de Clientes',
            className: 'btn bg-danger',
            exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6,7,8] },
        },
    ],


        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
                     <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash-alt'></i></button></div>",
            },
            { className: 'hide_column', targets: [7] },

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

        $('#formDatos').trigger('reset')
        
        $('#modalCRUD').modal('show')
        id = null
        opcion = 1
    })

    $(document).on("click", "#btnCodigos", function () {
   
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));
    
        url = "codigos.php";
    
        window.open(url, "Codigos", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");
    
      });


    $(document).on('click', '.btnEditar', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())

        clave = fila.find('td:eq(1)').text()
        nombre = fila.find('td:eq(2)').text()
        cantidad = fila.find('td:eq(3)').text()
        categoria = fila.find('td:eq(4)').text()
        referencia = fila.find('td:eq(5)').text()
        fecha_alta= fila.find('td:eq(6)').text()

        $('#clave').val(clave)
        $('#nombre').val(nombre)
        $('#cantidad').val(cantidad)
        $('#categoria').val(categoria)
        $('#referencia').val(referencia)
        $('#fecha_alta').val(fecha_alta)
    


        opcion = 2 //editar


        $('.modal-title').text('EDITAR ARTICULO')
        $('#modalCRUD').modal('show')
    })


    $(document).on('click', '.btnBorrar', function () {
        fila = $(this)

        id = parseInt($(this).closest('tr').find('td:eq(0)').text())
        opcion = 3
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
                        url: 'bd/crudarticulo.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id, opcion: opcion },
                        success: function (data) {
                            tabla1.row(fila.parents('tr')).remove().draw()
                        },
                    })
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                }
            })
    })



    $('#formDatos').submit(function (e) {
        e.preventDefault()
        var clave = $('#clave').val()
        var nombre = $('#nombre').val()
        var cantidad = $('#cantidad').val()
        var categoria = $('#categoria').val()
        var referencia = $('#referencia').val()
        var fecha_alta = $('#fecha_alta').val()
    


        if (nombre.length == 0 || clave.length == 0 || fecha_alta.length==0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: 'Debe ingresar todos los datos del articulo',
                icon: 'warning',
            })
            return false
        } else {
            $.ajax({
                url: 'bd/crudarticulo.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    clave: clave,
                    nombre: nombre,
                    cantidad: cantidad,
                    categoria: categoria,
                    referencia: referencia,
                    fecha_alta: fecha_alta,
                    id: id,
                    opcion: opcion,
                },
                success: function (data) {
                    idart = data[0].id_art
                    clave = data[0].clave
                    nombre = data[0].nombre
                    cantidad = data[0].cantidad
                    categoria = data[0].categoria
                    referencia = data[0].referencia
                    fecha_alta = data[0].fecha_alta
                    fecha_baja = data[0].fecha_baja
                    codigo="<img src='barcode.php?text="+clave+"&size=30&type=Code39&print=true' />"

                    if (opcion == 1) {
                        tabla1.row
                            .add([
                                idart,
                                clave,
                                nombre,
                                cantidad,
                                categoria,
                                referencia,
                                fecha_alta,
                                fecha_baja,
                                codigo,

                            ])
                            .draw()
                    } else {
                        tabla1
                            .row(fila)
                            .data([
                                idart,
                                clave,
                                nombre,
                                cantidad,
                                categoria,
                                referencia,
                                fecha_alta,
                                fecha_baja,
                                codigo,
                            ])
                            .draw()
                    }
                },
                error: function(){
                    Swal.fire({
                        title: 'ERROR',
                        
                        icon: 'error',
                    })
                }
            })
            $('#modalCRUD').modal('hide')
        }

    })
})