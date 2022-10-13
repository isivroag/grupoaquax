$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    $('#tablavis tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Filtrar.." />');
    });


    tablavis = $("#tablavis").DataTable({
     
    fixedHeader: true,
  

    dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


buttons: [{
        extend: 'excelHtml5',
        "text": "<i class='fas fa-file-excel'> Excel</i>",
        "titleAttr": "Exportar a Excel",
        "title": 'Reporte de Grupos',
        "className": 'btn bg-success ',
        orientation: 'landscape',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] }
    },
    {
        extend: 'pdfHtml5',
        "text": "<i class='far fa-file-pdf'> PDF</i>",
        "titleAttr": "Exportar a PDF",
        "title": 'Reporte de Grupos',
        "className": 'btn bg-danger',
        orientation: 'landscape',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] }
    }],


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
        },

        "initComplete": function() {
            this.api().columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            })
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

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudusu.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function() {
                    console.log(data);

                    tablaPersonas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });
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
      
      $('.modal-header').on('mousedown', function (mousedownEvt) {
        var $draggable = $(this)
        var x = mousedownEvt.pageX - $draggable.offset().left,
          y = mousedownEvt.pageY - $draggable.offset().top
        $('body').on('mousemove.draggable', function (mousemoveEvt) {
          $draggable.closest('.modal-dialog').offset({
            left: mousemoveEvt.pageX - x,
            top: mousemoveEvt.pageY - y,
          })
        })
        $('body').one('mouseup', function () {
          $('body').off('mousemove.draggable')
        })
        $draggable.closest('.modal').one('bs.modal.hide', function () {
          $('body').off('mousemove.draggable')
        })
      })
})

;