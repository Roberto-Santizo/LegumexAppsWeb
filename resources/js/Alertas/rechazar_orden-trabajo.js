import Swal from "sweetalert2";

(function(){

    const deleteOTForms = document.querySelectorAll('.reject-ot');

    if(deleteOTForms.length > 0){
        deleteOTForms.forEach(form => {
            form.addEventListener('submit',function(e){
                e.preventDefault();

                Swal.fire({
                    title: "Deseas rechazar la orden de trabajo?",
                    showCancelButton: true,
                    confirmButtonText: "Rechazar",
                  }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                  });
            })
        });
    }
})();