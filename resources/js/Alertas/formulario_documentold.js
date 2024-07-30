(function(){
    const formulario = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');

    if(formulario || formulario2){
        // Función para manejar el evento beforeunload
        function handleBeforeUnload(e) {
            // Cancela el evento
            e.preventDefault();
            // Establece el valor de retorno del evento
            e.returnValue = '';
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            // Agregar el event listener para beforeunload
            window.addEventListener('beforeunload', handleBeforeUnload);

            if(formulario){
                formulario.addEventListener('submit', function () {
                    // Remover el event listener para beforeunload
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                });
            }

            if(formulario2){
                formulario2.addEventListener('submit', function () {
                    // Remover el event listener para beforeunload
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                });
            }
            
        });
    }
})();