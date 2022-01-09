$(document).ready(function() {


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
        alumno = $('#id_alumno').val();
        nivel = $('#nnivel').val();
        etapa = $('#netapa').val();

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


    });

    $(document).on("click", ".btnVerEval", function() {

     

    });


});