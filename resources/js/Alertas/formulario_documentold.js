(function () {
    const formulario = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');

    if (formulario || formulario2) {
        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = '';
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            window.addEventListener('beforeunload', handleBeforeUnload);

            if (formulario) {
                formulario.addEventListener('submit', function () {
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                });
            }

            if (formulario2) {
                formulario2.addEventListener('submit', function () {
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                });
            }

        });
    }
})();