import Swal from "sweetalert2";

(function(){
    const status_usuario = document.querySelectorAll('.status_usuario');

    if(status_usuario){
        status_usuario.forEach(formulario => {
            formulario.addEventListener('submit',function(e){
                e.preventDefault();
                const estado = e.target.querySelector('input[type="submit"]').dataset.status;
                
                const title = (estado == 0) ? '¿Deseas habilitar este usuario?' : '¿Deseas inhabilitar este usuario?'; 
                const text = (estado == 0) ? 'Al habilitar el usuario será seleccionable para relación de documentos' : 'Al inhabilitar al usuario no se podrá relacionar con otro proceso'; 
                const confirmText = (estado == 0) ? 'Si, habilitarlo' : 'Si, deshabilitarlo'; 
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            })
        });
    }

})();