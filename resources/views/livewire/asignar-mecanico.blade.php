<div>
    @if ($hasMecanic == 0)
        <i  title="Tomar Trabajo" class="text-2xl fa-solid fa-user-plus hover:text-orange-500 cursor-pointer" id="confirm-button-{{ $ot->id }}"></i>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('confirm-button-{{ $ot->id }}').addEventListener('click', function() {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, tomar trabajo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('tomarTrabajo')
                        Swal.fire(
                            'Listo!',
                            'La orden de trabajo fue agregada a tus ordenes de trabajo!',
                            'success'
                        )
                    }
                })
            });
        });
    </script>
</div>
