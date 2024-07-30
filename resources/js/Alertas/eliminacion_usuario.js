import Swal from "sweetalert2";

(function(){

    const deleteFormsUsers = document.querySelectorAll('.delete-user');

    if(deleteFormsUsers.length > 0){
        deleteFormsUsers.forEach(form => {
            form.addEventListener('submit',function(e){
                e.preventDefault();

                Swal.fire({
                    title: "Deseas eliminar el usuario?",
                    showCancelButton: true,
                    confirmButtonText: "Eliminar",
                  }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                  });
            })
        });
    }
})();