// Asegúrate de que el DOM esté completamente cargado antes de ejecutar el código
$(document).ready(function() {
    // Cuando se haga clic en el botón de asignar
    $(document).on('click', '.asignar-btn', function() {
        var idEquipo = $(this).data('id_equipo');  // Obtener el id_equipo del botón
        $('#id_equipo').val(idEquipo);  // Asignar el id_equipo al campo oculto del formulario
    });
});
