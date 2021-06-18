$(document).ready(function() {
    var id, opcion;



 
 





    $(document).on("click", "#btnGuardar", function() {
        folio = $("#folio").val();
        fecha = $("#fecha").val();
        fechareg = $("#fechasys").val();
       
        id_caja = $("#id_caja").val();
      
        concepto = $("#concepto").val();
    
        
        total = $("#total").val();
        usuario = $("#nameuser").val();
        opcion = $("#opcion").val();;




        if (total.length != 0 && concepto.length != 0 && id_caja != 0) {
            $.ajax({

                type: "POST",
                url: "bd/crudingresosg.php",
                dataType: "json",
                data: { fecha: fecha,fechareg: fechareg,   concepto: concepto, id_caja: id_caja,
                      total: total, usuario: usuario, folio: folio, opcion: opcion },
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