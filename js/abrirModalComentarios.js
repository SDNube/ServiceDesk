function abrirModalComentarios(idTicket) {
    console.log('Abriendo modal para idTicket:', idTicket);
    
    fetch(`../../modales/tickets/modalComentarios.php?idTicket=${idTicket}`)
        .then(response => {
            console.log('Respuesta completa del servidor:', response);
            return response.text().then(text => {
                console.log('Texto recibido del servidor:', text);
                try {
                    return JSON.parse(text);
                } catch (error) {
                    console.error('La respuesta del servidor no es JSON válido:', text);
                    throw new Error('Error al procesar la respuesta del servidor. Verifique la respuesta en la consola.');
                }
            });
        })
        .then(data => {
            console.log('Datos recibidos al abrir modal:', data);
            if (data.error) {
                console.error('Error en la respuesta:', data.error);
                
                return;
            }
            
            let tablaHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                tablaHTML = '<tr><td colspan="4">No hay comentarios</td></tr>';
            } else {
                data.forEach((comentario, index) => {
                    tablaHTML += `<tr>
                        <td>${index + 1}</td>
                        <td>${comentario.vista}</td>
                        <td>${comentario.mensaje}</td>
                        <td>${comentario.fecha}</td>
                    </tr>`;
                });
            }
            document.getElementById('tablaComentarios').innerHTML = tablaHTML;
            document.getElementById('modalComentariosLabel').textContent = `Historial de Comentarios - Ticket: ${idTicket}`;
            
            let modal = new bootstrap.Modal(document.getElementById('modalComentarios'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos de comentarios:', error);
            
        });

    document.querySelector('.btn-primary').addEventListener('click', () => {
        const mensaje = document.getElementById('nuevoComentario').value.trim();
        if (!mensaje) {
            
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
                abrirModalComentarios(idTicket);
                document.getElementById('nuevoComentario').value = '';
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalComentarios'));
                modal.hide();
            } else {
                
            }
        })
        .catch(error => {
            console.error('Error al enviar el comentario:', error);
            
        });
    });
}



// Código HTML de la modal
const modalHTML = `
<div class="modal fade" id="modalComentarios" tabindex="-1" aria-labelledby="modalComentariosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalComentariosLabel">Historial de Comentarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estado</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="tablaComentarios">
                        <!-- Comentarios se llenarán dinámicamente -->
                    </tbody>
                </table>
                <div class="mb-3">
                    <label for="nuevoComentario" class="form-label">Agregar Comentario</label>
                    <textarea class="form-control" id="nuevoComentario" rows="3" maxlength="200"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Comentario</button>
            </div>
        </div>
    </div>
</div>`;

document.body.insertAdjacentHTML('beforeend', modalHTML);
