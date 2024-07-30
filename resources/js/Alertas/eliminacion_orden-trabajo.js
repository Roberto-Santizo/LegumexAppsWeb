import Swal from "sweetalert2";

(function(){

    const deleteOTForms = document.querySelectorAll('.delete-ot');

    if(deleteOTForms.length > 0){
        deleteOTForms.forEach(form => {
            form.addEventListener('submit',function(e){
                e.preventDefault();

                Swal.fire({
                    title: "Deseas eliminar la orden de trabajo?",
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