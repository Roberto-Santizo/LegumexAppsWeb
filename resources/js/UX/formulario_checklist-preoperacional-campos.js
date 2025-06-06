import { quitarAlertas } from "../helpers";
(function () {
    const checks = document.querySelectorAll('.table__check');
    const formulario = document.getElementById('formularioCP');

    if (formulario) {

        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = '';
        }

        window.addEventListener('beforeunload', handleBeforeUnload);
        checks.forEach(check => {
            check.addEventListener('change', function () {
                const problema = document.querySelector(`.problem-${check.dataset.id}`);
                const action = document.querySelector(`.action-${check.dataset.id}`);
                const responsable = document.querySelector(`.responsable-${check.dataset.id}`);
                if (!check.checked) {
                    problema.disabled = false;
                    action.disabled = false;
                    responsable.disabled = false;


                    responsable.classList.toggle('hidden');
                    responsable.classList.toggle('block');
                } else {
                    problema.disabled = true;
                    action.disabled = true;

                    problema.value = '';
                    action.value = '';

                    quitarAlertas(problema.parentElement);
                    quitarAlertas(action.parentElement);

                    responsable.classList.toggle('hidden');
                    responsable.classList.toggle('block');
                }
            })
        });
    }

})();