import Swal from "sweetalert2";


(function() {
    const empleados = document.querySelectorAll('.empleados');
    
    if (empleados.length > 0) {
        const cupos = document.getElementById('cupos');

        empleados.forEach(empleado => {
            empleado.addEventListener('click', function(e) {
                // Obtener el valor actual de los cupos y convertirlo a número
                let cuposNumero = parseInt(cupos.textContent, 10);

                // Verificar si el empleado ha sido seleccionado o deseleccionado
                if (empleado.classList.contains('bg-orange-600')) {
                    // Si ha sido deseleccionado, sumar un cupo
                    cupos.textContent = cuposNumero + 1;
                    // Alternar las clases de estilo para mostrar que el empleado está deseleccionado
                    empleado.classList.toggle('bg-orange-400');
                    empleado.classList.toggle('hover:bg-orange-600');
                    empleado.classList.toggle('bg-orange-600');
                } else {
                    // Verificar si quedan cupos disponibles
                    if (cuposNumero > 0) {
                        // Si quedan cupos, restar uno
                        cupos.textContent = cuposNumero - 1;
                        // Alternar las clases de estilo para mostrar que el empleado está seleccionado
                        empleado.classList.toggle('bg-orange-400');
                        empleado.classList.toggle('hover:bg-orange-600');
                        empleado.classList.toggle('bg-orange-600');
                    } else {
                        Swal.fire({
                            title: 'Ha ocurrido un error',
                            text: 'No quedan más cupos para agregar',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                          })
                    }
                }
            });
        });
    }
})();
