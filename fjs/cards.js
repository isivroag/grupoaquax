$(document).ready(function() {
    var id, opcion;
    opcion = 4;

 
   
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

});