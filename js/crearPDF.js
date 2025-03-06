$(document).ready(function() {
    $('.seleccionar-btn').click(function() {
        var idEquipo = $(this).data('id_equipo');  
        var idNombre = $(this).data('id_nombre');  

        console.log('ID del equipo:', idEquipo);  
        console.log('ID del nombre:', idNombre);  

        // Abrir directamente el PDF en una nueva pestaña con los datos en la URL
        window.open('../../logico/equipo/crearPdf.php?id_equipo=' + encodeURIComponent(idEquipo) + '&id_nombre=' + encodeURIComponent(idNombre), '_blank');
    });
});
