(function () {
    const formulario = document.getElementById("formulario5");
    const formulario2 = document.getElementById("formulario4");

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
})();
