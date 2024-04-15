$(document).ready(function() {
    // Validación del formulario al enviar
    $("#voteForm").submit(function(event) {
        event.preventDefault();

        const rut = $("#rut").val();
        if (!validateRutChileno(rut)) {
            alert("El RUT chileno ingresado no es válido.");
            return;
        }

        const email = $("#email").val();
        if (!validateEmail(email)) {
            alert("El email ingresado no es válido.");
            return;
        }

        // Resto del código para enviar el formulario
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "includes/submit_vote.php",
            data: formData,
            success: function(response) {
                // Limpiar los campos del formulario
                $("#voteForm")[0].reset();
                // Mostrar un mensaje de confirmación
                $("#result").html("<div class='success-message'>Voto registrado correctamente.</div>");
                // Actualizar la página después de un breve intervalo
                setTimeout(function() {
                    location.reload();
                }, 2000); // 2000 milisegundos = 2 segundos
            }
        });
    });

    // Función para validar el email
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Función para validar el RUT chileno
    function validateRutChileno(rut) {
        rut = rut.replace(/\./g, '').replace('-', '').toUpperCase();
        // Verificar que el RUT tenga al menos 8 caracteres
        if (rut.length < 8) {
            return false;
        }
        // Extraer el dígito verificador
        const dv = rut.slice(-1);
        // Extraer los dígitos del RUT (sin el dígito verificador)
        const rutSinDV = rut.slice(0, -1);
        // Calcular el dígito verificador esperado
        let suma = 0;
        let multiplicador = 2;
        for (let i = rutSinDV.length - 1; i >= 0; i--) {
            suma += parseInt(rutSinDV.charAt(i)) * multiplicador;
            multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
        }
        const resto = suma % 11;
        let dvEsperado = 11 - resto;
        if (dvEsperado === 11) {
            dvEsperado = '0';
        } else if (dvEsperado === 10) {
            dvEsperado = 'K';
        } else {
            dvEsperado = dvEsperado.toString();
        }
        // Comparar el dígito verificador esperado con el ingresado
        return dvEsperado === dv;
    }

    // Eventos de cambio para las regiones y comunas
    $("#region").change(function() {
        var regionId = $(this).val();
        $("#comuna option").hide();
        $("#comuna option[data-region='" + regionId + "']").show();
        $("#comuna option[value='']").show();
        $("#candidato option").hide();
        $("#candidato option[data-region='" + regionId + "']").show();
        $("#candidato option[value='']").show();
    });

    $("#comuna").change(function() {
        var comunaId = $(this).val();
        $("#candidato option").hide();
        $("#candidato option[data-comuna='" + comunaId + "']").show();
        $("#candidato option[value='']").show();
    });
});
