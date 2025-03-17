document.querySelector('.btn-primary').addEventListener('click', () => {
    const mensaje = document.getElementById('nuevoComentario').value.trim();
    const idTicket = document.getElementById('modalComentarios').getAttribute('data-id-ticket');  // Asegúrate de agregar el idTicket al modal

    if (!mensaje) {
        console.error('El mensaje está vacío');
        return;
    }

    console.log('Enviando mensaje:', mensaje);
    console.log('ID del ticket:', idTicket);

    fetch('../../logico/tickets/agregarComentario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            idTicket: idTicket,
            mensaje: mensaje,
        })
    })
    .then(response => {
        console.log('Respuesta completa del servidor:', response);
        return response.text().then(text => {
            console.log('Texto recibido del servidor:', text);
            if (text.trim().startsWith('<')) {
                console.error('Se recibió una respuesta HTML inesperada:', text);
                throw new Error('El servidor devolvió una respuesta incorrecta. Verifique si hay errores en el backend.');
            }
            try {
                return JSON.parse(text);
            } catch (error) {
                console.error('La respuesta del servidor no es JSON válido:', text);
                throw new Error('Error al procesar la respuesta del servidor. Verifique la respuesta en la consola.');
            }
        });
    })
    .then(responseData => {
        console.log('Respuesta al guardar comentario:', responseData);
        if (responseData.success) {
            abrirModalComentarios(idTicket);  // Vuelve a cargar los comentarios
            document.getElementById('nuevoComentario').value = '';  // Limpiar el campo de comentario
            let modal = bootstrap.Modal.getInstance(document.getElementById('modalComentarios'));
            modal.hide();  // Cerrar el modal
        } else {
            console.error('Error al guardar el comentario:', responseData.message);
            alert('Hubo un problema al guardar el comentario: ' + responseData.message);
        }
    })
    .catch(error => {
        console.error('Error al enviar el comentario:', error);
        alert('Error al enviar el comentario. Verifique la consola para más detalles.');
    });
});
