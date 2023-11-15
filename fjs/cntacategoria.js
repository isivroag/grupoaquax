$(document).ready(function () {
    var id, opcion
    opcion = 4
    $('[data-toggle="tooltip"]').tooltip()


    tabla1 = $('#tabla1').DataTable({

      
        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
                     <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash-alt'></i></button></div>",
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

    $('#btnNuevo').click(function () {

        $('#formDatos').trigger('reset')
        $('#modalCRUD').modal('show')
        id = null
        opcion = 1
    })

 

    $(document).on('click', '.btnEditar', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())

        nombre = fila.find('td:eq(1)').text()
    


        $('#nombre').val(nombre)
       


        opcion = 2 //editar


        $('.modal-title').text('EDITAR CATEGORIA')
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
                        url: 'bd/crudcategoria.php',
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
        var nombre = $('#nombre').val()
    



        if (nombre.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: 'Debe ingresar todos los datos del Prospecto',
                icon: 'warning',
            })
            return false
        } else {
            $.ajax({
                url: 'bd/crudcategoria.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    nombre: nombre,
                    id: id,
                    opcion: opcion,
                },
                success: function (data) {
                    id = data[0].id_cat
                    nombre = data[0].nombre
                  
            
                    if (opcion == 1) {
                        tabla1.row
                            .add([
                                id,
                                nombre,
                            

                            ])
                            .draw()
                    } else {
                        tabla1
                            .row(fila)
                            .data([
                                id,
                                nombre,
                             
                            ])
                            .draw()
                    }
                },
            })
            $('#modalCRUD').modal('hide')
        }
    })
})