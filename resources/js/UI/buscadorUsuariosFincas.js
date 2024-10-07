(function(){
    const buscadorUsuario = document.getElementById('buscarUsuario');

    if(buscadorUsuario){
        document.getElementById('buscarUsuario').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const empleados = document.querySelectorAll('.empleadosBuscar');
        
            empleados.forEach(function(empleado) {
                const nombre = empleado.querySelector('p').textContent.toLowerCase();
                if (nombre.includes(query)) {
                    empleado.style.display = 'block'; // Mostrar el usuario si coincide con la búsqueda
                } else {
                    empleado.style.display = 'none'; // Ocultar el usuario si no coincide
                }
            });
        });
    }
})();
