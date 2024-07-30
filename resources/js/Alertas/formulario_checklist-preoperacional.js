(function () {
    const formulario = document.getElementById("formularioP1");
    const formulario2 = document.getElementById("formularioP2");
    const formulario3 = document.getElementById("formularioP3");

    if (formulario) {
        // Función para manejar el evento beforeunload
        function handleBeforeUnload(e) {
            // Cancela el evento
            e.preventDefault();
            // Establece el valor de retorno del evento
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            // Agregar el event listener para beforeunload
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario.addEventListener("submit", function () {
                // Remover el event listener para beforeunload
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }

    if (formulario2) {
        // Función para manejar el evento beforeunload
        function handleBeforeUnload(e) {
            // Cancela el evento
            e.preventDefault();
            // Establece el valor de retorno del evento
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            // Agregar el event listener para beforeunload
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario2.addEventListener("submit", function () {
                // Remover el event listener para beforeunload
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }

    if (formulario3) {
        // Función para manejar el evento beforeunload
        function handleBeforeUnload(e) {
            // Cancela el evento
            e.preventDefault();
            // Establece el valor de retorno del evento
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            // Agregar el event listener para beforeunload
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario3.addEventListener("submit", function () {
                // Remover el event listener para beforeunload
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }
})();
