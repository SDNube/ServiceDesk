$(document).ready(function () {
    // Función para llenar el select de usuarios
    

    // Función para filtrar los tickets
    function filtrarTickets() {
        let statusSeleccionados = $(".filter-status:checked").map(function () {
            return $(this).val();
        }).get();

        let prioridadesSeleccionadas = $(".filter-priority:checked").map(function () {
            return $(this).val();
        }).get();

        let pathsSeleccionados = $(".filter-path:checked").map(function () {
            return $(this).val();
        }).get();

        let usuarioSeleccionado = $("#filter-user").val();

        $("#ticketsTable tr").each(function () {
            let status = $(this).attr("data-status") || "";
            let prioridad = $(this).attr("data-priority") || "";
            let path = $(this).attr("data-path") || "";
            let asignado = $(this).attr("data-assigned") || "";

            let mostrar =
                (statusSeleccionados.length === 0 || statusSeleccionados.includes(status.trim())) &&
                (prioridadesSeleccionadas.length === 0 || prioridadesSeleccionadas.includes(prioridad.trim())) &&
                (pathsSeleccionados.length === 0 || pathsSeleccionados.includes(path.trim())) &&
                (usuarioSeleccionado === "" || asignado === usuarioSeleccionado);

            $(this).toggle(mostrar);
        });
    }

    // Eventos para los filtros
    $(".filter-status, .filter-priority, .filter-path").on("change", filtrarTickets);
    $("#filter-user").on("change", filtrarTickets);

    $("#buscador").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        $("#ticketsTable tr").filter(function () {
            return $(this).find("td:first").text().toLowerCase().indexOf(value) > -1;
        }).toggle();
    });

    filtrarTickets();

    // Mostrar/Ocultar filtros
    $("#toggle-filters").on("click", function () {
        let filters = $("#filters");
        let button = $(this);

        if (filters.is(":visible")) {
            filters.hide();
            button.text("Mostrar Filtros");
        } else {
            filters.show();
            button.text("Ocultar Filtros");
        }
    });
});
