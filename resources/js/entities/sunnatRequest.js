$(document).ready(function () {
    updateButton();
    $("#tipo_documento_id").change(function () {
        updateButton();
        $("#numero_documento").val("");
    });

    function updateButton() {
        const tipoDocumento = $("#tipo_documento_id").val();
        if (tipoDocumento == 1) {
            $("#btn_buscar_reniec").show();
            $("#btn_buscar_sunat").hide();
            return;
        }
        if (tipoDocumento == 2) {
            $("#btn_buscar_sunat").show();
            $("#btn_buscar_reniec").hide();
            return;
        }

        $("#btn_buscar_sunat").hide();
        $("#btn_buscar_reniec").hide();
    }
    $("#btn_buscar_sunat").click(function () {
        // const tipoDocumento = $("#tipo_documento").val();
        const numeroDocumento = $("#numero_documento").val();
        const api = `${baseUrl}api/sunat/ruc/${numeroDocumento}`;

        if (numeroDocumento.length != 11) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El RUC debe tener 11 dígitos",
            });
            return;
        }

        $.ajax({
            url: api,
            type: "GET",
            headers: ["Content-Type", "application/json"],
            success: function (response) {
                const data = JSON.parse(response);
                console.log(data);
                if (data.ok) {
                    const entidad = data.data;

                    $("#nombre").val(entidad.razonSocial);
                    const direccion =
                        entidad.direccion +
                        " " +
                        entidad.departamento +
                        "-" +
                        entidad.provincia +
                        "-" +
                        entidad.distrito;
                    $("#direccion").val(direccion);
                }
            },
            error: function (error) {
                console.log(error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "No se encontró el RUC",
                });
            },
        });
    });

    $("#btn_buscar_reniec").click(function () {
        // const tipoDocumento = $("#tipo_documento").val();
        const numeroDocumento = $("#numero_documento").val();
        const api = `${baseUrl}api/reniec/dni/${numeroDocumento}`;

        if (numeroDocumento.length != 8) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El DNI debe tener 8 dígitos",
            });
            return;
        }

        $.ajax({
            url: api,
            type: "GET",
            headers: ["Content-Type", "application/json"],
            success: function (response) {
                const data = JSON.parse(response);
                console.log(data);
                if (data.ok) {
                    const entidad = data.data;

                    $("#nombre").val(
                        `${entidad.apellidoPaterno} ${entidad.apellidoMaterno} ${entidad.nombres}`
                    );
                }
            },
            error: function (error) {
                console.log(error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "No se encontró el DNI",
                });
            },
        });
    });
});
