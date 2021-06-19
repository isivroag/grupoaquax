$(document).ready(function() {
    var id, opcion;


    tablaVis = $("#tablaV").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group text'l><'col-sm-12 col-md-4 form-group text-center'B><'col-sm-12 col-md-4 form-group'f>>" +
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
            <button class='btn btn-sm bg-info btnbanco'><i class='fas fa-university'></i></button>\
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


 

    $(document).on("click", ".btnMov", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "movcajag.php?id=" + id;
      
        

    });

    $(document).on("click", ".btnbanco", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "depositoscajag.php?idcaja=" + id;
      
        

    });
    $(document).on("click", ".btnIngreso", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "ingresoscajag.php?idcaja=" + id;
      
        

    });

    $(document).on("click", ".btnEgreso", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        
        window.location.href = "gastoscajag.php?idcaja=" + id;
     

    });

    $(document).on("click", ".btnMov", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        
        

    });

 



})