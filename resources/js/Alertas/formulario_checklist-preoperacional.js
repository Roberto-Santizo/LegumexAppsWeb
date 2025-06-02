(function () {
    const formulario = document.getElementById("formularioP1");
    const formulario2 = document.getElementById("formularioP2");
    const formulario3 = document.getElementById("formularioP3");

    if (formulario) {
        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario.addEventListener("submit", function () {
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }

    if (formulario2) {
        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario2.addEventListener("submit", function () {
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }

    if (formulario3) {
        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = "";
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            window.addEventListener("beforeunload", handleBeforeUnload);

            formulario3.addEventListener("submit", function () {
                window.removeEventListener("beforeunload", handleBeforeUnload);
            });
        });
    }
})();
