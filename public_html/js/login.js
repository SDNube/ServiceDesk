async function loginUsuario(event) {
    event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

    const username = document.getElementById('login').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('http://localhost:3000/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();

        if (response.ok) {
            // Inicio de sesión exitoso
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.message
            });
        } else {
            // Credenciales incorrectas
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error en el servidor'
        });
    }
}