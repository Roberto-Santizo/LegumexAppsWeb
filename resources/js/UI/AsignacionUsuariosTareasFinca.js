import Swal from "sweetalert2";

(function() {
    const empleados = document.querySelectorAll('.empleados');
    
    if (empleados.length > 0) {
        const cupos = document.getElementById('cupos');
        const tarealote_id = document.getElementById('tarealote_id').value;
        const asignadosContainer = document.getElementById('usuariosAsignadosContainer');
        const disponiblesContainer = document.getElementById('disponiblesContainer');

        empleados.forEach(empleado => {
            empleado.addEventListener('click', async function(e) {
                const usuario_id = empleado.querySelector('#usuario_id').value;
                const cuposNumero = parseInt(cupos.textContent, 10);

                if (empleado.classList.contains('selected')) {
                    // Desasignar
                    const success  = await handleAssignment('/api/tarea/usuario/desasignar', usuario_id, tarealote_id);

                    if(success){
                        cupos.textContent = cuposNumero + 1;
                        empleado.classList.toggle('selected');
                        empleado.classList.toggle('not-selected');
                        disponiblesContainer.appendChild(empleado);
                    }
                } else {
                    // Verificar cupos y asignar
                    if (cuposNumero > 0) {
                        const success = await handleAssignment('/api/tarea/usuario/asignar', usuario_id, tarealote_id);

                        if(success){
                            cupos.textContent = cuposNumero - 1;
                            empleado.classList.toggle('not-selected');
                            empleado.classList.toggle('selected');
                            asignadosContainer.appendChild(empleado);
                        }
                        
                    } else {
                        Swal.fire({
                            title: 'Ha ocurrido un error',
                            text: 'No quedan más cupos para agregar',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        });
    }

    async function handleAssignment(url, usuario_id, tarealote_id) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const datos = new FormData();
        datos.append('usuario_id', usuario_id);
        datos.append('tarealote_id', tarealote_id);
        console.log(usuario_id,tarealote_id);

        try {
            const respuesta = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: datos
            });
            const resultado = await respuesta.json();

            if (resultado.status) {
                return true;
            }else{
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: resultado.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return false;
            }
        } catch (error) {
            Swal.fire({
                title: 'Ha ocurrido un error',
                text: 'Intentelo de nuevo más tarde',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    }
})();
