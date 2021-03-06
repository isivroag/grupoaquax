$(document).ready(function() {


    tablavis = $("#tablaV").DataTable({

        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success  btnVer'><i class='fas fa-info-circle'></i> Info</button></div></div>"
        }],

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


        buttons: [{
                extend: 'excelHtml5',
                "text": "<i class='fas fa-file-excel'> Excel</i>",
                "titleAttr": "Exportar a Excel",
                "title": 'Información de Grupo',
                "className": 'btn bg-success ',


            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Información de Grupo',
                "className": 'btn bg-danger',


            }



        ],
        "responsive": true,

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


        //Para cambiar el lenguaje a español

    });

    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "viewalumno.php?id=" + id;
        // nombre = fila.find('td:eq(1)').text();
        // ine = fila.find('td:eq(2)').text();
        // licencia = parseInt(fila.find('td:eq(3)').text());
        // pasaporte = parseInt(fila.find('td:eq(4)').text());
        // otro = parseInt(fila.find('td:eq(5)').text());

        // $("#nombre").val(nombre);
        // $("#ine").val(ine);
        // $("#licencia").val(licencia);
        // $("#pasaporte").val(pasaporte);
        // $("#otro").val(otro);
        // opcion = 2; //editar

        // $(".modal-header").css("background-color", "#007bff");
        // $(".modal-header").css("color", "white");
        // $(".modal-title").text("Editar Visitante");
        //$("#modalCRUD").modal("show");

    });


});