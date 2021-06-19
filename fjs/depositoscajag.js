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
                url: "bd/cruddepositosg.php",
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






  





   

    function round(value, decimals) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }






})