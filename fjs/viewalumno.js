$(document).ready(function() {

    jQuery.ajaxSetup({
        beforeSend: function() {
            $("#div_carga").show();
        },
        complete: function() {
            $("#div_carga").hide();
        },
        success: function() {},
    });

    tablavis = $("#tablaV").DataTable({


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success  btnVer'><i class='fas fa-info-circle'></i> Info</button></div></div>",

        }, {

            "targets": 1,
            "visible": false,
            "searchable": false,
        }],

        "order": [
            [1, "asc"],


        ],
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

    $("#btnVergpo").click(function() {

        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");

        $("#modalgpo").modal("show");


    });

    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "viewgrupo.php?id=" + id;
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

    $(document).on("click", ".btnVerEval", function() {

        id = $("#id_alumno").val();
        console.log(id);

        window.location.href = "regevaluacion.php?id=" + id;


    });

    

    $(document).on("click", "#btnAsignar", function() {
        $('#modalnivel').modal('show')
    })



    $(document).on("click", "#btnCambio", function() {
        $('#modalinstructor').modal('show')
    })



    
    $("#nnivel").change(function () {
        listar();
    });

 


    function listar() {
        id = $('#nnivel').val();
        var stipo = $("#netapa");
        stipo.empty();


        $.ajax({
            type: "POST",
            url: "bd/buscaretapa.php",
            dataType: "json",
            data: { id: id },
            success: function (res) {

                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {

                        idetapa = res[i].id_etapa;
                        etapa = res[i].nom_etapa;

                        stipo.append('<option id="' + idetapa + '" value="' + idetapa + '">' + idetapa +" "+ etapa + '</option>');

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                } else {
                    stipo.empty();
                }
               
            }

        });
    }

    $(document).on("click", "#btnGuardar", function() {
   
   
        swal.fire({
            title: '<strong>¿DESEA ASIGNAR EL NIVEL Y LA ETAPA SELECIONADO ?</strong>',
            html:'<p clas="justify-content-center">Esta operación reiniciará al alumno,<br> y los objetivos de niveles y etapas anteriores serán marcados como logrados con fecha de hoy.<br><b>Y las planeaciones y evalaciones serán eliminadas</b><p>',
            showCancelButton: true,
            customClass: 'swal-wide',
            icon: 'warning',
            focusConfirm: true,
            confirmButtonColor:'#48AB30',

            confirmButtonText: 'Aceptar',
            cancelButtonColor:'#d33',
            cancelButtonText: 'Cancelar',
          }).then(function (isConfirm) {
        
            if (isConfirm.value) {
             
                alumno = $('#id_alumno').val();
                nivel = $('#nnivel').val();
                etapa = $('#netapa').val();
                console.log(alumno)
                console.log(nivel)
                console.log(etapa)
        
                if (alumno.length == 0 || nivel.length ==0 || etapa.length==0) {
                    Swal.fire({
                        title: 'Datos Faltantes',
                        text: "Debe ingresar todos los datos del Requeridos",
                        icon: 'warning',
                    })
                    return false;
                }else{
                    $.ajax({
                        url: "bd/asignarnivel.php",
                        type: "POST",
                        dataType: "json",
                        data: { alumno: alumno, nivel: nivel, etapa: etapa },
                        success: function(res) {
                          
                           
        
                            if (res == 1) {
        
        
                                Swal.fire({
                                    title: 'Nivel Asignado',
                                    icon: 'success',
                                })
        
                                window.setTimeout(function() {
                                    window.location.href="viewalumno.php?id="+alumno
                                }, 2500);
                            
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: "No fue posible Asignar el nivel al Alumno",
                                    icon: 'warning',
                                })
                            }
                        }
                    });
                }
       
            } 
            else if (isConfirm.dismiss === swal.DismissReason.cancel) 
            {
           
          
            }
          })
        
   
   
   
   
   /**/
   


    });


    $(document).on("click", "#btnGuardarins", function() {
        alumno = $('#id_alumno').val();
        instructor = $('#ninstructor').val();
      

        if (alumno.length == 0 || instructor.length ==0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Requeridos",
                icon: 'warning',
            })
            return false;
        }else{
            $.ajax({
                url: "bd/asignarinstructor.php",
                type: "POST",
                dataType: "json",
                data: { alumno: alumno, instructor: instructor},
                success: function(res) {
                  
                   

                    if (res == 1) {


                        Swal.fire({
                            title: 'Instructor Asignado',
                            icon: 'success',
                        })

                        window.setTimeout(function() {
                            window.location.href="viewalumno.php?id="+alumno
                        }, 2500);
                    
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "No fue posible Asignar el Instructor al Alumno",
                            icon: 'warning',
                        })
                    }
                }
            });
        }
    });

});