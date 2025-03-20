$(document).ready(function() {
    $('#buscador').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        
        $('table tbody tr').filter(function() {
            var text = $(this).find('td').eq(0).text().toLowerCase(); // Buscar solo en la columna de ID
            $(this).toggle(text.indexOf(value) > -1);
        });
    })
});

$(document).ready(function () {
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

        $("#ticketsTable tr").each(function () {
            let status = $(this).attr("data-status") || "";
            let prioridad = $(this).attr("data-priority") || "";
            let path = $(this).attr("data-path") || "";

            let mostrar =
                (statusSeleccionados.length === 0 || statusSeleccionados.includes(status.trim())) &&
                (prioridadesSeleccionadas.length === 0 || prioridadesSeleccionadas.includes(prioridad.trim())) &&
                (pathsSeleccionados.length === 0 || pathsSeleccionados.includes(path.trim()));

            $(this).toggle(mostrar);
        });
    }

    $(".filter-status, .filter-priority, .filter-path").on("change", filtrarTickets);

    $("#buscador").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        $("#ticketsTable tr").filter(function () {
            return $(this).find("td:first").text().toLowerCase().indexOf(value) > -1;
        }).toggle();
    });

    filtrarTickets();
});

document.getElementById('toggle-filters').addEventListener('click', function() {
    var filters = document.getElementById('filters');
    var button = document.getElementById('toggle-filters');
    
    if (filters.style.display === 'none') {
        filters.style.display = 'block';
        button.textContent = 'Ocultar Filtros';
    } else {
        filters.style.display = 'none';
        button.textContent = 'Mostrar Filtros';
    }
});
